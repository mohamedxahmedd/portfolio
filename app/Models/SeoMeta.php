<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SeoMeta extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'noindex' => 'boolean',
        'schema_markup' => 'array',
    ];

    public function seoable(): MorphTo
    {
        return $this->morphTo();
    }
}
