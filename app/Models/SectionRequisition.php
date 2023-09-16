<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SectionRequisition extends Model {
    use HasFactory, SoftDeletes;
    public function section() {
        return $this->hasOne(Section::class, 'id', 'section_id' );
    }
}
