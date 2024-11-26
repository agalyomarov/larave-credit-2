<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrganizationActivityResource;
use App\Http\Resources\OrganizationResource;
use App\Models\Activity;
use App\Models\Organization;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function organizations(Request $request, Activity $activity)
    {
        return OrganizationResource::collection($activity->organizations);
    }

    public function treeOrganizations(Request $request, Activity $activity)
    {
        $activitiesIds = collect();
        $activitiesIds->push($activity->id);
        $this->collectChildIds($activity, $activitiesIds);
        $organizations = Organization::whereHas('activities', function ($query) use ($activitiesIds) {
            $query->whereIn('activities.id', $activitiesIds);
        })->with('activities')->get();
        return OrganizationActivityResource::collection($organizations);
    }

    private function collectChildIds($activity, &$activitiesIds)
    {
        $activity->children->each(function ($child) use ($activitiesIds) {
            $activitiesIds->push($child->id);
            $this->collectChildIds($child, $activitiesIds);
        });
    }
}
