<?php

declare(strict_types=1);

namespace App;

use Cycle\Migrations\Migration;

class CreateClubsTableMigration extends Migration
{
    private const string TABLE_NAME = 'clubs';

    public function up(): void
    {
        $this->table(self::TABLE_NAME)
            ->addColumn('id', 'uuid')
            ->addColumn('external_id', 'string')
            ->addColumn('name', 'string')
            ->addColumn('description', 'string', ['nullable' => true, 'default' => null])
            ->addIndex(['external_id'], ['unique' => true])
            ->setPrimaryKeys(['id'])
            ->create();
    }

    public function down(): void
    {
        $this->table(self::TABLE_NAME)->drop();
    }
}
