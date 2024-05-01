<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    const TABLE_NAME = 'mentors';

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
            $table->enum('role', [
                'Сотрудник',
                'Наставник',
                'Администратор',
            ])->nullable();
            $table->string('position');
            $table->string('department');
            $table->string('education');
            $table->string('add_education')->nullable();
            $table->unsignedSmallInteger('experience');
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
