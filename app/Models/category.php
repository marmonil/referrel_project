<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class category extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['category_name', 'category_image', 'category_id'];
    function rel_to_user()
    {
        return $this->belongsTo(User::class, 'added-by');
    }
}
