<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    const TABLE_NAME = 'briefing_employee';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->foreignUuid('briefing_uuid')->comment('Ссылка на инструктаж')->references('uuid')->on('briefings')->onDelete('cascade');
            $table->foreignUuid('employee_uuid')->comment('Ссылка на сотрудника (кто ознакомился)')->references('uuid')->on('employees')->onDelete('cascade');
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
