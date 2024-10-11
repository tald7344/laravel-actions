<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Language extends Model
{
    use SoftDeletes;
    use HasFactory;
    public function translations($id): MorphMany
    {
        return $this->morphMany(Translation::class, 'type', 'type')->where('language_id',$id);
    }
    public function allTranslations(): MorphMany
    {
        return $this->morphMany(Translation::class, 'type', 'type');
    }
}
