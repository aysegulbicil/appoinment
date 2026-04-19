<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBusinessServicesTable extends Migration
{
    public function up()
    {
        if ($this->db->tableExists('business_services')) {
            return;
        }

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
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 160,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'duration_minutes' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => true,
            ],
            'price' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,2',
                'null'       => true,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'active',
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
        $this->forge->addKey('status');
        $this->forge->createTable('business_services');
    }

    public function down()
    {
        $this->forge->dropTable('business_services', true);
    }
}
