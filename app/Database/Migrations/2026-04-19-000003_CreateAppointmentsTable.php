<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAppointmentsTable extends Migration
{
    public function up()
    {
        if ($this->db->tableExists('appointments')) {
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
            'business_service_id' => [
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
            'appointment_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
            ],
            'customer_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 140,
            ],
            'customer_phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 25,
            ],
            'customer_email' => [
                'type'       => 'VARCHAR',
                'constraint' => 160,
            ],
            'appointment_date' => [
                'type' => 'DATE',
            ],
            'appointment_time' => [
                'type' => 'TIME',
            ],
            'note' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'pending',
            ],
            'rejection_reason' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'suggested_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'suggested_time' => [
                'type' => 'TIME',
                'null' => true,
            ],
            'admin_note' => [
                'type' => 'TEXT',
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
        $this->forge->addUniqueKey('appointment_code');
        $this->forge->addKey('business_id');
        $this->forge->addKey('business_service_id');
        $this->forge->addKey('user_id');
        $this->forge->addKey('status');
        $this->forge->addKey(['appointment_date', 'appointment_time']);
        $this->forge->createTable('appointments');
    }

    public function down()
    {
        $this->forge->dropTable('appointments', true);
    }
}
