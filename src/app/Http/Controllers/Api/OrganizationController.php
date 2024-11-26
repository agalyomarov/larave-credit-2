<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrganizationResource;
use App\Models\Organization;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    public function index(Request $request)
    {
        $queryName = $request->query('name');
        return OrganizationResource::collection(Organization::where('name', 'like', "%$queryName%")->get());
    }

    public function edit(Request $request, Organization $organization)
    {
        return OrganizationResource::make($organization);
    }
}
