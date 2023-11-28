<?php

namespace App\Models\Traits;

use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HasMediaCollection
{
    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->performOnCollections('images')
            ->fit(Manipulations::FIT_CROP, 100, 100)
            ->nonQueued();
    }

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('images')
            ->singleFile();

        $this
            ->addMediaCollection('uploads')
            ->singleFile();
    }
}
