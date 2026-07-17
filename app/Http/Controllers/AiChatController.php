<?php

namespace App\Http\Controllers;

use App\Models\AiChat;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Gate; 

class AiChatController extends Controller
{
    /**
     * Display the chat interface for a specific document.
     */
    public function show(Document $document)
    {
        // 🌟 خطوة 2: التحقق من الصلاحية قبل عرض المحادثة
        Gate::authorize('view', $document);

        $chats = $document->aiChats()->oldest()->get();
        $analysis = $document->analyses()->latest()->first();

        return view('intelligence.chatAi', compact('document', 'chats', 'analysis'));
    }
/**
     * Send the user's prompt along with the document context to the AI model.
     */
    public function sendMessage(Request $request, Document $document)
    {
        // التحقق من الصلاحية قبل إرسال الرسالة وحفظها في قاعدة البيانات
        Gate::authorize('view', $document);

        $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        $contractContent = $document->extracted_text ?? '';

        // تقصير النص لتفادي تجاوز الحد المسموح
        $maxChars = 12000;
        if (mb_strlen($contractContent) > $maxChars) {
            $contractContent = mb_substr($contractContent, 0, $maxChars)
                . "\n\n[...تم اقتطاع باقي النص بسبب حجم الطلب...]";
        }

        try {
            // برومت واضح ومحدد يستخرج القيمة الأساسية المستهدفة
            $systemPrompt = "You are 'LexiGuard AI', an elite document analysis assistant. Answer the user's question based strictly on the text provided below.\n\n"
              . "DOCUMENT TEXT:\n"
              . "--- START ---\n"
              . $contractContent
              . "\n--- END ---\n\n"
              . "INSTRUCTIONS:\n"
              . "1. Respond in the same language as the user's question (Arabic or English).\n"
              . "2. You MUST return a JSON object with exactly two fields:\n"
              . "   - \"answer\": Your professional, fluent answer based on the text.\n"
              . "   - \"quote\": Extract ONLY the exact core keyword, phrase, or numerical value (1 to 4 words max) from the text that answers the question (e.g., if asked about duration, return '14 يوم'; if asked about framework, return 'Laravel').\n\n"
              . "OUTPUT FORMAT:\n"
              . "{\n"
              . "  \"answer\": \"your_answer_here\",\n"
              . "  \"quote\": \"core_keyword_or_phrase_here\"\n"
              . "}";

            $response = Http::withToken(config('services.groq.key'))
                ->timeout(60)
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama-3.3-70b-versatile', 
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $request->message]
                    ],
                    'temperature' => 0.1, 
                    'max_tokens' => 1200,
                    'response_format' => ['type' => 'json_object'],
                ]);

            if ($response->failed()) {
                Log::error('Groq API Connection Failed', ['status' => $response->status()]);
                return response()->json(['error' => 'Failed to process request with AI service.'], 500);
            }

            $aiData = $response->json();
            $rawContent = $aiData['choices'][0]['message']['content'] ?? null;

            $parsed = json_decode(trim($rawContent), true);
            $aiResponse = $parsed['answer'] ?? ($rawContent ?: 'Unable to parse an answer.');
            $extractedKeyword = trim($parsed['quote'] ?? '');

            // 🌟 السحر البرمجي المطور: تنظيف الكلمة المستخرجة والنص الأصلي من الرموز المخفية لتسهيل المطابقة
            $finalSourceQuote = null;
            if (!empty($extractedKeyword)) {
                // إزالة علامات اتجاه النص والرموز الغريبة من الكلمة المفتاحية للبحث السليم
                $cleanKeyword = preg_replace('/[\x{200E}\x{200F}\x{202A}-\x{202E}]/u', '', $extractedKeyword);
                $cleanKeyword = trim(preg_replace('/\s+/', ' ', $cleanKeyword));

                $lines = explode("\n", $contractContent);
                foreach ($lines as $line) {
                    // تنظيف السطر الحالي مؤقتاً لمطابقته مع الكلمة النظيفة
                    $cleanLine = preg_replace('/[\x{200E}\x{200F}\x{202A}-\x{202E}]/u', '', $line);
                    $cleanLine = preg_replace('/\s+/', ' ', $cleanLine);

                    if (!empty($cleanKeyword) && mb_strpos($cleanLine, $cleanKeyword) !== false) {
                        $finalSourceQuote = trim($line); // نأخذ السطر الأصلي بكامل تنسيقه الأصلي وعلاماته
                        break; 
                    }
                }
                
                // Fallback الذكي: إذا لم نجد السطر بسبب التقطيع الشديد، نعتمد على الكلمة المستخرجة نفسها كاقتباس
                if (!$finalSourceQuote) {
                    $finalSourceQuote = $extractedKeyword;
                }
            }

            // حفظ السجل في قاعدة البيانات بالاقتباس المؤكد
            $chat = AiChat::create([
                'document_id'   => $document->id,
                'user_id'       => auth()->id(),
                'message'       => $request->message,
                'response'      => $aiResponse,
                'source_quote'  => $finalSourceQuote ?: null,
            ]);

            return response()->json([
                'success'  => true,
                'message'  => $chat->message,
                'response' => $chat->response,
                'quote'    => $chat->source_quote,
                'time'     => $chat->created_at->format('h:i A')
            ]);

        } catch (\Exception $e) {
            Log::error('Chat controller exception fallback: ' . $e->getMessage());
            return response()->json(['error' => 'An internal server error occurred.'], 500);
        }
    }
}