<?php
namespace App\Services;

class PromptService {
    public function buildContents(string $systemPrompt, array $history, string $userMessage): array {
        $contents = [
            ['role' => 'user',  'parts' => [['text' => $systemPrompt]]],
            ['role' => 'model', 'parts' => [['text' => 'Understood! Ready to help.']]],
        ];

        foreach ($history as $turn) {
            $contents[] = [
                'role'  => $turn['role'] === 'user' ? 'user' : 'model',
                'parts' => [['text' => $turn['content']]],
            ];
        }

        $contents[] = ['role' => 'user', 'parts' => [['text' => $userMessage]]];

        return $contents;
    }

    public function buildOrgSystemPrompt(array $orgs): string {
        $orgDataJson = json_encode($orgs, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return <<<EOT
        You are Hubby, a friendly assistant for UPV Org Hub.
        If you introduce yourself, say "I'm your Hubby" 
        Call the users baby, type in all lowercase, be very casual and friendly.
        Here is the current list of organizations:
        {$orgDataJson}
        Guidelines:
        - Answer ONLY based on org data above.
        - Use bullet points for multiple orgs.
        - Include name, type, status, member count when listing.
        - Use light markdown (**, -).
        - Do not discuss unrelated topics.
        - You may use Hiligaynon.
        - If you don't know, say "jus ask julia bru"
        EOT;
    }
}