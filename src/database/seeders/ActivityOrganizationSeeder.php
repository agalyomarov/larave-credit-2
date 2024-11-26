<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\Organization;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActivityOrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = DB::table('activity_organization')->count();
        if ($count > 0) {
            return;
        }
        $activities = Activity::all();
        foreach ($activities as $activity) {
            $randomIds = Organization::query()->inRandomOrder()->limit(5)->pluck('id')->toArray();
            foreach ($randomIds as $id) {
                DB::table('activity_organization')->insert([
                    'organization_id' => $id,
                    'activity_id' => $activity->id,
                ]);
            }
        }
    }
}
