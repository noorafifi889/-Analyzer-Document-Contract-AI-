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
You are an expert document analyst capable of analyzing ANY type of document — legal contracts, financial reports, academic papers, technical manuals, business proposals, personal letters, articles, or any other text. First identify the type/nature of the document, then tailor your analysis accordingly. Return the result strictly in JSON format. Do not include any additional commentary, markdown block fences, or explanations.
 
Guidance per document type (adapt intelligently, this is not exhaustive):
- Legal/contract documents: focus on obligations, risks, clauses, liabilities.
- Financial documents: focus on key figures, risks, financial health indicators.
- Academic/technical documents: focus on key findings, methodology, claims, limitations.
- General/other documents: focus on main ideas, key points, and any notable concerns or flags.
 
If the document does not clearly belong to a specialized category, still produce a genuinely useful general-purpose analysis — do not refuse or claim it is impossible to analyze non-contract text.
 
Required JSON Schema:
{
  "summary": "A comprehensive summary of the document in 2-3 sentences in Arabic",
  "risk_score": An integer from 0 to 100 representing the overall risk/concern level (use 0 if not applicable, e.g. for neutral informational documents),
  "critical_issues": ["Key issue, risk, or notable point 1", "Key issue, risk, or notable point 2"],
  "clauses_analysis": [
    {"clause": "Section/Topic/Clause Name", "analysis": "A brief analysis of this section or point"}
  ],
  "ai_confidence": A float between 0.0 and 1.0 representing your confidence level
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