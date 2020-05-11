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

    public function users()
    {
        return $this->belongsToMany(User::class, 'companies_users_permissions')->withPivot('permission');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'companies_users_permissions', 'company_id', 'id');
    }

    public function balances()
    {
        return $this->hasMany(Balance::class);
    }

    public function cashflow()
    {
        return $this->hasMany(Cashflow::class);
    }

    public function rankingProducts()
    {
        return $this->hasMany(RankingProduct::class);
    }

    public function rankingClients()
    {
        return $this->hasMany(RankingClient::class);
    }
}
