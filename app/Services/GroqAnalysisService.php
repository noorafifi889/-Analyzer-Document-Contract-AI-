<?php
 
namespace App\Services;
 
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;
 
class GroqAnalysisService
{
    protected string $apiKey;
    protected string $apiUrl;
    protected string $model;
 
    public function __construct()
    {
        $this->apiKey = config('services.groq.key')
            ?? throw new Exception('Groq API key is not configured. تأكد من GROQ_API_KEY بملف .env');
 
        $this->apiUrl = 'https://api.groq.com/openai/v1/chat/completions';
 
        // نموذج قوي وسريع من Groq، يدعم JSON mode
        $this->model = 'llama-3.3-70b-versatile';
    }
 
    /**
     * Analyze any document text using Groq API.
     * Adapts its analysis style based on the detected document type
     * (legal contract, financial report, academic paper, general text, etc.)
     *
     * @param string $text
     * @return array
     * @throws Exception
     */
    public function analyzeContract(string $text): array
    {
     $systemPrompt = <<<PROMPT
You are an expert document analyst capable of analyzing ANY type of document. First, identify the type/nature of the document and detect its primary language (e.g., English, Arabic, etc.). Tailor your entire analysis and write all text fields in that SAME detected language. Return the result strictly in JSON format. Do not include any additional commentary or markdown block fences.

CRITICAL INSTRUCTION FOR SUMMARY FIELDS:
You MUST provide a detailed, elongated analysis split into two distinct fields. Write all text responses in the detected language of the input document. Do not write short sentences; expand your vocabulary to provide a rich, professional, and deep evaluation.
- "summary_p1": A detailed paragraph (4-5 long sentences) explaining the document's type, background, parties involved, and its core purpose.
- "summary_p2": A detailed paragraph (4-5 long sentences) highlighting the primary obligations, potential liabilities/hidden risks, and conclusive expert feedback.

Required JSON Schema:
{
  "summary_p1": "Detailed corporate paragraph 1 written in the document's language...",
  "summary_p2": "Detailed corporate paragraph 2 written in the document's language...",
  "risk_score": An integer from 0 to 100 representing the overall risk/concern level,
  "critical_issues": ["Key issue 1 in the document's language", "Key issue 2"],
  "clauses_analysis": [
    {"clause": "Section/Clause Name", "analysis": "Detailed analysis in the document's language"}
  ],
  "ai_confidence": A float between 0.0 and 1.0
}
PROMPT;
 
        try {
            $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type'  => 'application/json',
                ])
                ->timeout(60)
                ->post($this->apiUrl, [
                    'model' => $this->model,
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $text],
                    ],
                    'temperature' => 0.2,
                    'response_format' => ['type' => 'json_object'],
                ]);
 
            if ($response->failed()) {
                throw new Exception('Groq API call failed: ' . $response->body());
            }
 
            $result = $response->json();
            $rawText = $result['choices'][0]['message']['content'] ?? null;
 
            if (!$rawText) {
                throw new Exception('Groq response did not contain valid text.');
            }
 
            $parsed = json_decode($rawText, true);
 
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Failed to decode Groq JSON response: ' . json_last_error_msg());
            }
 
            return $parsed;
 
        } catch (Exception $e) {
            Log::error('Groq Analysis Error: ' . $e->getMessage());
            throw $e;
        }
    }
}