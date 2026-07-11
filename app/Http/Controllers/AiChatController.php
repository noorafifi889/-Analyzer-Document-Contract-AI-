<?php

namespace App\Http\Controllers;

use App\Models\AiChat;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiChatController extends Controller
{
    /**
     * Display the chat interface for a specific document.
     */
    public function show(Document $document)
    {
        $chats = $document->aiChats()->oldest()->get();
        $analysis = $document->analyses()->latest()->first();

        return view('intelligence.chatAi', compact('document', 'chats', 'analysis'));
    }

    /**
     * Send the user's prompt along with the document context to the AI model.
     */
public function sendMessage(Request $request, Document $document)
{
    $request->validate([
        'message' => 'required|string|max:5000',
    ]);

    $contractContent = $document->extracted_text ?? '';

    // تقصير النص لتفادي rate_limit_exceeded (TPM limit)
    $maxChars = 12000;
    if (mb_strlen($contractContent) > $maxChars) {
        $contractContent = mb_substr($contractContent, 0, $maxChars)
            . "\n\n[...تم اقتطاع باقي النص بسبب حجم الطلب...]";
    }

    try {
        $systemPrompt = "You are an expert legal AI assistant specializing in contract analysis.\n\n"
                      . "Here is the exact text content extracted from the uploaded document/file:\n"
                      . "--- START OF EXTRACTED TEXT ---\n"
                      . ($contractContent ? $contractContent : "CRITICAL ERROR: No text content was extracted or found for this document in the database.")
                      . "\n--- END OF EXTRACTED TEXT ---\n\n"
                      . "Instructions:\n"
                      . "1. For general greetings or casual chat (e.g., 'hi', 'how are you', 'شو أخبارك'), reply warmly in the user's language and remind them to ask questions about this specific document.\n"
                      . "2. For questions regarding the document, answer accurately, objectively, and professionally based ONLY on the extracted text provided above.\n"
                      . "3. If the user asks about information that does not exist in the text, or if the extracted text is empty, clearly state that the information cannot be found within the document context.\n"
                      . "4. STRICT LANGUAGE MATCHING: Detect the language of the user's prompt. If they ask in Arabic, reply in Arabic. If they ask in English, reply in English.\n\n"
                      . "5. OUTPUT FORMAT (CRITICAL): You MUST respond with ONLY a raw JSON object, no markdown, no code fences, matching exactly this schema:\n"
                      . "{\n"
                      . "  \"answer\": \"Your full, professional answer in the appropriate language.\",\n"
                      . "  \"quote\": \"An exact short excerpt (max ~25 words), copied VERBATIM word-for-word from the extracted document text above, that directly supports your answer. If this is a greeting/small talk or the document has no relevant text, return an empty string.\"\n"
                      . "}";

        $response = Http::withToken(config('services.groq.key'))
            ->timeout(60)
            ->post('https://api.groq.com/openai/v1/chat/completions', [
                'model' => 'openai/gpt-oss-20b',
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $request->message]
                ],
                'temperature' => 0.3,
                'max_tokens' => 1024,
                'response_format' => ['type' => 'json_object'],
            ]);

        if ($response->failed()) {
            Log::error('Groq API Connection Failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return response()->json([
                'error' => 'Failed to process request with AI service.',
                'debug_status' => $response->status(),
            ], 500);
        }

        $aiData = $response->json();
        $rawContent = $aiData['choices'][0]['message']['content'] ?? null;

        $parsed = json_decode($rawContent, true);
        $aiResponse = $parsed['answer'] ?? ($rawContent ?: 'Unable to parse an answer from the document context.');
        $sourceQuote = trim($parsed['quote'] ?? '');

        $chat = AiChat::create([
            'document_id'   => $document->id,
            'user_id'       => auth()->id(),
            'message'       => $request->message,
            'response'      => $aiResponse,
            'source_quote'  => $sourceQuote ?: null,
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
