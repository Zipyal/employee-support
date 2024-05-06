<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    const TABLE_NAME = 'employees';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->uuid()->primary();
            $table->string('last_name')->comment('Фамилия');
            $table->string('first_name')->comment('Имя');
            $table->string('patronymic')->comment('Отчество');
            $table->string('phone')->comment('Номер телефона');
            $table->string('email')->comment('Почта');
            $table->date('birth_date')->comment('Дата рождения');
            $table->string('education')->comment('Оброзование');
            $table->string('add_education')->nullable()->comment('Дополнительное образование');
            $table->unsignedSmallInteger('experience')->comment('Опыт работы');
            $table->enum('role', [
                'Сотрудник',
                'Наставник',
                'Администратор',
            ])->nullable()->comment('Роль');
            $table->timestamps();

            $table->foreignUuid('mentor_uuid')->nullable()->references('uuid')->on('employee')->onDelete('set null');
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
