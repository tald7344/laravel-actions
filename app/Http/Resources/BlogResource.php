<?php

namespace App\Http\Resources;

use App\Actions\Translations\GetModelTranslationsAction;
use App\Actions\Translations\GetModelDetailedTranslationsAction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $result = [
            'id' => (int)$this->id,
			'name' => $this->name,
			'photo' => $this->photo,
			'author' => new UserResource($this->author),
            'translations' => GetModelTranslationsAction::run($this),
            'photos' => PhotoResource::collection($this->photos),
            'videos' => VideoResource::collection($this->videos),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        if($request->detailed)
            $result['detailed_translations'] = GetModelDetailedTranslationsAction::run($this);

        return $result;
    }
}
