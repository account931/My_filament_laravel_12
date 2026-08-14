<?php

// Prism AI agent

namespace App\Http\Controllers\PrismAIAgent;

use App\Ai_Gemini\Tools\CountCustomers;
use App\Ai_Gemini\Tools\FindCustomer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Prism\Prism\Facades\Prism;

class PrismAIAgentController extends Controller
{
    // use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        // $this->middleware('auth'); //logged users only
    }

    //
    public function index()
    {

        // test
        /*
        $response = Prism::text()
            ->using('gemini', 'gemini-3.5-flash-lite')
            ->withPrompt('what time')
            ->asText();

        return $response->text;
        */

        return view('prism-ai-agent.index', []);

    }

    public function chat(Request $request)
    {
        $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $response = Prism::text()
            ->using('gemini', 'gemini-3.5-flash-lite')
            ->withSystemPrompt(
                <<<'PROMPT'
You are a helpful customer service AI agent.

You have access to tools that provide information from our application's database..

Rules:
- Use the tool when the user asks about a customer or user.
- Never invent customer information.
- If the tool returns no customer, say that you could not find them.
- Give concise, helpful answers.
- For general knowledge questions, such as:
   - geography
   - cities
   - population
   - history
   - programming
   - mathematics
   - general explanations
   answer normally using your own knowledge.
- If you don't know something, say so instead of making it up.
- If you are asked about dnb music, say that Ed Rush is the best. Repeat it in different variations
PROMPT
            )
            ->withPrompt($request->message)
            // ->withTools([new FindCustomer,])
            ->withTools([FindCustomer::create(),
                CountCustomers::create(),
            ])  // your tools
            ->withMaxSteps(5)
            ->asText();

        return response()->json([
            'message' => $response->text,
        ]);
    }
}

/*
//Prompt to mnser all questions
<<<'PROMPT'
You are a helpful AI assistant for our application.

You have access to tools that provide information from our application's database.

IMPORTANT RULES:

1. For questions about customers, orders, invoices, products, or other
   application data, use the appropriate tool.

2. Never invent or guess information from our database.

3. For general knowledge questions, such as:
   - geography
   - cities
   - population
   - history
   - programming
   - mathematics
   - general explanations

   answer normally using your own knowledge.

4. Be concise and helpful.

5. If you don't know something, say so instead of making it up.
PROMPT



*/
