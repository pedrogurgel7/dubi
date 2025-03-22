<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Rules\EndWithQuestionMarkRule;
use Illuminate\Http\{RedirectResponse};

class QuestionController extends Controller
{
    public function store(): RedirectResponse
    {

        $atributes = request()->validate([
            'question' => ['required',
                'min:10',
                new EndWithQuestionMarkRule(),
            ],

        ]);
        Question::query()->create(
            $atributes
        );

        return to_route('dashboard');
    }
}
