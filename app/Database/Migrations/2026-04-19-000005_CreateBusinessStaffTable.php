<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBusinessStaffTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'business_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
            ],
            'name' => [
                'type'       => 'VARCHAR',
                'constraint' => 120,
            ],
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 160,
            ],
            'phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 25,
                'null'       => true,
            ],
            'role' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'default'    => 'staff',
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'active',
            ],
            'invited_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'accepted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('business_id');
        $this->forge->addKey('user_id');
        $this->forge->addKey('email');
        $this->forge->addUniqueKey(['business_id', 'email']);
        $this->forge->addForeignKey('business_id', 'businesses', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('business_staff');
    }

    public function down()
    {
        $this->forge->dropTable('business_staff');
    }
}
