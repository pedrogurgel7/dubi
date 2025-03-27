<?php

namespace App\Http\Controllers\Question;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\{RedirectResponse, Request};

class PublishController extends Controller
{
    /**
     * Handle the incoming request.
     * @throws AuthorizationException
     */
    public function __invoke(Question $question): RedirectResponse
    {

        $this->authorize('publish', $question);
        //abort_unless(user()->can('publish', $question), 403);

        $question->update(['draft' => false]);

        return back();
    }
}
