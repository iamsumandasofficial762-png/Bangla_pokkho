<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomePageSection extends Model
{
    protected $fillable = [
        'section_key',
        'title',
        'subtitle',
        'content',
        'data',
        'is_enabled',
        'sort_order',
    ];

    protected $casts = [
        'data' => 'array',
        'is_enabled' => 'boolean',
    ];
}
