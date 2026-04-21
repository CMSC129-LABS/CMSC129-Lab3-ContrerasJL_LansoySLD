<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Organization; 

class ChatbotController extends Controller
{
    public function message(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
            'history' => 'nullable|array|max:20',
        ]);

        $userMessage = $request->input('message');
        $history     = $request->input('history', []);

        //pull live org data from DB and format for system prompt
        $orgs = Organization::all()->map(function ($org) {
            return [
                'name'     => $org->name,
                'type'     => $org->type       ?? 'N/A',   // e.g. Academic, Cultural, etc.
                'status'   => $org->status     ?? 'N/A',   // Active / Inactive
                'members'  => $org->members    ?? 'N/A',   // member count
                'tags'     => $org->tags       ?? '',       // e.g. arts, writing, sports
                'description' => $org->description ?? '',
            ];
        })->toArray();

        $orgDataJson = json_encode($orgs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        // build gemini system prompt with org data context
        $systemPrompt = <<<EOT
You are OrgBot, a friendly and knowledgeable assistant for UPV Org Hub — 
a centralized directory of student organizations at the University of the Philippines Visayas (UPV).

Your role is to help students discover, explore, and learn about UPV student organizations.

Here is the current list of organizations from the database:
{$orgDataJson}

Guidelines:
- Answer questions based ONLY on the org data above. Do not invent organizations.
- If no orgs match a query, say so politely and suggest broadening the search.
- For interest-based queries (e.g. "I'm a writer"), reason about which orgs best match.
- Keep responses concise, friendly, and helpful. Use bullet points for listing multiple orgs.
- When listing orgs, include: name, type, status, and member count if available.
- You may respond with light markdown (bold with **, bullet lists with -).
- Do not discuss topics unrelated to UPV organizations.
- You may use Hiligaynon Language
- if u don't know the answer, say "jus ask julia bru"
EOT;

        //build convo terms for Gemini API
        $contents = [];

        // inject content
        $contents[] = [
            'role'  => 'user',
            'parts' => [['text' => $systemPrompt]],
        ];
        $contents[] = [
            'role'  => 'model',
            'parts' => [['text' => 'Understood! I\'m ready to help UPV students find the perfect organization. What would you like to know?']],
        ];

        // append conversation history (skip the very first system exchange)
        foreach ($history as $turn) {
            $role = $turn['role'] === 'user' ? 'user' : 'model';
            $contents[] = [
                'role'  => $role,
                'parts' => [['text' => $turn['content']]],
            ];
        }

        // append the new user message
        $contents[] = [
            'role'  => 'user',
            'parts' => [['text' => $userMessage]],
        ];

        // call gemini api
        $apiKey = env('GEMINI_API_KEY');
        $model = 'gemini-2.0-flash-lite';

        $response = Http::withOptions(['timeout' => 20])
            ->post("https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent?key={$apiKey}", [
                'contents'         => $contents,
                'generationConfig' => [
                    'temperature'     => 0.7,
                    'maxOutputTokens' => 512,
                ],
            ]);

        if ($response->failed()) {
            return response()->json([
                'error' => 'Gemini API request failed.',
                'status' => $response->status(),
                'body' => $response->body(), 
                'key_set' => !empty(env('GEMINI_API_KEY')), 
            ], 500);
        }

        $data  = $response->json();
        $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'I\'m not sure how to answer that. Try rephrasing?';

        return response()->json(['reply' => $reply]);
    }
}