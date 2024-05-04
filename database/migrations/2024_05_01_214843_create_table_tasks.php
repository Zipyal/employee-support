<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    const TABLE_NAME = 'tasks';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->uuid()->primary();
            $table->enum('status', [
                'Новая',
                'В работе',
                'Завершена',
                'Отклонена',
                'Остановлена',
                'Требует уточнения',
            ])->comment('Статус');
            $table->enum('type', [
                'Обучение',
                'Разработка',
                'Проектирование',
                'Инфраструктура',
                'Техподдержка',
            ])->comment('Тип статуса');
            $table->date('start_date')->comment('Планируемая дата начала');
            $table->date('end_date')->comment('Планируемая дата завершения');
            $table->text('description')->comment('Описание');
            $table->timestamps();

            $table->foreignUuid('employee_uuid')->nullable()->references('uuid')->on('employees')->onDelete('set null');
            $table->foreignUuid('test_uuid')->nullable()->references('uuid')->on('tests')->onDelete('set null');
            $table->foreignUuid('briefing_uuid')->nullable()->references('uuid')->on('briefings')->onDelete('set null');
            $table->foreignUuid('material_uuid')->nullable()->references('uuid')->on('materials')->onDelete('set null');
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
