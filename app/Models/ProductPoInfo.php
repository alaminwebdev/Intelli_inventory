<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPoInfo extends Model
{
    use HasFactory;
    public function product() {
        return $this->hasOne(ProductInformation::class, 'id', 'product_information_id');
    }
}
