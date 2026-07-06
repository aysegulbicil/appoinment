<?php

namespace App\Models;

use CodeIgniter\Model;

class BusinessWebPageModel extends Model
{
    protected $table            = 'business_web_pages';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useAutoIncrement = true;
    protected $protectFields    = true;

    protected $allowedFields = [
        'business_id',
        'title',
        'slug',
        'page_type',
        'content',
        'short_intro',
        'cover_image',
        'intro_image',
        'gallery_images',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'canonical_url',
        'social_image',
        'menu_label',
        'sort_order',
        'is_active',
        'is_visible_in_menu',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        'business_id'        => 'integer',
        'sort_order'         => 'integer',
        'is_active'          => 'boolean',
        'is_visible_in_menu' => 'boolean',
    ];

    protected $useTimestamps = true;
    protected $useSoftDeletes = true;

    public function activeForBusiness(int $businessId): self
    {
        return $this->where('business_id', $businessId)
            ->where('is_active', 1)
            ->where('deleted_at', null);
    }

    public function visibleInMenuForBusiness(int $businessId): self
    {
        return $this->where('business_id', $businessId)
            ->where('is_active', 1)
            ->where('is_visible_in_menu', 1)
            ->where('deleted_at', null);
    }
}
