<?php

namespace App\Models;

use CodeIgniter\Model;

class BusinessWebSettingModel extends Model
{
    protected $table            = 'business_web_settings';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useAutoIncrement = true;
    protected $protectFields    = true;

    protected $allowedFields = [
        'business_id',
        'page_title',
        'short_intro',
        'content',
        'cover_image',
        'intro_image',
        'gallery_images',
        'show_services',
        'show_staff',
        'show_prices',
        'show_contact',
        'show_map',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        'business_id'    => 'integer',
        'show_services'  => 'boolean',
        'show_staff'     => 'boolean',
        'show_prices'    => 'boolean',
        'show_contact'   => 'boolean',
        'show_map'       => 'boolean',
    ];

    protected $useTimestamps = true;
}
