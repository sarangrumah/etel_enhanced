<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VersionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Version::create([
            'version' => '1.0.0',
            'release_date' => '2025-10-23',
            'notes' => 'Initial release.',
        ]);
    }
}
