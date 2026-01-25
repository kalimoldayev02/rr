<?php

declare(strict_types=1);

namespace App;

use Cycle\Migrations\Migration;

class CreateEventsTableMigration extends Migration
{
    private const string TABLE_NAME = 'events';

    public function up(): void
    {
        $this->table(self::TABLE_NAME)
            ->addColumn('id', 'uuid')
            ->addColumn('title', 'string')
            ->addColumn('author_id', 'uuid')
            ->addColumn('club_id', 'uuid')
            ->addColumn('date', 'timestamp')
            ->setPrimaryKeys(['id'])
            ->addForeignKey(['author_id'], 'users', ['id'], [
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
