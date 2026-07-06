<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBusinessWebPagesTable extends Migration
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
            'title' => [
                'type'       => 'VARCHAR',
                'constraint' => 180,
            ],
            'slug' => [
                'type'       => 'VARCHAR',
                'constraint' => 180,
            ],
            'page_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 30,
            ],
            'content' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'short_intro' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'cover_image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'intro_image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'gallery_images' => [
                'type' => 'LONGTEXT',
                'null' => true,
            ],
            'seo_title' => [
                'type'       => 'VARCHAR',
                'constraint' => 180,
                'null'       => true,
            ],
            'seo_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'seo_keywords' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'canonical_url' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'social_image' => [
                'type'       => 'VARCHAR',
                'constraint' => 255,
                'null'       => true,
            ],
            'menu_label' => [
                'type'       => 'VARCHAR',
                'constraint' => 120,
                'null'       => true,
            ],
            'sort_order' => [
                'type'       => 'INT',
                'constraint' => 11,
                'default'    => 0,
            ],
            'is_active' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'is_visible_in_menu' => [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
            ],
            'deleted_at' => [
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
        $this->forge->addKey(['business_id', 'sort_order']);
        $this->forge->createTable('business_web_pages', true);

        $this->seedDefaultPages();
    }

    public function down()
    {
        $this->forge->dropTable('business_web_pages', true);
    }

    private function seedDefaultPages(): void
    {
        if (! $this->db->tableExists('businesses')) {
            return;
        }

        $businesses = $this->db->table('businesses')->select('id, name, slug, short_description')->get()->getResultArray();
        if ($businesses === []) {
            return;
        }

        $settingsByBusiness = [];
        if ($this->db->tableExists('business_web_settings')) {
            $settingsByBusiness = $this->db->table('business_web_settings')->get()->getResultArray();
            $settingsByBusiness = array_column($settingsByBusiness, null, 'business_id');
        }

        foreach ($businesses as $business) {
            $businessId = (int) $business['id'];
            $existing = $this->db->table('business_web_pages')
                ->where('business_id', $businessId)
                ->countAllResults();

            if ($existing > 0) {
                continue;
            }

            $settings = $settingsByBusiness[$businessId] ?? [];
            $gallery  = $settings['gallery_images'] ?? null;
            $baseTitle = trim((string) ($settings['page_title'] ?? $business['name']));
            if ($baseTitle === '') {
                $baseTitle = 'Ana Sayfa';
            }

            $pages = [
                [
                    'title'             => $baseTitle,
                    'slug'              => 'anasayfa',
                    'page_type'         => 'home',
                    'content'           => $settings['content'] ?? $business['short_description'] ?? null,
                    'short_intro'       => $settings['short_intro'] ?? $business['short_description'] ?? null,
                    'cover_image'       => $settings['cover_image'] ?? null,
                    'intro_image'       => $settings['intro_image'] ?? null,
                    'gallery_images'    => $gallery,
                    'seo_title'         => $baseTitle,
                    'seo_description'   => $settings['short_intro'] ?? $business['short_description'] ?? null,
                    'menu_label'        => 'Ana Sayfa',
                    'sort_order'        => 1,
                    'is_active'         => 1,
                    'is_visible_in_menu'=> 1,
                ],
                [
                    'title'             => 'Hakkımızda',
                    'slug'              => 'hakkimizda',
                    'page_type'         => 'about',
                    'content'           => $settings['short_intro'] ?? $business['short_description'] ?? null,
                    'short_intro'       => $settings['short_intro'] ?? $business['short_description'] ?? null,
                    'cover_image'       => $settings['cover_image'] ?? null,
                    'intro_image'       => $settings['intro_image'] ?? null,
                    'gallery_images'    => null,
                    'seo_title'         => 'Hakkımızda',
                    'seo_description'   => $settings['short_intro'] ?? $business['short_description'] ?? null,
                    'menu_label'        => 'Hakkımızda',
                    'sort_order'        => 2,
                    'is_active'         => 1,
                    'is_visible_in_menu'=> 1,
                ],
                [
                    'title'             => 'Hizmetler',
                    'slug'              => 'hizmetler',
                    'page_type'         => 'services',
                    'content'           => null,
                    'short_intro'       => null,
                    'cover_image'       => null,
                    'intro_image'       => null,
                    'gallery_images'    => null,
                    'seo_title'         => 'Hizmetler',
                    'seo_description'   => null,
                    'menu_label'        => 'Hizmetler',
                    'sort_order'        => 3,
                    'is_active'         => 1,
                    'is_visible_in_menu'=> 1,
                ],
                [
                    'title'             => 'Galeri',
                    'slug'              => 'galeri',
                    'page_type'         => 'gallery',
                    'content'           => null,
                    'short_intro'       => null,
                    'cover_image'       => $settings['cover_image'] ?? null,
                    'intro_image'       => null,
                    'gallery_images'    => $gallery,
                    'seo_title'         => 'Galeri',
                    'seo_description'   => null,
                    'menu_label'        => 'Galeri',
                    'sort_order'        => 4,
                    'is_active'         => 1,
                    'is_visible_in_menu'=> 1,
                ],
                [
                    'title'             => 'İletişim',
                    'slug'              => 'iletisim',
                    'page_type'         => 'contact',
                    'content'           => null,
                    'short_intro'       => null,
                    'cover_image'       => null,
                    'intro_image'       => null,
                    'gallery_images'    => null,
                    'seo_title'         => 'İletişim',
                    'seo_description'   => null,
                    'menu_label'        => 'İletişim',
                    'sort_order'        => 5,
                    'is_active'         => 1,
                    'is_visible_in_menu'=> 1,
                ],
                [
                    'title'             => 'SSS',
                    'slug'              => 'sss',
                    'page_type'         => 'faq',
                    'content'           => null,
                    'short_intro'       => null,
                    'cover_image'       => null,
                    'intro_image'       => null,
                    'gallery_images'    => null,
                    'seo_title'         => 'SSS',
                    'seo_description'   => null,
                    'menu_label'        => 'SSS',
                    'sort_order'        => 6,
                    'is_active'         => 1,
                    'is_visible_in_menu'=> 1,
                ],
            ];

            foreach ($pages as $page) {
                $this->db->table('business_web_pages')->insert([
                    'business_id'        => $businessId,
                    'title'              => $page['title'],
                    'slug'               => $page['slug'],
                    'page_type'          => $page['page_type'],
                    'content'            => $page['content'],
                    'short_intro'        => $page['short_intro'],
                    'cover_image'        => $page['cover_image'],
                    'intro_image'        => $page['intro_image'],
                    'gallery_images'     => $page['gallery_images'],
                    'seo_title'          => $page['seo_title'],
                    'seo_description'    => $page['seo_description'],
                    'seo_keywords'       => null,
                    'canonical_url'      => null,
                    'social_image'       => null,
                    'menu_label'         => $page['menu_label'],
                    'sort_order'         => $page['sort_order'],
                    'is_active'          => $page['is_active'],
                    'is_visible_in_menu' => $page['is_visible_in_menu'],
                    'created_at'         => date('Y-m-d H:i:s'),
                    'updated_at'         => date('Y-m-d H:i:s'),
                ]);
            }
        }
    }
}
