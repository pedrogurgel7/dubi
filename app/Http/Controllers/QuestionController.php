<?php

namespace App\Http\Controllers;

use App\Rules\EndWithQuestionMarkRule;
use Illuminate\Http\{RedirectResponse};

class QuestionController extends Controller
{
    public function index(): \Illuminate\View\View
    {
        return view(
            'question.index',
            [
                'questions' => user()->questions()->get(),
            ]
        );
    }
    public function store(): RedirectResponse
    {

        request()->validate([
            'question' => ['required',
                'min:10',
                new EndWithQuestionMarkRule(),
            ],

        ]);

        user()->questions()->create(
            [
                'question' => request()->question,
            ]
        );

        return to_route('question.index');
    }
}
