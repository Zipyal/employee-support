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
            $table->id()->autoIncrement();
            $table->string('subject');
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
            ])->comment('Тип');
            $table->date('start_date')->comment('Планируемая дата начала');
            $table->date('end_date')->nullable()->comment('Планируемая дата завершения');
            $table->text('description')->comment('Описание');

            $table->foreignUuid('author_uuid')->nullable()->references('uuid')->on('employees')->onDelete('no action');
            $table->foreignUuid('employee_uuid')->nullable()->references('uuid')->on('employees')->onDelete('no action');
            $table->foreignUuid('test_uuid')->nullable()->references('uuid')->on('tests')->onDelete('no action');
            $table->foreignUuid('briefing_uuid')->nullable()->references('uuid')->on('briefings')->onDelete('no action');
            $table->foreignUuid('material_uuid')->nullable()->references('uuid')->on('materials')->onDelete('no action');

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
