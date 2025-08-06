<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CategoryMovie extends Pivot {
    public $incrementing = false;

    protected $fillable = [
        'movie_id',
        'category_id',
    ];
}
