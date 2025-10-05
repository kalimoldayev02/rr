<?php

declare(strict_types=1);

namespace App;

use Cycle\Migrations\Migration;

class CreateClubsAthletesTableMigration extends Migration
{
    private const string TABLE_NAME = 'clubs_athletes';

    public function up(): void
    {
        $this->table(self::TABLE_NAME)
            ->addColumn('club_id', 'uuid')
            ->addColumn('user_id', 'uuid')
            ->setPrimaryKeys(['club_id', 'user_id'])
            ->addForeignKey(['club_id'], 'clubs', ['id'], [
                'cascade' => true,
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addForeignKey(['user_id'], 'users', ['id'], [
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
