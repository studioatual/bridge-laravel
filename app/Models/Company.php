<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'companies';
    protected $fillable = [
        'group_id',
        'company',
        'name',
        'cnpj',
        'ie',
    ];

    public function balances()
    {
        return $this->hasMany(Balance::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'companies_users');
    }

    public function permissions()
    {
        return $this->hasMany(UserCompanyPermission::class);
    }
}
