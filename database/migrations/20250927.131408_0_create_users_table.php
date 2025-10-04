<?php

declare(strict_types=1);

namespace App;

use Cycle\Migrations\Migration;

class CreateUsersTableMigration extends Migration
{
    private const string TABLE_NAME = 'users';

    public function up(): void
    {
        $this->table(self::TABLE_NAME)
            ->addColumn('id', 'uuid')
            ->addColumn('firstname', 'string')
            ->addColumn('lastname', 'string')
            ->addColumn('gender', 'string', ['nullable' => true, 'default' => null])
            ->addColumn('birthday', 'date', ['nullable' => true, 'default' => null])
            ->addColumn('email', 'string', ['nullable' => true, 'default' => null, 'unique' => true])
            ->setPrimaryKeys(['id'])
            ->create();
    }

    public function down(): void
    {
        $this->table(self::TABLE_NAME)->drop();
    }
}
