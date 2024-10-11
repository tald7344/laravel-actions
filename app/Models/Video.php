<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Video extends Model
{
    protected $casts = [
        'visible' => 'integer'
    ];

    use SoftDeletes;
    use HasFactory;
    public function photosfor(): MorphTo
    {
        return $this->morphTo();
    }
}
