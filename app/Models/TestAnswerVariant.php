<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class TestAnswerVariant
 * @package App\Models
 *
 * @property string $uuid
 * @property string $text
 * @property bool $is_correct
 * @property string $question_uuid
 *
 * @property TestQuestion $question
 */
class TestAnswerVariant extends BaseModel
{
    use HasFactory;
    use HasUuids;

    public const RUS_LETTERS = [
        'а', 'б', 'в', 'г', 'д',
        'е', 'ё', 'ж', 'з', 'и',
        'й', 'к', 'л', 'м', 'н',
        'о', 'п', 'р', 'с', 'т',
        'у', 'ф', 'х', 'ц', 'ч',
        'ш', 'щ', 'ъ', 'ы', 'ь',
        'э', 'ю', 'я',
    ];

    public const ENG_LETTERS = [
        'a', 'b', 'c', 'd', 'e',
        'f', 'g', 'h', 'i', 'j',
        'k', 'l', 'm', 'n', 'o',
        'p', 'q', 'r', 's', 't',
        'u', 'v', 'w', 'x', 'y',
        'z',
    ];

    public $incrementing = false;
    protected $primaryKey = 'uuid';

    protected $guarded = [
        'uuid',
        'created_at',
        'updated_at',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(TestQuestion::class, 'test_question_uuid', 'uuid');
    }
}

