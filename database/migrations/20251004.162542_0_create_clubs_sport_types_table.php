<?php

declare(strict_types=1);

namespace App;

use Cycle\Migrations\Migration;

class CreateClubsSportTypesTableMigration extends Migration
{
    private const string TABLE_NAME = 'clubs_sport_types';

    public function up(): void
    {
        $this->table(self::TABLE_NAME)
            ->addColumn('club_id', 'uuid')
            ->addColumn('type', 'string')
            ->addForeignKey(['club_id'], 'clubs', ['id'], [
                'cascade' => true,
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->setPrimaryKeys(['club_id', 'type'])
            ->create();
    }

    public function down(): void
    {
        $this->table(self::TABLE_NAME)->drop();
    }
}
