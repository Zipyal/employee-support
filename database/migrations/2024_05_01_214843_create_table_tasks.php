<?php

use App\Models\Task;
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
            $table->enum('status', Task::STATUSES)->comment('Статус');
            $table->enum('type', Task::TYPES)->comment('Тип');
            $table->enum('priority', Task::PRIORITIES)->comment('Приоритет');
            $table->date('start_date')->comment('Планируемая дата начала');
            $table->date('end_date')->nullable()->comment('Планируемая дата завершения');
            $table->text('description')->comment('Описание');
            $table->smallInteger('weight')->nullable()->comment('Вес для сортировки');

            $table->foreignUuid('author_uuid')->nullable()->comment('Ссылка на пользователя (автор)')->references('uuid')->on('users')->onDelete('set null');
            $table->foreignUuid('employee_uuid')->nullable()->comment('Ссылка на сотрудника (на кого назначено)')->references('uuid')->on('employees')->onDelete('set null');
            $table->foreignUuid('test_uuid')->nullable()->comment('Ссылка на тест')->references('uuid')->on('tests')->onDelete('set null');
            $table->foreignUuid('briefing_uuid')->nullable()->comment('Ссылка на инструктаж')->references('uuid')->on('briefings')->onDelete('set null');
            $table->foreignUuid('material_uuid')->nullable()->comment('Ссылка на материал')->references('uuid')->on('materials')->onDelete('set null');

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
