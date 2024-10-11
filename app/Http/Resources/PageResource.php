<?php

namespace App\Http\Resources;

use App\Actions\Translations\GetModelTranslationsAction;
use App\Actions\Translations\GetModelDetailedTranslationsAction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
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
            'name' => (string)$this->name,
            'url' => (string)$this->url,
            'photo' => (string)$this->photo,
            'translations' => GetModelTranslationsAction::run($this),
            'sections' => PageSectionResource::collection($this->sections),
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
