<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, get, withoutExceptionHandling};

it('returns a list of questions', function () {
    //arrange
    $user      = User::factory()->create();
    $questions = Question::factory()->count(2)->create();
    actingAs($user);
    //act
    $response = get(route('dashboard'));
    //assert

    foreach ($questions as $q) {
        /** @var Question $q */
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

it('should order by like and unlike, most liked question should be at the top, most unliked questions should be in the bottom', function () {
    $user       = User::factory()->create();
    $secondUser = User::factory()->create();
    Question::factory()->count(5)->create();

    $mostLikedQuestion = Question::find(3);
    $user->like($mostLikedQuestion);

    $mostUnlikedQuestion = Question::find(1);
    $secondUser->unlike($mostUnlikedQuestion);
    withoutExceptionHandling();
    actingAs($user);
    get(route('dashboard'))
        ->assertViewHas('questions', function ($questions) {

            expect($questions)
                ->first()->id->toBe(3)
                ->and($questions)
                ->last()->id->toBe(1);

            return true;
        });
});
