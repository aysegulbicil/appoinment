<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DefaultAdminSeeder extends Seeder
{
    public function run()
    {
        $builder = $this->db->table('users');

        $existing = $builder->where('email', 'admin@appoinment.local')->get()->getRowArray();

        if ($existing) {
            $builder->where('id', $existing['id'])->update(['role' => 'admin']);
            return;
        }

        $builder->insert([
            'name'          => 'System Admin',
            'email'         => 'admin@appoinment.local',
            'role'          => 'admin',
            'password_hash' => password_hash('Admin123!', PASSWORD_DEFAULT),
            'is_active'     => 1,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);
    }
}
