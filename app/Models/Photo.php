<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Photo extends Model
{
    use SoftDeletes;
    use HasFactory;
    
    protected $casts = [
        'visible' => 'integer'
    ];
    

    public function photosfor(): MorphTo
    {
        return $this->morphTo();
    }
}
