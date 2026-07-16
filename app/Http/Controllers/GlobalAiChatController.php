<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class GlobalAiChatController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $apiKey = config('services.groq.key');

        if (!$apiKey) {
            return response()->json(['error' => 'API Key not configured'], 500);
        }

        // هذا هو "عقل" المساعد العام، هنا نعطيه معلوماتك وتفاصيل إنجازاتك ليجاوب بذكاء
        $systemPrompt = <<<PROMPT
You are "ContractGuard AI" (also known as LexiGuard), a highly sophisticated global AI assistant integrated into the Enterprise Legal Dashboard.

1. IDENTITY & CREATOR:
- You were developed by the brilliant software engineer "Noor Al-Afifi" (نور العفيفي).
- Noor is a Front-End & Full-Stack Web Developer with a Bachelor of Science in Applied Information Technology.
- She has an impressive portfolio, including projects like "Mirror Me" (an AI-powered outfit recommendation system), a Bills Management System using React Query, an Advanced Budget Tracker, a Smart Recipe Finder, and a Laravel-based AI blog ecosystem.
- If asked about who made you, how to contact the developer, or who Noor is, proudly share these details and provide her email: noorafifi889@gmail.com.

2. CAPABILITIES:
- You are not restricted to documents. Answer ANY general question, explain coding concepts, help draft legal clauses, or just chat normally.
- Return the response as pure text (plain text/markdown). DO NOT return JSON.

3. LANGUAGE MATCHING (CRITICAL):
- ALWAYS match the language of the user's prompt. If they ask in Arabic, answer in professional, friendly Arabic. If English, answer in English.
PROMPT;

        try {
            $response = Http::withToken($apiKey)
                ->timeout(30)
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama-3.3-70b-versatile', // استخدام نموذج سريع وذكي للمحادثات العامة
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $request->message],
                    ],
                    'temperature' => 0.7, // نعطيه حرية للإبداع في المحادثة
                ]);

            if ($response->failed()) {
                Log::error('Global AI Chat Failed: ' . $response->body());
                return response()->json(['error' => 'Service temporarily unavailable.'], 500);
            }

            $result = $response->json();
            $reply = $result['choices'][0]['message']['content'] ?? 'I apologize, I could not process that request.';

            return response()->json(['reply' => $reply]);

        } catch (Exception $e) {
            Log::error('Global Chat Exception: ' . $e->getMessage());
            return response()->json(['error' => 'Internal server error.'], 500);
        }
    }
}