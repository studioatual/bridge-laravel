<?php

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $group = Group::create([
            'name' => 'Fbs Sistemas',
            'code' => '0',
            'cnpj' => '38161274000135',
            'type' => 1,
            'active' => 1,
        ]);

        User::create([
            'group_id' => $group->id,
            'name' => 'Administrador',
            'cpf_cnpj' => '22461406090',
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => 'admin'
        ]);
    }
}
