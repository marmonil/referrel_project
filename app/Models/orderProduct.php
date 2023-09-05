<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orderProduct extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    function rel_to_customer()
    {
        return $this->belongsTo(coustomer_login::class, 'customer_id');
    }

    function rel_to_product()
    {
        return $this->belongsTo(product::class, 'product_id');
    }
}
