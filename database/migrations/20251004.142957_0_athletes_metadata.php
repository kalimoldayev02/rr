<?php

declare(strict_types=1);

namespace App;

use Cycle\Migrations\Migration;

class AthletesMetadataMigration extends Migration
{
    private const string TABLE_NAME = 'athlete_metadata';

    public function up(): void
    {
        $this->table(self::TABLE_NAME)
            ->addColumn('athlete_id', 'uuid')
            ->addColumn('external_id', 'bigint')
            ->setPrimaryKeys(['athlete_id'])
            ->addIndex(['external_id'], ['unique' => true])
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
