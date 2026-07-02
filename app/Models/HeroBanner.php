<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroBanner extends Model
{
    protected $fillable = [

        'title',
        'subtitle',
        'button_text',
        'button_link',
        'image',
        'is_active',
        'sort_order',
        'user_id',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}