<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WholesaleContent extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'summary',
        'content',
        'cta_label',
        'cta_url',
        'contact_email',
        'contact_phone',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
