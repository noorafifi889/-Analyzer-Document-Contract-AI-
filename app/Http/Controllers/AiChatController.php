<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\AiChat;
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
        return view('documents.chatAi', compact('document', 'chats'));
    }

    /**
     * Send the user's prompt along with the document context to the AI model.
     */
    public function sendMessage(Request $request, Document $document)
    {
        $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        // Dynamically fetch the extracted text from the document.
        // Make sure to match 'content', 'text', or 'body' depending on your database schema.
$contractContent = $document->extracted_text ?? '';

        try {
            // Build a highly optimized System Prompt incorporating the document's real text
            $systemPrompt = "You are an expert legal AI assistant specializing in contract analysis.\n\n"
                          . "Here is the exact text content extracted from the uploaded document/file:\n"
                          . "--- START OF EXTRACTED TEXT ---\n"
                          . ($contractContent ? $contractContent : "CRITICAL ERROR: No text content was extracted or found for this document in the database.")
                          . "\n--- END OF EXTRACTED TEXT ---\n\n"
                          . "Instructions:\n"
                          . "1. For general greetings or casual chat (e.g., 'hi', 'how are you', 'شو أخبارك'), reply warmly in the user's language and remind them to ask questions about this specific document.\n"
                          . "2. For questions regarding the document, answer accurately, objectively, and professionally based ONLY on the extracted text provided above.\n"
                          . "3. If the user asks about information that does not exist in the text, or if the extracted text is empty, clearly state that the information cannot be found within the document context.\n"
                          . "4. STRICT LANGUAGE MATCHING: Detect the language of the user's prompt. If they ask in Arabic, reply in Arabic. If they ask in English, reply in English.";

            // Dispatch request to Groq API using a stable, high-context model
            $response = Http::withToken(env('GROQ_API_KEY'))
                ->post('https://api.groq.com/openai/v1/chat/completions', [
                    'model' => 'llama-3.1-8b-instant', 
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $request->message]
                    ],
                    'temperature' => 0.3, // Keeps the model focused on the file context while remaining conversational
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
            $aiResponse = $aiData['choices'][0]['message']['content'] ?? 'Unable to parse an answer from the document context.';

            // Persist the conversation log mapped to the document ID
            $chat = AiChat::create([
                'document_id' => $document->id,
                'user_id' => auth()->id(), 
                'message' => $request->message,
                'response' => $aiResponse,
            ]);

            return response()->json([
                'success' => true,
                'message' => $chat->message,
                'response' => $chat->response,
                'time' => $chat->created_at->format('h:i A')
            ]);

        } catch (\Exception $e) {
            Log::error('Chat controller exception fallback: ' . $e->getMessage());
            return response()->json(['error' => 'An internal server error occurred.'], 500);
        }
    }
}