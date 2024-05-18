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

            $table->foreignId('author_id')->nullable()->comment('Ссылка на пользователя (автор)')->references('id')->on('users')->onDelete('set null');
            $table->foreignUuid('employee_uuid')->nullable()->comment('Ссылка на сотрудника (на кого назначено)')->references('uuid')->on('employees')->onDelete('no action');
            $table->foreignUuid('test_uuid')->nullable()->comment('Ссылка на тест')->references('uuid')->on('tests')->onDelete('no action');
            $table->foreignUuid('briefing_uuid')->nullable()->comment('Ссылка на инструктаж')->references('uuid')->on('briefings')->onDelete('no action');
            $table->foreignUuid('material_uuid')->nullable()->comment('Ссылка на материал')->references('uuid')->on('materials')->onDelete('no action');

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
