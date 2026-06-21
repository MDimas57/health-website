<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryBanner extends Model
{
    protected $fillable = [
        'category_id',
        'user_id',
        'title',
        'subtitle',
        'image',
        'is_active',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}