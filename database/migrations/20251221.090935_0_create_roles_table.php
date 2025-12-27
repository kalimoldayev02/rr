<?php

declare(strict_types=1);

namespace App;

use Cycle\Migrations\Migration;

class CreateRolesTableMigration extends Migration
{
    private const string TABLE_NAME = 'roles';

    public function up(): void
    {
        $this->table(self::TABLE_NAME)
            ->addColumn('id', 'uuid')
            ->addColumn('name', 'string')
            ->setPrimaryKeys(['id'])
            ->create();
    }

    public function down(): void
    {
        $this->table(self::TABLE_NAME)->drop();
    }
}
