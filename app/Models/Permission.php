<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';
    protected $fillable = [
        'code',
        'name',
        'description'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'companies_users_permissions');
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'companies_users_permissions');
    }
}
