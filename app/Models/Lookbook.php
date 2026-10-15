<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lookbook extends Model
{
    protected $fillable = [
        'collection_id',
        'title',
        'slug',
        'description',
        'cover_image',
        'images',
        'photographer',
        'location',
        'is_campaign',
        'is_published',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'images' => 'array',
            'is_campaign' => 'boolean',
            'is_published' => 'boolean',
        ];
    }

    public function collection(): BelongsTo
    {
        return $this->belongsTo(Collection::class);
    }

    public function coverUrl(): ?string
    {
        if (! $this->cover_image) {
            return null;
        }

        if (str_starts_with($this->cover_image, 'http')) {
            return $this->cover_image;
        }

        return asset('storage/'.$this->cover_image);
    }
}
