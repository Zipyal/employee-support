<?php

namespace Database\Seeders;

use App\Models\Test;
use App\Models\TestAnswerVariant;
use App\Models\TestQuestion;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tests = Test::factory(10)->create();

        foreach ($tests as $test) {
            $questions = TestQuestion::factory(rand(3, 7))->create([
                'test_uuid' => $test->uuid,
            ]);

            foreach ($questions as $question) {
                TestAnswerVariant::factory(3)->create([
                    'test_question_uuid' => $question->uuid,
                    'is_correct' => false,
                ]);
                TestAnswerVariant::factory(1)->create([
                    'test_question_uuid' => $question->uuid,
                    'is_correct' => true
                ]);
            }
        }
    }
}
