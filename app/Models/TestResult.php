<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class TestResult
 * @package App\Models
 *
 * @property string $uuid
 * @property string $test_uuid
 * @property string $user_uuid
 * @property int $score
 * @property array $answers
 * @property bool $is_closed
 *
 * @property Test $test
 * @property User $user
 */
class TestResult extends BaseModel
{
    use HasFactory;
    use HasUuids;

    public const MAX_SCORE = 10;

    public $incrementing = false;
    protected $primaryKey = 'uuid';

    protected $casts = [
        'answers' => 'json',
    ];

    protected $guarded = [
        'uuid',
        'created_at',
        'updated_at',
    ];

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class, 'test_uuid', 'uuid');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }

    public function calcScore(array $answers): ?int
    {
        if (empty($answers)) {
            return null;
        }

        /** @var Test $test */
        $test = Test::query()->findOrFail($this->test_uuid);

        $totalCorrectAnswerVariants = TestAnswerVariant::query()
                ->whereIn('test_question_uuid', $test->questions->pluck('uuid'))
                ->where('is_correct', '=', true)->count();

        $points = 0;

        try {
            foreach ($answers as $questionId => $questionData) {

                $correctAnswers = 0;
                $incorrectAnswers = 0;

                foreach ($questionData['answers'] ?? [] as $variantId => $variantData) {
                    /** @var TestAnswerVariant $variant */
                    $variant = TestAnswerVariant::query()->findOrFail($variantId);

                    if ($variant->is_correct) {
                        $correctAnswers++;
                    } else {
                        $incorrectAnswers++;
                    }
                }

                $points += max(0, ($correctAnswers - $incorrectAnswers));

                /*echo $questionId;
                dump('correctAnswers ' . $correctAnswers);
                dump('incorrectAnswers ' . $incorrectAnswers);
                dump('points ' . $points);*/
            }
        } catch (\Throwable $e) {
            return abort(500, $e->getMessage());
        }


        $points = max(0, $points);
        $score = ($points / $totalCorrectAnswerVariants) * self::MAX_SCORE;

        // dump($score);
        // die;

        return round($score, 1);
    }
}
