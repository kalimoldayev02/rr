<?php

declare(strict_types=1);

namespace App;

use Cycle\Migrations\Migration;

class CreateActivitiesTableMigration extends Migration
{
    private const string TABLE_NAME = 'activities';

    public function up(): void
    {
        $this->table(self::TABLE_NAME)
            ->addColumn('id', 'uuid')
            ->addColumn('external_id', 'bigint')
            ->addColumn('athlete_id', 'uuid')
            ->addColumn('name', 'string')
            ->addColumn('distance', 'float')
            ->addColumn('moving_time', 'float')
            ->addColumn('elapsed_time', 'float')
            ->addColumn('sport_type', 'string')
            ->addColumn('start_date', 'timestamp')
            ->addColumn('summary_polyline', 'text', ['nullable' => true, 'default' => null])
            ->setPrimaryKeys(['id'])
            ->addForeignKey(['athlete_id'], 'users', ['id'], [
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
