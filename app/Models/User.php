<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    protected $table = 'users';
    protected $fillable = [
        'group_id',
        'name',
        'code',
        'cpf_cnpj',
        'username',
        'email',
        'password',
        'hash',
        'active',
        'admin'
    ];

    protected $hidden = [
        'password',
        'hash',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'companies_users_permissions');
        //return $this->belongsToMany(Company::class, 'companies_users_permissions')->withPivot('permission_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'companies_users_permissions')->withPivot('company_id');
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
