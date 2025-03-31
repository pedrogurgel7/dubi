<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get};

it('returns a list of questions', function () {
    //arrange
    $user      = User::factory()->create();
    $questions = Question::factory()->count(2)->create();
    actingAs($user);
    //act
    $response = get(route('dashboard'));
    //assert

    foreach ($questions as $q) {
        /** @var Question $q  */
        $response->assertSee($q->question);
    }

});

it('should use pagination for questions', function () {
    //arrange
    $user = User::factory()->create();
    Question::factory()->count(20)->create(
        [
            'draft' => true,
        ]
    );

    actingAs($user);
    //act

    //assert
    $response = get(route('dashboard'))->assertViewHas('questions', function ($q) {

        return $q instanceof \Illuminate\Pagination\LengthAwarePaginator;
    });

});
