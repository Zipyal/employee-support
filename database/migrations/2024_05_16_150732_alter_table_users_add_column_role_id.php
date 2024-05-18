<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    const TABLE_NAME = 'users';

    const NEW_COLUMN = [
        'name' => 'role_id',
        'type' => 'enum',
        'params' => [
            'nullable' => true,
            'comment' => 'Роль пользователя',
            'allowed' => [
                User::ROLE_EMPLOYEE,
                User::ROLE_MENTOR,
                User::ROLE_ADMIN,
            ],
        ],
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(self::TABLE_NAME, function (Blueprint $table) {
            $table->addColumn(self::NEW_COLUMN['type'], self::NEW_COLUMN['name'], self::NEW_COLUMN['params']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table(self::TABLE_NAME, function (Blueprint $table) {
            $table->dropColumn(self::NEW_COLUMN['name']);
        });
    }
};
