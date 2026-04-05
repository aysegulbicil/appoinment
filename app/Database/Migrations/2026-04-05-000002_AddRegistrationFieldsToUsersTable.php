<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRegistrationFieldsToUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 25,
                'null'       => true,
                'after'      => 'email',
            ],
            'company_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
                'after'      => 'phone',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', ['phone', 'company_name']);
    }
}
