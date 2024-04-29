<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Briefing
 * @package App\Models
 * @property int $ID_Инструктаж
 * @property string $Тема
 * @property string $Материал
 */
class Briefing extends Model
{
    use HasFactory;

    public $table = 'Инструктаж';
    public $timestamps = false;
    public $incrementing = true;
    protected $primaryKey = 'ID_Инструктаж';
    protected $keyType = 'integer';
}
