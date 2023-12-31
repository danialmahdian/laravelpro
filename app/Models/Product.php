<?php

namespace App\Models;

use App\ProductAttributeValues;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'title',
        'description',
        'price',
        'inventory',
        'view_count',
        'image',
    ];


    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)->using(ProductAttributeValues::class)->withPivot(['value_id']);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function gallery()
    {
        return $this->hasMany(ProductGallery::class);
    }
}
