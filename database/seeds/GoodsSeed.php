<?php

use Illuminate\Database\Seeder;

class GoodsSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Model\Good::class, 5)->create();
    }
}
