<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Palamunin;

class PalamuninTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Palamunin::factory()->count(100)->create();
    }
}
