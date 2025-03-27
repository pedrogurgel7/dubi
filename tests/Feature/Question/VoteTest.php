<?php

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, post};

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

it("should be able to unlike a question", function () {

    $user     = \App\Models\User::factory()->create();
    $question = \App\Models\Question::factory()->create();
    actingAs($user);
    post(route('question.unlike', $question))->assertRedirect();

    assertDatabaseHas('votes', [
        'user_id'     => $user->id,
        'question_id' => $question->id,
        'like'        => 0,
        'unlike'      => 1,
    ]);
});

it('it should not be able to unlike and like the same question ', function () {

    $user     = \App\Models\User::factory()->create();
    $question = \App\Models\Question::factory()->create();
    actingAs($user);
    post(route('question.unlike', $question))->assertRedirect();
    post(route('question.like', $question))->assertRedirect();

    assertDatabaseCount('votes', 1);
});
