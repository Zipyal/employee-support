<?php

use App\Models\Employee;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

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
            $table->enum('gender', [Employee::GENDER_MALE, Employee::GENDER_FEMALE])->comment('Пол');
            $table->string('image_filepath')->nullable()->comment('Путь к файлу изображения');
            $table->string('phone')->comment('Номер телефона');
            $table->string('email')->comment('Почта');
            $table->date('birth_date')->comment('Дата рождения');
            $table->string('education')->comment('Образование');
            $table->string('add_education')->nullable()->comment('Дополнительное образование');
            $table->unsignedSmallInteger('experience')->comment('Опыт работы');
            $table->foreignUuid('user_uuid')->nullable()->comment('Ссылка на пользователя (учётная запись)')->references('uuid')->on('users')->onDelete('set null')->onUpdate('set null');
            $table->uuid('mentor_uuid')->nullable()->comment('Ссылка на сотрудника (наставник)');
            $table->timestamps();
        });

        Schema::table(self::TABLE_NAME, function (Blueprint $table) {
            $table->foreign('mentor_uuid')->references('uuid')->on(self::TABLE_NAME)->onDelete('no action')->onUpdate('no action');
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
