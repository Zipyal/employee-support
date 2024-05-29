<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    const TABLE_NAME = 'test_results';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->uuid()->primary();
            $table->foreignUuid('test_uuid')->comment('Ссылка на тест')->references('uuid')->on('tests')->onDelete('cascade');
            $table->foreignUuid('user_uuid')->comment('Ссылка на пользователя (кто проходил тест)')->references('uuid')->on('users')->onDelete('cascade');
            $table->float('score')->comment('Кол-во баллов');
            $table->json('answers')->comment('Ответы пользователя');
            $table->boolean('is_closed')->default(true)->comment('Закрыт ли тест для повторной сдачи?');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(self::TABLE_NAME);
    }
};
