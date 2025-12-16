<?php

declare(strict_types=1);

namespace App;

use Cycle\Migrations\Migration;

class CreateEventResultsTableMigration extends Migration
{
    private const string TABLE_NAME = 'event_results';

    public function up(): void
    {
        $this->table(self::TABLE_NAME)
            ->addColumn('id', 'uuid')
            ->addColumn('event_id', 'uuid')
            ->addColumn('athlete_id', 'uuid')
            ->addColumn('activity_id', 'uuid', ['nullable' => true, 'default' => null])
            ->addColumn('distance_reference_id', 'uuid')
            ->addColumn('duration', 'float')
            ->addColumn('duration_type', 'string')
            ->setPrimaryKeys(['id'])
            ->addForeignKey(['event_id'], 'events', ['id'], [
                'cascade' => true,
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addForeignKey(['athlete_id'], 'users', ['id'], [
                'cascade' => true,
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addForeignKey(['activity_id'], 'activities', ['id'], [
                'cascade' => true,
                'delete' => 'CASCADE',
                'update' => 'CASCADE',
            ])
            ->addForeignKey(['distance_reference_id'], 'distance_references', ['id'], [
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
