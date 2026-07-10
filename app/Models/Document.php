<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Document extends Model
{
    use HasFactory;
    use HasSlug;
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    protected $table = 'documents';

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'slug',
        'description',
        'document_file',
        'cover',
        'file_size',
        'status',
        'is_featured',
        'published_at',
        'download_count',
    ];

    /*
    |--------------------------------------------------------------------------
    | CAST
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | SLUG
    |--------------------------------------------------------------------------
    */

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION
    |--------------------------------------------------------------------------
    */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR
    |--------------------------------------------------------------------------
    */

    public function getFileExtensionAttribute()
    {
        return pathinfo($this->document_file, PATHINFO_EXTENSION);
    }

    public function getFileNameAttribute()
    {
        return basename($this->document_file);
    }

    public function getFileSizeMbAttribute()
    {
        if (!$this->file_size) {
            return null;
        }

        return round($this->file_size / 1024 / 1024, 2);
    }
}