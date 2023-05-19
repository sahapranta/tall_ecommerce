<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Image\Manipulations;
use App\Enums\ProductStatusEnum;
use Spatie\Sluggable\SlugOptions;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use RalphJSmit\Laravel\SEO\Support\HasSEO;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class Product extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, HasSlug, InteractsWithMedia;
    use HasSEO;

    public function getDynamicSEOData(): SEOData
    {
        return new SEOData(
            title: $this->title,
        );
    }

    protected $fillable = [
        'title',
        'slug',
        'description',
        'active',
        'status',
        'has_special_offer',
        'offer_type',
        'offer_value',
        'sale_count',
        'category_id',
        'user_id',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'active' => 'boolean',
        'has_special_offer' => 'boolean',
        'status' => ProductStatusEnum::class
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('products')
            ->useFallbackUrl(asset(config('app.placeholder_image')))
            ->useFallbackPath(config('app.placeholder_image'));

        $this->addMediaCollection('featured')
            ->useFallbackUrl(asset(config('app.placeholder_image')))
            ->useFallbackPath(config('app.placeholder_image'));
    }



    // public function registerMediaConversions(Media $media = null): void
    // {
    //     $this
    //         ->addMediaConversion('preview')
    //         ->fit(Manipulations::FIT_CROP, 300, 300)
    //         ->nonQueued();
    // }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variant()
    {
        // return $this->variants()->one()->whereNot('stock', 50);
        return $this->variants()->one()->ofMany('offer_price', 'min');
    }

    public function variants()
    {
        return $this->hasMany(Variant::class);
    }

    public function variantOptions()
    {
        return $this->hasMany(VariantOption::class);
    }

    public function images()
    {
        return $this->media()->where('collection_name', 'products');
    }

    public function featuredImage()
    {
        return $this->morphOne(Media::class, 'model')->where('collection_name', 'featured');
    }

    public function getThumbAttribute()
    {
        return last($this->featuredImage?->getResponsiveImageUrls() ?? [asset(config('app.placeholder_image'))]);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function allVariantOptions()
    {
        // return $this->variants->flatMap(fn ($v) => $v->options->map(fn ($o) => ['name' => $o->name, 'value' => $o->pivot->value]))->groupBy('name')->toArray();
        if ($this->variants->isEmpty()) {
            return [];
        }

        return $this
            ->variants
            ->flatMap(function ($v) {
                if ($v->options->isEmpty()) {
                    return [];
                }
                return $v->options->map(function ($o) use ($v) {
                    return [
                        'name' => $o->name,
                        'value' => $o->pivot->value ?? null,
                        'variant_id' => $v->id,
                    ];
                });
            })
            ->groupBy('name')
            // ->map(fn ($group) => $group->pluck('value')->unique()->values())
            // ->map(fn ($group) => $group->pluck('value')->values())
            // ->mapWithKeys(fn ($values, $key) => [$key => $values])
            ->toArray();
    }

    // public function getOfferAttribute()
    // {
    //     if ($this->has_special_offer) {
    //         return $this->offer_type === 'percent' ? $this->offer_value / 100 : $this->offer_value;
    //     }
    //     return 0;
    // }


    protected static function booted()
    {
        if (Auth::check()) {
            static::creating(function ($model) {
                $model->user_id = \Auth::id();
            });

            static::updating(function ($model) {
                $model->updated_by = \Auth::id();
            });

            static::deleting(function ($model) {
                $model->deleted_by = \Auth::id();
            });
        }
    }
}
