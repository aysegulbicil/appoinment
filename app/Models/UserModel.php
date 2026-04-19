<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useAutoIncrement = true;
    protected $protectFields    = true;

    protected $allowedFields = [
        'name',
        'email',
        'role',
        'phone',
        'company_name',
        'package_code',
        'password_hash',
        'is_active',
        'email_verified_at',
        'email_verification_code_hash',
        'email_verification_expires_at',
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [
        'is_active' => 'boolean',
    ];

    protected $useTimestamps = true;
}
