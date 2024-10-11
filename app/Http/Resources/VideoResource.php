<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (int)$this->id,
            'url' => $this->url,
            'type' => $this->type,
            'type_id' => (int)$this->type_id,
            'visible' => $this->visible,
            'created_at' => $this->created_at,
        ];
    }
}
