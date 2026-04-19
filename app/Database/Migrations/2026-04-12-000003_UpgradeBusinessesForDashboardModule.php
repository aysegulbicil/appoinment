<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpgradeBusinessesForDashboardModule extends Migration
{
    public function up()
    {
        $fields = [];

        if (! $this->db->fieldExists('owner_user_id', 'businesses')) {
            $fields['owner_user_id'] = [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'id',
            ];
        }

        if (! $this->db->fieldExists('slug', 'businesses')) {
            $fields['slug'] = [
                'type'       => 'VARCHAR',
                'constraint' => 180,
                'null'       => true,
                'after'      => 'name',
            ];
        }

        if (! $this->db->fieldExists('category', 'businesses')) {
            $fields['category'] = [
                'type'       => 'VARCHAR',
                'constraint' => 120,
                'null'       => true,
                'after'      => 'slug',
            ];
        }

        if (! $this->db->fieldExists('short_description', 'businesses')) {
            $fields['short_description'] = [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'district',
            ];
        }

        if (! $this->db->fieldExists('status', 'businesses')) {
            $fields['status'] = [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'active',
                'after'      => 'short_description',
            ];
        }

        if ($fields !== []) {
            $this->forge->addColumn('businesses', $fields);
        }

        if ($this->db->fieldExists('user_id', 'businesses')) {
            $this->db->query('UPDATE businesses SET owner_user_id = user_id WHERE owner_user_id IS NULL');
        }

        if ($this->db->fieldExists('is_active', 'businesses') && $this->db->fieldExists('status', 'businesses')) {
            $this->db->query("UPDATE businesses SET status = CASE WHEN is_active = 1 THEN 'active' ELSE 'passive' END WHERE status IS NULL OR status = ''");
        }

        if ($this->db->fieldExists('name', 'businesses') && $this->db->fieldExists('slug', 'businesses')) {
            $rows = $this->db->table('businesses')
                ->select('id, name')
                ->where('slug IS NULL OR slug = ""')
                ->get()
                ->getResultArray();

            foreach ($rows as $row) {
                $this->db->table('businesses')
                    ->where('id', $row['id'])
                    ->update(['slug' => url_title((string) $row['name'], '-', true)]);
            }
        }

        if (! $this->db->fieldExists('owner_user_id', 'businesses') || ! $this->db->fieldExists('slug', 'businesses')) {
            return;
        }

        $this->forge->addKey('owner_user_id');
        $this->forge->addKey('slug');
    }

    public function down()
    {
        $dropFields = [];

        foreach (['owner_user_id', 'slug', 'category', 'short_description', 'status'] as $field) {
            if ($this->db->fieldExists($field, 'businesses')) {
                $dropFields[] = $field;
            }
        }

        if ($dropFields !== []) {
            $this->forge->dropColumn('businesses', $dropFields);
        }
    }
}
