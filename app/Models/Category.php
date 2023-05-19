<?php

namespace App\Models;

use App\Traits\HasActive;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Category extends Model
{
    use HasFactory, HasSlug, HasTranslations, HasActive;

    // protected $casts = ['name'];

    protected $fillable = [
        "name",
        "slug",
        "active",
        "image",
        "parent_id",
    ];

    public $translatable = ['name'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeOnlyParents(Builder $query): void
    {
        $query->whereNull('parent_id');
    }

    public function scopeOnlyChildren(Builder $query): void
    {
        $query->whereNotNull('parent_id');
    }

    public function placeholder($value = null)
    {
        $string = config('app.placeholder_image');
        return $value ?  str_ends_with($value, $string) : $string;
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $this->placeholder($value) ? url('/' . $value) : url('storage/' . $value),
            set: fn (?string $value) => $value ?? $this->placeholder(),
        );
    }

    public function child()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->child()->with('children');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function parents()
    {
        return $this->parent()->with('parents');
    }

    public static function childCategories($parent_id)
    {
        $categories = Category::where('parent_id', $parent_id)->get();
        $result = [];

        foreach ($categories as $category) {
            $result[] = [
                'id' => $category->id,
                'name' => $category->name,
                'children' => getChildCategories($category->id),
            ];
        }

        return $result;
    }
}
