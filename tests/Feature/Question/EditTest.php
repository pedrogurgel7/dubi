<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('it should be able to show edit question page', function () {

    $user     = User::factory()->create();
    $question = \App\Models\Question::factory()->for($user, 'createdBy')->create(
        ['draft' => true]
    );

    actingAs($user);

    get(route('question.edit', $question))->assertOk();

});
it('it should return a view', function () {
    $user     = User::factory()->create();
    $question = \App\Models\Question::factory()->for($user, 'createdBy')->create(
        ['draft' => true]
    );

    actingAs($user);

    get(route('question.edit', $question))->assertViewIs('question.edit');
});

it("should be able to edit a question only with status draft", function () {
    $user             = User::factory()->create();
    $draftQuestion    = \App\Models\Question::factory()->for($user, 'createdBy')->create(['draft' => true]);
    $notDraftQuestion = \App\Models\Question::factory()->for($user, 'createdBy')->create(['draft' => false]);

    actingAs($user);

    get(route('question.edit', $draftQuestion))->assertSuccessful();

    get(route('question.edit', $notDraftQuestion))->assertForbidden();

});

it('it should make sure that only who makes the question can edit it', function () {
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();

    $question = Question::factory()->create(['draft' => true, 'created_by' => $rightUser->id]);

    actingAs($wrongUser);
    get(route('question.edit', $question))->assertForbidden();

    actingAs($rightUser);
    get(route('question.edit', $question))->assertSuccessful();

});
