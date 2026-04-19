<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class BusinessStaffModel extends Model
{
    protected $table            = 'business_staff';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useAutoIncrement = true;
    protected $protectFields    = true;

    protected $allowedFields = [
        'business_id',
        'user_id',
        'name',
        'email',
        'phone',
        'role',
        'status',
        'invited_at',
        'accepted_at',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected $useTimestamps = true;

    public function active(): self
    {
        return $this->where('business_staff.status', 'active');
    }

    public function forBusiness(int $businessId): self
    {
        return $this->where('business_staff.business_id', $businessId);
    }

    public function forUser(int $userId, string $email): self
    {
        return $this->groupStart()
            ->where('business_staff.user_id', $userId)
            ->orWhere('business_staff.email', self::normalizeEmail($email))
            ->groupEnd();
    }

    public function syncUserByEmail(int $userId, string $email): void
    {
        $normalizedEmail = self::normalizeEmail($email);
        $now             = Time::now()->toDateTimeString();

        $this->where('email', $normalizedEmail)
            ->groupStart()
            ->where('user_id', null)
            ->orWhere('user_id', $userId)
            ->groupEnd()
            ->set([
                'user_id'     => $userId,
                'accepted_at' => $now,
            ])
            ->update();
    }

    public static function normalizeEmail(string $email): string
    {
        return strtolower(trim($email));
    }
}
