<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ExpandBusinessWebSettingsForGlobalSettings extends Migration
{
    public function up()
    {
        $fields = [];

        foreach ([
            'site_title' => [
                'type'       => 'VARCHAR',
                'constraint' => 180,
                'null'       => true,
                'after'      => 'business_id',
            ],
            'site_description' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'site_title',
            ],
            'logo_image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'site_description',
            ],
            'footer_text' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'logo_image',
            ],
            'primary_color' => [
                'type'       => 'VARCHAR',
                'constraint' => 24,
                'null'       => true,
                'after'      => 'footer_text',
            ],
            'secondary_color' => [
                'type'       => 'VARCHAR',
                'constraint' => 24,
                'null'       => true,
                'after'      => 'primary_color',
            ],
            'facebook_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'secondary_color',
            ],
            'instagram_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'facebook_url',
            ],
            'twitter_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'instagram_url',
            ],
            'youtube_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'twitter_url',
            ],
            'contact_email' => [
                'type'       => 'VARCHAR',
                'constraint' => 160,
                'null'       => true,
                'after'      => 'youtube_url',
            ],
            'contact_phone' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
                'null'       => true,
                'after'      => 'contact_email',
            ],
            'default_seo_title' => [
                'type'       => 'VARCHAR',
                'constraint' => 180,
                'null'       => true,
                'after'      => 'contact_phone',
            ],
            'default_seo_description' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'default_seo_title',
            ],
            'default_seo_keywords' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'default_seo_description',
            ],
            'default_social_image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
                'after'      => 'default_seo_keywords',
            ],
        ] as $field => $definition) {
            if (! $this->db->fieldExists($field, 'business_web_settings')) {
                $fields[$field] = $definition;
            }
        }

        if ($fields !== []) {
            $this->forge->addColumn('business_web_settings', $fields);
        }
    }

    public function down()
    {
        $dropFields = [];

        foreach ([
            'site_title',
            'site_description',
            'logo_image',
            'footer_text',
            'primary_color',
            'secondary_color',
            'facebook_url',
            'instagram_url',
            'twitter_url',
            'youtube_url',
            'contact_email',
            'contact_phone',
            'default_seo_title',
            'default_seo_description',
            'default_seo_keywords',
            'default_social_image',
        ] as $field) {
            if ($this->db->fieldExists($field, 'business_web_settings')) {
                $dropFields[] = $field;
            }
        }

        if ($dropFields !== []) {
            $this->forge->dropColumn('business_web_settings', $dropFields);
        }
    }
}
