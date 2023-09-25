<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockIn extends Model
{
    use HasFactory;
    public function stockDetail() {
        return $this->hasMany(StockInDetail::class, 'stock_in_id', 'id');
    }
    public function supplier() {
        return $this->hasOne(Supplier::class, 'id', 'supplier_id' );
    }
    
}
