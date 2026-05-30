<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'type',
        'status',
        'location',
        'date_occured',
        'contact_info',
        'image_path',
    ];

    protected function casts(): array
    {
        return [
            'date_occured' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function images()
    {
        return $this->hasMany(ItemImage::class, 'item_id')->orderBy('sort_order');
    }

    public function claims()
    {
        return $this->hasMany(Claim::class, 'item_id');
    }
}
