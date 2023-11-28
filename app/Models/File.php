<?php

namespace App\Models;

use App\Models\Traits\HasMediaCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class File extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, HasMediaCollection {
        HasMediaCollection::registerMediaConversions insteadof InteractsWithMedia;
        HasMediaCollection::registerMediaCollections insteadof InteractsWithMedia;
    }

    protected $fillable = [
        'user_id',
        'name'
    ];

    protected static function boot()
    {
        parent::boot();

        self::with('media');
    }

    /**
     * Calculate name based on provided by user, or uploaded file name
     */
    public function computedName(): string
    {
        return $this->name ?? $this->media->first()->name;
    }
}
