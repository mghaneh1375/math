<?php

namespace Database\Seeders;

use App\Models\PublicSeoTag;
use Illuminate\Database\Seeder;

class PublicSeoTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PublicSeoTag::create([
            "key" => "key1",
            "value" => "value2"
        ]);
        
        PublicSeoTag::create([
            "key" => "key2",
            "value" => "value3"
        ]);
    }
}
