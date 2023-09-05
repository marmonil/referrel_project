<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    function rel_to_category()
    {
        return $this->belongsTo(category::class, 'category_id');
    }
    function rel_to_inventories()
    {
        return $this->hasMany(inventory::class, 'product_id');
    }
    protected $guarded = ['id'];
}
