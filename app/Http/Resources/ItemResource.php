<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'category' => new CategoryResource($this->category),
            'location' => new LocationResource($this->location),
            'mediaType' => new MediaTypeResource($this->media_type),
            'signature' => $this->signature,
            'topic' => new TopicResource($this->topic),
        ];
    }
}
