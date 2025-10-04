<?php

declare(strict_types=1);

namespace App;

use Cycle\Migrations\Migration;

class AthletesMetadataMigration extends Migration
{
    private const string TABLE_NAME = 'athletes_metadata';

    public function up(): void
    {
        $this->table(self::TABLE_NAME)
            ->addColumn('user_id', 'uuid')
            ->addColumn('external_id', 'integer')
            ->setPrimaryKeys(['user_id'])
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
