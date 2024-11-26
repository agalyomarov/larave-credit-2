<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Organization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Organization::count() > 0) {
            return;
        }
        foreach (Building::all() as $building) {
            Organization::factory()->create([
                'building_id' => $building->id,
            ]);
            Organization::factory()->create([
                'building_id' => $building->id,
            ]);
            Organization::factory()->create([
                'building_id' => $building->id,
            ]);
        }
    }
}
