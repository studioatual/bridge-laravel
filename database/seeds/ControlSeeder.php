<?php

use Illuminate\Database\Seeder;
use App\Models\Control;

class ControlSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Control::class)->create([
            'type' => 'Mobile',
        ]);

        factory(Control::class)->create([
            'type' => 'Desktop',
        ]);
    }
}
