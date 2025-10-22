<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $keyType = 'string';
    public $incrementing = false;
    
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }
    

protected $with = ['role'];


    protected $fillable = [
        'id',
        'role_id',
        'name',
        'email',
        'password',
        'phone',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    

    // ✅ Role relationship
    public function role() {
    return $this->belongsTo(Role::class);
}


    // ✅ Check if user has specific permission
    public function hasPermission($permissionName)
    {
        return $this->role && $this->role->permissions->contains('name', $permissionName);
    }

    // ✅ Check if user has specific role
    public function hasRole($roleName)
    {
        return $this->role && $this->role->name === $roleName;
    }
}
