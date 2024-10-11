<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Blog extends Model
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
    public function author()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
    public function photos(): MorphMany
    {
        return $this->morphMany(Photo::class, 'type', 'type');
    }
    public function videos(): MorphMany
    {
        return $this->morphMany(Video::class, 'type', 'type');
    }
}
