<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddRoleToUsersTable extends Migration
{
    public function up()
    {
        if (! $this->db->fieldExists('role', 'users')) {
            $this->forge->addColumn('users', [
                'role' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 30,
                    'default'    => 'business_owner',
                    'after'      => 'email',
                ],
            ]);
        }

        $this->db->table('users')
            ->where('email', 'admin@appoinment.local')
            ->update(['role' => 'admin']);
    }

    public function down()
    {
        if ($this->db->fieldExists('role', 'users')) {
            $this->forge->dropColumn('users', 'role');
        }
    }
}
