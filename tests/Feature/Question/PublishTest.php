<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseHas};

it('should be able to publishes a question', function () {
    $user     = User::factory()->create();
    $question = Question::factory()->create(
        ['draft' => true]
    );
    actingAs($user);

    \Pest\Laravel\put(route('question.publish', $question))->assertRedirect();
    $question->refresh();
    expect($question->draft)->toBeFalse();
    //assertDatabaseHas('questions', ['draft' => false]);
});
