<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, delete};

it('should be able to delete a question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->create(
        ['draft' => true, 'created_by' => $user->id]
    );
    actingAs($user);

    delete(route('question.destroy', $question))->assertRedirect();

    \Pest\Laravel\assertDatabaseMissing('questions', ['id' => $question->id, 'draft' => true, 'created_by' => $user->id, 'deleted_at' => '']);
});

it('it should make sure that only who makes the question can destroy it', function () {
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();

    $question = Question::factory()->create(['draft' => true, 'created_by' => $rightUser->id]);

    actingAs($wrongUser);
    delete(route('question.destroy', $question))->assertForbidden();

    actingAs($rightUser);
    delete(route('question.destroy', $question))->assertRedirect();

});
