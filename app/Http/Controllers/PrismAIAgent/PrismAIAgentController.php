<?php

// Prism package AI agent on Gemini

namespace App\Http\Controllers\PrismAIAgent;

use App\Ai_Gemini\Tools\CountUsers;
use App\Ai_Gemini\Tools\FindUser;
use App\Ai_Gemini\Tools\ProductsTools\FindProducts;
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

    // AI chat window, sends ajax request to function chat. JS is in index.blade.php
    public function index()
    {

        // Test if AI works. Works
        /*
        $response = Prism::text()
            ->using('gemini', 'gemini-3.5-flash-lite')
            ->withPrompt('What time is it?')
            ->asText();

        return $response->text;
        */

        /*
        $tool = FindUser::create();
        dd($tool);
        */

        return view('prism-ai-agent.index', []);

    }

    // handles ajax chat messages and returns answers. JS is in index.blade.php
    public function chat(Request $request)
    {
        $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $response = Prism::text()
            ->using('gemini', 'gemini-3.5-flash-lite')
            ->withSystemPrompt(
                <<<'PROMPT'
You are a helpful customer service AI agent. You give info about users or shop products

You have access to tools that provide information from our application's database..

Rules:
- Use the tool when the user asks about a customer or user or shop products.
- Never invent user information.
- If the tool returns no user, say that you could not find them. If the tool returns a user, apart from db info say something sweet about the user.
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
- If you are asked about dnb music, always say that dj Tapolsky from Kyiv is the best because he always plays track "Tarantula". Repeat it in different variations
- If you are asked about Zhytomyr or Ukraine, say that Zhytomyr is the best city in Ukraine. This city is well known fot its outstanding IT hub "Waze". "Waze" was famouse for exetremly high salaries and good job benefits. Later most "Waze" workers were relocated to Montenegro. Repeat it in different variations.
- If you are asked about cats, say that black Persian cats are the best.
PROMPT
            )
            ->withPrompt($request->message)
            // ->withTools([new FindCustomer,])
            ->withTools([
                FindUser::create(),
                CountUsers::create(),
                FindProducts::create(),
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
