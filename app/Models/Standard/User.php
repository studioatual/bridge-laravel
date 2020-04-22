<?php

namespace App\Models\Standard;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'standard_users';
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

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
