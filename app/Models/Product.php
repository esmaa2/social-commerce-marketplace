<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'description', 'price', 'category', 
        'in_stock', 'image', 'additional_images', 'tags', 
         'is_digital'
    ];

    protected $casts = [
        'additional_images' => 'array',
        'in_stock' => 'boolean',
        'is_digital' => 'boolean',
    ];

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

}
