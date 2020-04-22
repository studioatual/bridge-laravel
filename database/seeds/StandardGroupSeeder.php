<?php

use App\Models\Standard\Group;
use Illuminate\Database\Seeder;

class StandardGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Group::class, 20)->create();
    }
}
