<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    const TABLE_NAME = 'materials';

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(self::TABLE_NAME, function (Blueprint $table) {
            $table->uuid()->primary();
            $table->string('subject')->comment('Объект');
            $table->string('category')->comment('Категория');
            $table->text('text')->comment('Текст статьи');
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
