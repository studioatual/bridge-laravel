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

        $group2 = Group::create([
            'name' => 'Grupo Coca Cola',
            'code' => 100,
            'cnpj' => '41826030000139',
            'type' => 0,
            'active' => 1,
        ]);

        $user2 = User::create([
            'group_id' => $group2->id,
            'name' => 'Willian Souza',
            'cpf_cnpj' => '33133314084',
            'username' => 'willian.souza',
            'email' => 'willian@fbs.com',
            'password' => '123456'
        ]);

        $company1 = Company::create([
            'group_id' => $group->id,
            'company' => 'Coca Cola São Paulo',
            'name' => 'Coca Cola Loja 1',
            'cnpj' => '38161274000135',
            'code' => 101
        ]);

        $company2 = Company::create([
            'group_id' => $group->id,
            'company' => 'Coca Cola Minas Gerais',
            'name' => 'Coca Cola Loja 30',
            'cnpj' => '14786778000182',
            'code' => 130
        ]);

        $permissions = [
            ['code' => 200, 'name' => 'PESQUISACLIENTE', 'description' => 'Pesquisar Clientes'],
            ['code' => 201, 'name' => 'PESQUISAMETA', 'description' => 'Pesquisar Metas'],
            ['code' => 202, 'name' => 'PESQUISAPRODUTO', 'description' => 'Pesquisas Produtos'],
            ['code' => 203, 'name' => 'PESQUISADIRETOR', 'description' => 'Plano Diretor'],
            ['code' => 204, 'name' => 'PESQUISAESTOQUE', 'description' => 'Pesquisar Estoque'],
            ['code' => 205, 'name' => 'PESQUISAPEDIDO', 'description' => 'Pesquisar Pedido'],
            ['code' => 206, 'name' => 'PESQUISAORDEMSERVICO', 'description' => 'Pesquisar Ordem de Serviços'],
            ['code' => 207, 'name' => 'MOVIMENTOABASTECIMENTO', 'description' => 'Movimento Abastecimento'],
            ['code' => 208, 'name' => 'CADASTROPEDIDO', 'description' => 'Cadastrar Pedidos'],
            ['code' => 209, 'name' => 'CADASTROINVENTARIO', 'description' => 'Cadastro de Inventário'],
            ['code' => 210, 'name' => 'MOVIMENTOAPROVACAO', 'description' => 'Aprovar Pedido'],
            ['code' => 211, 'name' => 'CADASTROORCAMENTO', 'description' => 'Cadastro de Orçamento'],
            ['code' => 212, 'name' => 'CADASTROORDEMSERVICO', 'description' => 'Cadastro de Ordem de Serviços'],
        ];

        foreach ($permissions as $p) {
            $permission = Permission::create($p);
            $company1->users()->attach($user2->id, ['permission_id' => $permission->id]);
            $company2->users()->attach($user2->id, ['permission_id' => $permission->id]);
        }
        */
    }
}
