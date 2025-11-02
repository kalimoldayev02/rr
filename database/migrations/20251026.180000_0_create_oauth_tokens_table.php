<?php

declare(strict_types=1);

namespace App;

use Cycle\Migrations\Migration;

class CreateOauthTokensTableMigration extends Migration
{
    private const string TABLE_NAME = 'oauth_tokens';

    public function up(): void
    {
        $this->table(self::TABLE_NAME)
            ->addColumn('id', 'uuid')
            ->addColumn('user_id', 'uuid')
            ->addColumn('provider', 'string')
            ->addColumn('access_token', 'text')
            ->addColumn('refresh_token', 'text')
            ->addColumn('expires_at', 'timestamptz')
            ->setPrimaryKeys(['id'])
            ->addForeignKey(['user_id'], 'users', ['id'], [
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