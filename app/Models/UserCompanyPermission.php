<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCompanyPermission extends Model
{
    protected $table = 'user_company_permissions';
    protected $fillable = [
        'user_id',
        'company_id',
        'permission_id',
        'type'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}
