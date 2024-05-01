<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    const TABLE_NAME = 'employment_contract';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->uuid()->primary();
            $table->string('position');
            $table->string('department');
            $table->string('salary');
            $table->string('rate');
            $table->date('register_date');
            $table->date('end_date')->nullable()->comment('Дата окончания');
            $table->string('register_address')->comment('Место регистрации');
            $table->timestamps();

            $table->foreignUuid('employee_uuid')->references('uuid')->on('employees')->onDelete('cascade');
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
