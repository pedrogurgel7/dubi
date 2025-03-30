<?php

use App\Models\User;

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
