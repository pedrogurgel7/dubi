<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Closure;
use Illuminate\Http\{RedirectResponse};

class QuestionController extends Controller
{
    public function store(): RedirectResponse
    {

        $atributes = request()->validate([
            'question' => ['required',
                'min:10',
                function (string $attribute, mixed $value, Closure $fail) {
                    if ($value[strlen($value) - 1] !== '?') {
                        $fail('Are you sure that the question ends with a question mark?');
                    }
                },
            ],

        ]);
        Question::query()->create(
            $atributes
        );

        return to_route('dashboard');
    }
}
