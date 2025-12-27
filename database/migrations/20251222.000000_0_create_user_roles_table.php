<?php

declare(strict_types=1);

namespace App;

use Cycle\Migrations\Migration;

class CreateUserRolesTableMigration extends Migration
{
    private const string TABLE_NAME = 'user_club_roles';

    public function up(): void
    {
        $this->table(self::TABLE_NAME)

            ->addColumn('id', 'uuid')
            ->addColumn('athlete_id', 'uuid')
            ->addColumn('club_id', 'uuid')
            ->addColumn('role_id', 'uuid')
            ->setPrimaryKeys(['id'])
            ->addForeignKey(['athlete_id'], 'users', ['id'], [
                'cascade' => true,
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addForeignKey(['role_id'], 'roles', ['id'], [
                'cascade' => true,
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addForeignKey(['club_id'], 'clubs', ['id'], [
                'cascade' => true,
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->create();
    }

    public function down(): void
    {
        $this->table(self::TABLE_NAME)->drop();
    }
}