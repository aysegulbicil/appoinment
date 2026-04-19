<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddPackageCodeToUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'package_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
                'after'      => 'company_name',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['package_code']);
    }
}
