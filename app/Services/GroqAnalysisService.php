<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GroqAnalysisService
{
    protected string $apiKey;

    protected string $apiUrl;

    protected string $model;

    public function __construct()
    {
        $this->apiKey = config('services.groq.key')
            ?? throw new Exception('Groq API key is not configured. Check GROQ_API_KEY in .env file');

        $this->apiUrl = 'https://api.groq.com/openai/v1/chat/completions';

        // Fast and versatile model from Groq, supports JSON mode
        $this->model = 'llama-3.3-70b-versatile';
    }

    /**
     * Analyze any document text using Groq API.
     * Adapts its analysis style based on the detected document type
     * (legal contract, financial report, academic paper, general text, etc.)
     *
     * @throws Exception
     */
    public function analyzeContract(string $text): array
    {
       $systemPrompt = <<<'PROMPT'
You are an expert document analyst and legal counsel. Your job is to strictly analyze the provided document text and respond based on the following rules:

1. LANGUAGE STRICTNESS (CRITICAL):
- You MUST provide your entire analysis, summaries, and all text values in the JSON response EXCLUSIVELY in professional English.
- Even if the input document is written in Arabic, Spanish, or any other language, your output must ALWAYS be in English.

2. LENGTH & DEPTH CRITERIA (CRITICAL):
- For the "summary" field, you must write a massive, highly detailed, extensive, and elongated analysis paragraph.
- This paragraph MUST be at least 5 to 8 full lines of text (deep analysis, rich vocabulary, fully expanded sentences). Avoid short or summarized answers.

3. RISK DISTRIBUTION SCORING (CRITICAL):
- You must evaluate the document across exactly these 4 fixed risk categories: "Legal", "Financial", "Privacy", "Compliance".
- For each category, assign an integer score from 0 to 100 representing how much risk exposure that category carries based on the document's actual content.
- Base each score on real evidence in the text.
- Do NOT default to placeholder or arbitrary numbers — scores must reflect genuine analysis of the document content.

Required JSON Schema format:
{
  "summary": "A massive, comprehensive, and highly detailed paragraph written ENTIRELY in English. It MUST contain between 150 to 250 words of deep analytical text covering the document type, background, parties, purpose, core obligations, and potential legal/financial risks.",
  "risk_score": An integer from 0 to 100 representing the overall risk level,
  "risk_distribution": {
    "Legal": An integer from 0 to 100,
    "Financial": An integer from 0 to 100,
    "Privacy": An integer from 0 to 100,
    "Compliance": An integer from 0 to 100
  },
  "critical_issues": [
    "Critical issue 1 written in English",
    "Critical issue 2 written in English"
  ],
  "clauses_analysis": [
    {
      "clause": "Name of the section/clause in English",
      "analysis": "Extremely detailed analysis of this specific clause written in English"
    }
  ],
  "ai_confidence": A float between 0.0 and 1.0
}

Return ONLY the raw JSON object. Absolutely no markdown wrap (do not use ```json), no intro, and no outro commentary.
PROMPT;

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.$this->apiKey,
                'Content-Type' => 'application/json',
            ])
                ->timeout(60)
                ->post($this->apiUrl, [
                    'model' => $this->model,
                    'messages' => [
                        ['role' => 'system', 'content' => $systemPrompt],
                        ['role' => 'user', 'content' => $text],
                    ],
                    'temperature' => 0.1, // low temperature for strict compliance
                    'response_format' => ['type' => 'json_object'],
                ]);

            if ($response->failed()) {
                throw new Exception('Groq API call failed: '.$response->body());
            }

            $result = $response->json();
            $rawText = $result['choices'][0]['message']['content'] ?? null;

            if (! $rawText) {
                throw new Exception('Groq response did not contain valid text.');
            }

            $cleanText = preg_replace('/^```json\s*|```$/i', '', trim($rawText));
            $parsed = json_decode($cleanText, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Failed to decode Groq JSON response: '.json_last_error_msg());
            }

            return $parsed;

        } catch (Exception $e) {
            Log::error('Groq Analysis Error: '.$e->getMessage());
            throw $e;
        }
    }
}