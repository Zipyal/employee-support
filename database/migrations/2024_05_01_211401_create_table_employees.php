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
            $table->string('last_name');
            $table->string('first_name');
            $table->string('patronymic');
            $table->string('phone');
            $table->string('email');
            $table->date('birth_date');
            $table->string('education');
            $table->string('add_education')->nullable();
            $table->unsignedSmallInteger('experience');
            $table->enum('role', [
                'Сотрудник',
                'Наставник',
                'Администратор',
            ])->nullable();
            $table->timestamps();

            $table->foreignUuid('mentor_uuid')->nullable()->references('uuid')->on('mentors')->onDelete('set null');
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
