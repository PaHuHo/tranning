<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class MstProduct extends Model
{
    use HasFactory, Searchable;
    protected $table ="mst_product";

    protected $fillable = [
        'product_id',
        'product_name', 
        'is_sales',
        'product_price',
        'description',
    ];
    public function toSearchableArray()
    {
        return [
            'product_id' => $this->product_id,
            'product_name' => $this->product_name,

        ];
    }

}
