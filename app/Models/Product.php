<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    protected $fillable = [
        'seller_id', 'category_id', 'name', 'description', 'price', 'old_price', 'stock', 'status', 'main_image',
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('id');
    }

    public function isInStock(): bool
    {
        return (int) $this->stock > 0;
    }

    public function hasStockFor(int $quantity): bool
    {
        return (int) $this->stock >= $quantity;
    }

    public function getPrimaryImageUrlAttribute(): ?string
    {
        $firstImage = null;
        if ($this->relationLoaded('images')) {
            $first = $this->images->first(fn ($img) => ! empty($img->image));
            $firstImage = $first?->image;
        } else {
            $firstImage = $this->images()
                ->whereNotNull('image')
                ->where('image', '!=', '')
                ->orderBy('id')
                ->value('image');
        }

        if (! empty($firstImage)) {
            return $this->resolveImageUrl($firstImage);
        }

        if (! empty($this->main_image)) {
            return $this->resolveImageUrl($this->main_image);
        }

        return null;
    }

    public function getGalleryImageUrlsAttribute(): array
    {
        $paths = [];
        if ($this->relationLoaded('images')) {
            $paths = $this->images
                ->pluck('image')
                ->filter(fn ($p) => ! empty($p))
                ->values()
                ->all();
        } else {
            $paths = $this->images()
                ->whereNotNull('image')
                ->where('image', '!=', '')
                ->orderBy('id')
                ->pluck('image')
                ->all();
        }

        if (empty($paths) && ! empty($this->main_image)) {
            $paths = [$this->main_image];
        }

        return collect($paths)
            ->map(fn ($path) => $this->resolveImageUrl((string) $path))
            ->filter()
            ->values()
            ->all();
    }

    private function resolveImageUrl(string $path): string
    {
        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        if (Str::startsWith($path, 'storage/')) {
            return asset($path);
        }

        return asset('storage/'.$path);
    }
}
