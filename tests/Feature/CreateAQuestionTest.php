<?php

use App\Models\User;

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, post};

test('it should be able to create a new question bigger than 255 caracters', function () {
    //Arrange
    $user = User::factory()->create();
    actingAs($user);

    //Act
    $request = post(route('question.store'), [
        'question' => str_repeat('*', 255) . '?',
    ]);
    //Assert

    $request->assertRedirect(route('dashboard'));
    assertDatabaseCount('questions', 1);

    assertDatabaseHas('questions', ['question' => str_repeat('*', 255) . '?']);

});

it('should check if ends with question mark ?', function () {
    $user = User::factory()->create();
    actingAs($user);

    $request = post(route('question.store'), [
        'question' => str_repeat('*', 10),
    ]);

    $request->assertSessionHasErrors(['question' => 'Are you sure that the question ends with a question mark?']);

});

it('should have at least 10 characters', function () {
    //Arrange
    $user = User::factory()->create();
    actingAs($user);

    //Act
    $request = post(route('question.store'), [
        'question' => str_repeat('*', 8) . '?',
    ]);

    //Assert

    $request->assertSessionHasErrors(['question' => __('validation.min.string', ['attribute' => 'question', 'min' => 10])]);

    assertDatabaseCount('questions', 0);

});
