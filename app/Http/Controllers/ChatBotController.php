<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AIService;
use App\Services\PromptService;
use App\Services\FunctionCallService;

class ChatbotController extends Controller
{
    public function __construct(
        protected AIService           $ai,
        protected PromptService       $prompt,
        protected FunctionCallService $functions,
    ) {}

    public function message(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
            'history' => 'nullable|array|max:20',
            'crud_mode' => 'nullable|boolean',
        ]);

        try {
            $orgs         = $this->functions->getOrgsForPrompt();
            $crudMode     = $request->boolean('crud_mode', false);

            $systemPrompt = $crudMode
                ? $this->prompt->buildCrudSystemPrompt($orgs)
                : $this->prompt->buildOrgSystemPrompt($orgs);

            $contents     = $this->prompt->buildContents($systemPrompt, $request->input('history', []), $request->input('message'));
            $reply        = $this->ai->generate($contents);

            // parse CRUD actions from reply
            if ($crudMode) {
                $result = $this->parseCrudAction($reply);
                if ($result) {
                    return response()->json([
                        'reply'       => $result['message'],
                        'crud_action' => $result['action'],
                        'crud_data'   => $result['data'],
                        'requires_confirm' => in_array($result['action'], ['UPDATE', 'ARCHIVE']),
                    ]);
                }
            }

            return response()->json(['reply' => $reply]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function executeCrud(Request $request)
    {
        $request->validate([
            'action' => 'required|string|in:CREATE,UPDATE,ARCHIVE',
            'data'   => 'required|array',
        ]);

        try {
            $action = $request->input('action');
            $data   = $request->input('data');
            $result = null;

            if ($action === 'CREATE') {
                $result = $this->functions->createOrg($data);
            } elseif ($action === 'UPDATE') {
                $result = $this->functions->updateOrg($data['id'], $data);
            } elseif ($action === 'ARCHIVE') {
                $result = $this->functions->archiveOrg($data['id']);
            }

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function parseCrudAction(string $reply): ?array
    {
        if (!preg_match('/ACTION:(CREATE|UPDATE|ARCHIVE)/', $reply, $actionMatch)) {
            return null;
        }

        $action = $actionMatch[1];

        // Try fenced ```json block first
        if (preg_match('/```json\s*([\s\S]*?)```/', $reply, $jsonMatch)) {
            $jsonStr = trim($jsonMatch[1]);
        }
        // Try JSON on its own line after ACTION:VERB
        elseif (preg_match('/ACTION:(?:CREATE|UPDATE|ARCHIVE)\s*\n\s*(\{[\s\S]*?\})/', $reply, $jsonMatch)) {
            $jsonStr = trim($jsonMatch[1]);
        }
        // Fallback: JSON glued directly to ACTION:VERB (no newline)
        elseif (preg_match('/ACTION:(?:CREATE|UPDATE|ARCHIVE)(\{[\s\S]*?\})/', $reply, $jsonMatch)) {
            $jsonStr = trim($jsonMatch[1]);
        } else {
            return null;
        }

        $data = json_decode($jsonStr, true);
        if (!$data) return null;

        // Strip action tag + JSON from the reply to get clean message
        $cleanReply = preg_replace('/ACTION:(CREATE|UPDATE|ARCHIVE)\s*/', '', $reply);
        $cleanReply = preg_replace('/```json[\s\S]*?```/', '', $cleanReply);
        $cleanReply = preg_replace('/\{[^{}]*\}/', '', $cleanReply);
        $cleanReply = trim($cleanReply);

        return [
            'action'  => $action,
            'data'    => $data,
            'message' => $cleanReply ?: "ready to {$action} baby! confirm?",
        ];
    }
}
