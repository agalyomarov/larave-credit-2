<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrganizationResource;
use App\Models\Building;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BuildingController extends Controller
{
    public function organizations(Request $request, Building $building)
    {

        return OrganizationResource::collection($building->organizations);
    }

    public function mapRectangleOrganizations(Request $request, Building $building)
    {
        $validated = $request->validate([
            'min_lat' => 'nullable|numeric',
            'max_lat' => 'nullable|numeric',
            'min_lon' => 'nullable|numeric',
            'max_lon' => 'nullable|numeric',
        ]);

        $buildingIds = Building::whereBetween('latitude', [$validated['min_lat'], $validated['max_lat']])
            ->whereBetween('longitude', [$validated['min_lon'], $validated['max_lon']])
            ->with('organizations')
            ->pluck("id")
            ->unique()
            ->toArray();

        $organizations = Organization::whereIn('building_id', $buildingIds)->get();
        return OrganizationResource::collection($organizations);
    }

    public function mapCircleOrganizations(Request $request, Building $building)
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|numeric',
        ]);

        $latitude = $validated['latitude'];
        $longitude = $validated['longitude'];
        $radius = $validated['radius'];

        // Радиус Земли в километрах ~
        $earthRadius = 6371;

        $buildingIds = Building::select('*', DB::raw("
            ($earthRadius * acos(
                cos(radians($latitude)) *
                cos(radians(latitude)) *
                cos(radians(longitude) - radians($longitude)) +
                sin(radians($latitude)) *
                sin(radians(latitude))
            )) AS distance
        "))->having('distance', '<=', $radius) // Фильтрация по радиусу
            ->orderBy('distance', 'asc')        // Сортировка по удаленности
            ->with('organizations')            // Загрузка организаций
            ->pluck("id")
            ->unique()
            ->toArray();

        $organizations = Organization::whereIn('building_id', $buildingIds)->get();
        return OrganizationResource::collection($organizations);
    }
}
