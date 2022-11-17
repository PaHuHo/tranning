<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MstProduct extends Model
{
    use HasFactory;
    protected $table ="mst_product";

    protected $fillable = [
        'product_id', 
        'product_name', 
        'is_sales',
        'product_price',
        'description',
    ];
}
