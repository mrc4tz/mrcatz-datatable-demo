<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'sku', 'category_id', 'subcategory_id', 'price', 'stock', 'status', 'description', 'image'];
}
