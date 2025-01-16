<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Module\Job;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Job::factory()->count(20)->create(); // Creates 10 dummy jobs
    }
}
