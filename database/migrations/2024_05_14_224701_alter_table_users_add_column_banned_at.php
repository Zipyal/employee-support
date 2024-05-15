<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    const TABLE_NAME = 'users';

    const NEW_COLUMN = [
        'name' => 'banned_at',
        'type' => 'timestamp',
        'params' => [
            'nullable' => true,
            'comment' => 'Дата и время блокировки пользователя',
        ]
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(self::TABLE_NAME, function (Blueprint $table) {
            $table->addColumn(self::NEW_COLUMN['type'], self::NEW_COLUMN['name'], self::NEW_COLUMN['params']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(self::TABLE_NAME, function (Blueprint $table) {
            $table->dropColumn(self::NEW_COLUMN['name']);
        });
    }
};
