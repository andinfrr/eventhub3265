<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Organization;

#[Fillable([
    'name',
    'email',
    'password',
    'role',
    'organization_id',
    'google_id',
    'avatar'
])]

#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
     * User milik satu organisasi.
     */
    public function organization()
    {
        return $this->belongsTo(\App\Models\Organization::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}