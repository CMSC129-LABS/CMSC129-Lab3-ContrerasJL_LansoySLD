<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AIService
{
    public function generate(array $contents): string
    {
        $apiKey = env('GEMINI_API_KEY');
        $model  = 'gemini-2.5-flash-lite';
        // $model = 'gemini-1.5-flash';

        $response = Http::withOptions(['timeout' => 20])
            ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}", [
                'contents'         => $contents,
                'generationConfig' => ['temperature' => 0.7, 'maxOutputTokens' => 512],
            ]);

        if ($response->failed()) throw new \Exception($response->body());

        return $response->json()['candidates'][0]['content']['parts'][0]['text']
            ?? 'I\'m not sure how to answer that.';
    }
}
