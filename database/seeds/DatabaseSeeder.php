<?php

use App\Models\Company;
use App\Models\Group;
use App\Models\Permission;
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
            'name' => 'FBS Sistemas',
            'code' => '0',
            'cnpj' => '38161274000135',
            'type' => 1,
            'active' => 1,
        ]);

        $user = User::create([
            'group_id' => $group->id,
            'name' => 'Administrador',
            'cpf_cnpj' => '22461406090',
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password' => 'admin'
        ]);
        /*
        $company1 = Company::create([
            'group_id' => $group->id,
            'company' => 'FBS Sistemas do Brasil Ltda',
            'name' => 'FBS Sistemas',
            'cnpj' => '38161274000135',
            'code' => 1
        ]);

        $company2 = Company::create([
            'group_id' => $group->id,
            'company' => 'FBS Sistemas Empresa 2',
            'name' => 'FBS Sistemas 2',
            'cnpj' => '14786778000182',
            'code' => 2
        ]);

        $permission1 = Permission::create([
            'code' => 483,
            'name' => 'PESQUISADIRETOR',
            'description' => 'Plano Diretor'
        ]);

        $permission2 = Permission::create([
            'code' => 211,
            'name' => 'PLANODIRETOR',
            'description' => 'Plano Diretor2'
        ]);

        $company1->users()->attach($user->id, ['permission_id' => $permission1->id]);
        $company2->users()->attach($user->id, ['permission_id' => $permission1->id]);
        $company1->users()->attach($user->id, ['permission_id' => $permission2->id]);
        */
    }
}
