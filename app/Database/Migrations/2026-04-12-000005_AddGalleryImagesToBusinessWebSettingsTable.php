<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddGalleryImagesToBusinessWebSettingsTable extends Migration
{
    public function up()
    {
        if (! $this->db->fieldExists('gallery_images', 'business_web_settings')) {
            $this->forge->addColumn('business_web_settings', [
                'gallery_images' => [
                    'type' => 'LONGTEXT',
                    'null' => true,
                    'after' => 'intro_image',
                ],
            ]);
        }
    }

    public function down()
    {
        if ($this->db->fieldExists('gallery_images', 'business_web_settings')) {
            $this->forge->dropColumn('business_web_settings', 'gallery_images');
        }
    }
}
