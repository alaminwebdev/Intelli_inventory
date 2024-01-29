<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductInformation extends Model
{
    use HasFactory;
    public function unit() {
        return $this->hasOne(Unit::class, 'id', 'unit_id' );
    }
    public function product_type() {
        return $this->hasOne(ProductType::class, 'id', 'product_type_id' );
    }
}
