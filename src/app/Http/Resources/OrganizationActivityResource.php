<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrganizationActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            /** @var int */
            'id' => $this->id,
            /** @var string */
            'name' => $this->name,
            /** @var array<string> */
            'contacts' => json_decode($this->contacts),
            /** @var int */
            'building_id' => $this->building_id,
            /** @var array<ActivityResource> */
            "activities" => ActivityResource::collection($this->activities),
        ];
    }
}
