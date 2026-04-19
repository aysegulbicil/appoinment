<?php

namespace App\Models;

use CodeIgniter\Model;

class BusinessModel extends Model
{
    protected $table            = 'businesses';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useAutoIncrement = true;
    protected $protectFields    = true;

    protected $allowedFields = [
        'user_id',
        'owner_user_id',
        'package_code',
        'name',
        'slug',
        'category',
        'phone',
        'email',
        'city',
        'district',
        'short_description',
        'status',
        'address',
        'notes',
        'is_active',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        'user_id'       => 'integer',
        'owner_user_id' => 'integer',
        'is_active'     => 'boolean',
    ];

    protected $useTimestamps = true;

    public function forOwner(int $userId): self
    {
        return $this->groupStart()
            ->where('owner_user_id', $userId)
            ->orWhere('user_id', $userId)
            ->groupEnd();
    }

    public function accessibleByUser(int $userId, string $email): self
    {
        $email = strtolower(trim($email));

        return $this->select('businesses.*')
            ->distinct()
            ->join(
                'business_staff',
                "business_staff.business_id = businesses.id AND business_staff.status = 'active'",
                'left'
            )
            ->groupStart()
            ->where('businesses.owner_user_id', $userId)
            ->orWhere('businesses.user_id', $userId)
            ->orWhere('business_staff.user_id', $userId)
            ->orWhere('business_staff.email', $email)
            ->groupEnd();
    }

    public function ownedByUser(int $userId): self
    {
        return $this->groupStart()
            ->where('businesses.owner_user_id', $userId)
            ->orWhere('businesses.user_id', $userId)
            ->groupEnd();
    }
}
