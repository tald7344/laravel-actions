<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Translation extends Model
{
    use SoftDeletes;
    use HasFactory;
    public function translatable(): MorphTo
    {
        return $this->morphTo();
    }
}
