<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBusinessWorkingHoursTable extends Migration
{
    public function up(): void
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
            // ISO-8601: 1 = Pazartesi ... 7 = Pazar
            'day_of_week' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'unsigned'   => true,
            ],
            'is_open' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 0,
            ],
            'start_time' => [
                'type' => 'TIME',
                'null' => true,
            ],
            'end_time' => [
                'type' => 'TIME',
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
        $this->forge->addUniqueKey(['business_id', 'day_of_week']);
        $this->forge->addForeignKey('business_id', 'businesses', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('business_working_hours');
    }

    public function down(): void
    {
        $this->forge->dropTable('business_working_hours');
    }
}
