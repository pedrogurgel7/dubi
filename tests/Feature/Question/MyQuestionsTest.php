<?php

use App\Models\{Question, User};

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('should be able to list all questions created by user', function () {
    $wrongUser     = User::factory()->create();
    $wrongQuestion = Question::factory()->for($wrongUser, 'createdBy')->count(3)->create();

    $user     = User::factory()->create();
    $question = Question::factory()->for($user, 'createdBy')->count(3)->create();

    actingAs($user);

    $response = get(route('question.index'));

    foreach ($question as $q) {
        $response->assertSee($q->question);
    };

    foreach ($wrongQuestion as $q) {
        $response->assertDontSee($q->question);
    }

});
