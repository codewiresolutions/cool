<?php

namespace App\Models;

use App\Company;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class CompanyUser extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $fillable = [
        'company_id', 'name', 'email', 'password', 'role', 'invited_at',
        'invite_token_expires_at',
        'invite_token',
        'is_active',
        'accepted_at',
        'email_verified_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
