<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionRequisitionDetails extends Model
{
    use HasFactory;
    public function product() {
        return $this->hasOne(ProductInformation::class, 'id', 'product_id');
    }
    public function StockDetail() {
        return $this->hasMany(StockInDetail::class, 'product_information_id', 'product_id', );
    }
}
