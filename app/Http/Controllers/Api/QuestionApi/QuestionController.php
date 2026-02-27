<?php

// Api controller for questions
//

namespace App\Http\Controllers\Api\QuestionApi;

// use App\Http\Controllers\Controller\Owner;
use App\Http\Controllers\Controller;
use App\Models\Question\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function ask(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
        ]);

        $userQuestion = $request->input('question');

        // Find the closest question (simple LIKE search)
        $qa = Question::where('question', 'like', "%{$userQuestion}%")->inRandomOrder()->first();

        if (! $qa) {
            return response()->json([
                'answer' => 'Sorry, I do not know the answer.',
            ]);
        }

        // Pick a random answer variant
        $answers = collect($qa->answers);
        $randomAnswer = $answers->random();

        return response()->json([
            'question' => $qa->question,
            'answer' => $randomAnswer,
        ]);
    }

    public function suggestions(Request $request)
    {
        $q = $request->query('q', '');

        $results = Question::where('question', 'like', "%{$q}%")
            ->limit(10)
            ->pluck('question'); // returns array of matching questions

        return response()->json($results);
    }
}
