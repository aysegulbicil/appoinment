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
