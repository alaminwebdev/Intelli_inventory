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
    public function requisition_owner() {
        return $this->hasOne(User::class, 'id', 'user_id' );
    }
    public function recommended_user() {
        return $this->hasOne(User::class, 'id', 'recommended_by' );
    }
    public function approve_user() {
        return $this->hasOne(User::class, 'id', 'final_approve_by' );
    }
    public function distribute_user() {
        return $this->hasOne(User::class, 'id', 'distribute_by' );
    }
}
