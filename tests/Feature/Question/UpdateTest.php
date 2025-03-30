<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, put};

it('it should be able to update question', function () {

    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(
        ['draft' => true]
    );

    actingAs($user);

    put(route('question.update', $question), [
        'question' => 'new question',
    ])->assertRedirect();

    $question->refresh();
    expect($question->question)->toBe('new question');

});

it("should be able to update a question only with status draft", function () {
    $user             = User::factory()->create();
    $draftQuestion    = \App\Models\Question::factory()->for($user, 'createdBy')->create(['draft' => true]);
    $notDraftQuestion = \App\Models\Question::factory()->for($user, 'createdBy')->create(['draft' => false]);

    actingAs($user);

    put(route('question.update', $draftQuestion), [
        'question' => 'new question',
    ])->assertRedirect();

    put(route('question.update', $notDraftQuestion), [
        'question' => 'new question',
    ])->assertForbidden();

});

it('it should make sure that only who makes the question can update it', function () {
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();

    $question = Question::factory()->create(['draft' => true, 'created_by' => $rightUser->id]);

    actingAs($wrongUser);
    put(route('question.update', $question), [
        'question' => 'new question',
    ])->assertForbidden();

    actingAs($rightUser);
    put(
        route('question.update', $question),
        [
            'question' => 'new question',
        ]
    )->assertRedirect();

});
