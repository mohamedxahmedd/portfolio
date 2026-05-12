<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Support\LogOptions;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AboutSection extends Model implements HasMedia
{
    use InteractsWithMedia, LogsActivity;

    protected $table = 'about_section';

    protected $guarded = ['id'];

    protected $casts = [
        'years_experience' => 'integer',
        'projects_completed' => 'integer',
        'happy_clients' => 'integer',
    ];

    public static function current(): self
    {
        return static::firstOrCreate(['id' => 1]);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('profile_photo')->useDisk('public')->singleFile();
        $this->addMediaCollection('hero_image')->useDisk('public')->singleFile();
        $this->addMediaCollection('cv')
            ->useDisk('public')
            ->singleFile()
            ->acceptsMimeTypes(['application/pdf']);
    }

    /**
     * Effective CV link: uploaded PDF takes priority, falls back to external URL.
     */
    public function getCvDownloadUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('cv') ?: ($this->cv_url ?: null);
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->fit(Fit::Crop, 400, 400)
            ->format('webp');

        $this->addMediaConversion('hero')
            ->fit(Fit::Max, 1200, 1500)
            ->format('webp');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable()->logOnlyDirty();
    }
}
