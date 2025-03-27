<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseHas, put};

it('should be able to publishes a question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->create(
        ['draft' => true, 'created_by' => $user->id]
    );
    actingAs($user);

    \Pest\Laravel\put(route('question.publish', $question))->assertRedirect();
    $question->refresh();
    expect($question->draft)->toBeFalse();
    //assertDatabaseHas('questions', ['draft' => false]);
});

it('it should make sure that only who makes the question can publish it', function () {
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();

    $question = Question::factory()->create(['draft' => true, 'created_by' => $rightUser->id]);
    actingAs($wrongUser);

    put(route('question.publish', $question))->assertForbidden();

    actingAs($rightUser);
    put(route('question.publish', $question))->assertRedirect();

});
