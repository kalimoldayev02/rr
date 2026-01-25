<?php

declare(strict_types=1);

namespace App;

use Cycle\Migrations\Migration;

class CreateRefreshTokensTableMigration extends Migration
{
    private const string TABLE_NAME = 'refresh_tokens';

    public function up(): void
    {
        $this->table(self::TABLE_NAME)
            ->addColumn('id', 'uuid')
            ->addColumn('athlete_id', 'uuid')
            ->addColumn('token', 'text')
            ->addColumn('expires_at', 'timestamp')
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
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
