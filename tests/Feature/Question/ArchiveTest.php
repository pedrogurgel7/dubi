<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertSoftDeleted};

it('should be able to archive a question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->create(
        ['draft' => true, 'created_by' => $user->id]
    );
    actingAs($user);

    \Pest\Laravel\patch(route('question.archive', $question))->assertRedirect();

    assertSoftDeleted('questions', ['id' => $question->id, 'draft' => true, 'created_by' => $user->id]);
    expect($question->refresh()->deleted_at)->not()->toBeNull();
});

it('it should make sure that only who makes the question can destroy it', function () {
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();

    $question = Question::factory()->create(['draft' => true, 'created_by' => $rightUser->id]);

    actingAs($wrongUser);
    \Pest\Laravel\patch(route('question.archive', $question))->assertForbidden();

    actingAs($rightUser);
    \Pest\Laravel\patch(route('question.archive', $question))->assertRedirect();

});
