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
