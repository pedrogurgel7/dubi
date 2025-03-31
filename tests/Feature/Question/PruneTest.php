
<?php

    it('it should prune records deleted more than than 1 month ago', function () {
        $question = \App\Models\Question::factory()->create(
            [
                'deleted_at' => now()->subMonth(2),
            ]
        );
        \Pest\Laravel\assertSoftDeleted('questions', [
            'id' => $question->id,
        ]);

        \Pest\Laravel\artisan('model:prune');

        \Pest\Laravel\assertDatabaseMissing('questions', [
            'id' => $question->id,
        ]);

    });
