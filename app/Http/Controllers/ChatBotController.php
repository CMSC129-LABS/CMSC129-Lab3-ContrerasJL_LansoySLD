<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Services\AIService;
use App\Services\PromptService;
use App\Services\FunctionCallService;

class ChatbotController extends Controller {
    public function __construct(
        protected AIService           $ai,
        protected PromptService       $prompt,
        protected FunctionCallService $functions,
    ) {}

    public function message(Request $request) {
        $request->validate([
            'message' => 'required|string|max:500',
            'history' => 'nullable|array|max:20',
        ]);

        try {
            $orgs         = $this->functions->getOrgsForPrompt();
            $systemPrompt = $this->prompt->buildOrgSystemPrompt($orgs);
            $contents     = $this->prompt->buildContents($systemPrompt, $request->input('history', []), $request->input('message'));
            $reply        = $this->ai->generate($contents);

            return response()->json(['reply' => $reply]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}