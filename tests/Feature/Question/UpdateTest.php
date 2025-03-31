<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, put};

it('it should be able to update question', function () {

    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(
        ['draft' => true]
    );

    actingAs($user);

    put(route('question.update', $question), [
        'question' => 'new question?',
    ])->assertRedirect();

    $question->refresh();
    expect($question->question)->toBe('new question?');

});

it("should be able to update a question only with status draft", function () {
    $user             = User::factory()->create();
    $draftQuestion    = \App\Models\Question::factory()->for($user, 'createdBy')->create(['draft' => true]);
    $notDraftQuestion = \App\Models\Question::factory()->for($user, 'createdBy')->create(['draft' => false]);

    actingAs($user);

    put(route('question.update', $draftQuestion), [
        'question' => 'new question?',
    ])->assertRedirect(route('question.index'));

    put(route('question.update', $notDraftQuestion), [
        'question' => 'new question?',
    ])->assertForbidden();

});

it('should make sure that only the person who has created the question can update the question', function () {
    $rightUser = User::factory()->create();
    $wrongUser = User::factory()->create();
    $question  = Question::factory()->create(['draft' => true, 'created_by' => $rightUser->id]);

    actingAs($wrongUser);
    put(route('question.update', $question))->assertForbidden();

    actingAs($rightUser);
    put(route('question.update', $question), ['question' => 'New Question?'])->assertRedirect();
});

it('should be able to update a new question bigger than 255 characters', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);

    actingAs($user);

    $request = put(route('question.update', $question), [
        'question' => str_repeat('*', 260) . '?',
    ]);

    $request->assertRedirect();
    assertDatabaseCount('questions', 1);
    assertDatabaseHas('questions', ['question' => str_repeat('*', 260) . '?']);
});

it('should check if ends with question mark ?', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(['draft' => true]);
    actingAs($user);

    $request = put(route('question.update', $question), [
        'question' => str_repeat('*', 10),
    ]);

    $request->assertSessionHasErrors([
        'question' => 'Are you sure that the question ends with a question mark?',
    ]);

    assertDatabaseHas('questions', [
        'question' => $question->question,
    ]);
});

it('should update have at least 10 characters', function () {
    //Arrange
    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->create(
        ['draft' => true]
    );

    actingAs($user);

    //Act
    $request = put(route('question.update', $question), [
        'question' => str_repeat('*', 8) . '?',
    ]);

    //Assert

    $request->assertSessionHasErrors(['question' => __('validation.min.string', ['attribute' => 'question', 'min' => 10])]);

});
