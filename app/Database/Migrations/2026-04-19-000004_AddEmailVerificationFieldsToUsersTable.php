<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\I18n\Time;

class AddEmailVerificationFieldsToUsersTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'email_verified_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'is_active',
            ],
            'email_verification_code_hash' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'email_verified_at',
            ],
            'email_verification_expires_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'email_verification_code_hash',
            ],
        ]);

        $this->db->table('users')
            ->where('email_verified_at', null)
            ->update(['email_verified_at' => Time::now()->toDateTimeString()]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', [
            'email_verified_at',
            'email_verification_code_hash',
            'email_verification_expires_at',
        ]);
    }
}
