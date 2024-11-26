<?php

namespace Database\Seeders;

use App\Models\Activity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Activity::count() > 0) {
            return;
        }
        $activities = [
            [
                "name" => "Еда",
                "parent_id" => null,
                "children" => [
                    [
                        "name" => "Мясная продукция"
                    ],
                    [
                        "name" => "Молочная продукция"
                    ]
                ],
            ],
            [
                "name" => "Автомобили",
                "parent_id" => null,
                "children" => [
                    [
                        "name" => "Грузовые"
                    ]
                ],
            ],
            [
                "name" => "Легковые",
                "parent_id" => null,
                "children" => [
                    [
                        "name" => "Запчасти"
                    ],
                    [
                        "name" => "Аксессуары"
                    ]
                ],
            ],
        ];

        foreach ($activities as $activity) {
            $this->createActivity($activity['name'], $activity['parent_id'], $activity['children'] ?? []);
        }
    }


    private function createActivity($name, $parent_id = null, $children = [])
    {
        $parent = Activity::create([
            'name' => $name,
            'parent_id' => $parent_id
        ]);
        if (isset($children)) {
            foreach ($children as $child) {
                $this->createActivity($child['name'], $parent->id, $child['children'] ?? []);
            }
        }
    }
}
