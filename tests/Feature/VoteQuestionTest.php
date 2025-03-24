<?php

use function Pest\Laravel\assertDatabaseHas;

it('can like a question', function () {
    //a
    $user     = \App\Models\User::factory()->create();
    $question = \App\Models\Question::factory()->create();
    \Pest\Laravel\actingAs($user);
    //a
    \Pest\Laravel\post(route('question.like', $question))->assertRedirect();

    assertDatabaseHas('votes', [
        'user_id'     => $user->id,
        'question_id' => $question->id,
        'like'        => 1,
        'unlike'      => 0,
    ]);

    //a
});
