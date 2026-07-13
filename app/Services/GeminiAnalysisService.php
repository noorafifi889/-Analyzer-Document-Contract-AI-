<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class GeminiAnalysisService
{
    protected string $apiKey;
    protected string $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('services.groq.key');
        $this->apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent';
    }

    /**
     * Analyze contract text using Gemini API.
     *
     * @param string $text
     * @return array
     * @throws Exception
     */
    public function analyzeContract(string $text): array
    {
        // Define the exact JSON structure required by the database schema
        $prompt = <<<PROMPT
You are an expert legal contract analyst. Analyze the following contract text and return the result strictly in JSON format. Do not include any additional commentary, markdown block fences, or explanations.

Required JSON Schema:
{
  "summary": "A comprehensive summary of the contract in 2-3 sentences in Arabic",
  "risk_score": An integer from 0 to 100 representing the risk level,
  "critical_issues": ["Critical Issue 1", "Critical Issue 2"],
  "clauses_analysis": [
    {"clause": "Clause Name", "analysis": "A brief analysis of the clause"}
  ],
  "ai_confidence": A float between 0.0 and 1.0 representing your confidence level
}

Contract Text:
{$text}
PROMPT;

        try {
            $response = Http::timeout(60)->post(
                $this->apiUrl . '?key=' . $this->apiKey,
                [
                    'contents' => [
                        ['parts' => [['text' => $prompt]]]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.2,
                        'responseMimeType' => 'application/json',
                    ],
                ]
            );

            if ($response->failed()) {
                throw new Exception('Gemini API call failed: ' . $response->body());
            }

            $result = $response->json();
            $rawText = $result['candidates'][0]['content']['parts'][0]['text'] ?? null;

            if (!$rawText) {
                throw new Exception('Gemini response did not contain valid text.');
            }

            $parsed = json_decode($rawText, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Failed to decode Gemini JSON response: ' . json_last_error_msg());
            }

            return $parsed;

        } catch (Exception $e) {
            Log::error('Gemini Analysis Error: ' . $e->getMessage());
            throw $e;
        }
    }
}