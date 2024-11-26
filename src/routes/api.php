<?php

use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\BuildingController;
use App\Http\Controllers\Api\OrganizationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/buildings/{building}/organizations', [BuildingController::class, 'organizations']);
Route::get('/buildings/map/rectangle/organizations', [BuildingController::class, 'mapRectangleOrganizations']);
Route::get('/buildings/map/circle/organizations', [BuildingController::class, 'mapCircleOrganizations']);
Route::get('/activities/{activity}/organizations', [ActivityController::class, 'organizations']);
Route::get('/activities/{activity}/tree/organizations', [ActivityController::class, 'treeOrganizations']);
Route::get('/organizations', [OrganizationController::class, 'index']);
Route::get('/organizations/{organization}', [OrganizationController::class, 'edit']);
