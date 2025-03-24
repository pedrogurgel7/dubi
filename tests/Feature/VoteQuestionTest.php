<?php

use function Pest\Laravel\{actingAs, assertDatabaseHas, post};

it('can like a question', function () {
    //a
    $user     = \App\Models\User::factory()->create();
    $question = \App\Models\Question::factory()->create();
    actingAs($user);
    //a
    post(route('question.like', $question))->assertRedirect();

    //a
    assertDatabaseHas('votes', [
        'user_id'     => $user->id,
        'question_id' => $question->id,
        'like'        => 1,
        'unlike'      => 0,
    ]);
});

it('it should not be able to like twice ', function () {
    $user     = \App\Models\User::factory()->create();
    $question = \App\Models\Question::factory()->create();
    actingAs($user);

    post(route('question.like', $question))->assertRedirect();
    post(route('question.like', $question))->assertRedirect();
    post(route('question.like', $question))->assertRedirect();
    post(route('question.like', $question))->assertRedirect();

    \Pest\Laravel\assertDatabaseCount('votes', 1);

});
