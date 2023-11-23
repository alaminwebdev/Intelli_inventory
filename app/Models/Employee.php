<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    public function department() {
        return $this->hasOne(Department::class, 'id', 'department_id' );
    }
    public function section() {
        return $this->hasOne(Section::class, 'id', 'section_id' );
    }
    public function employee_designation() {
        return $this->hasOne(EmployeeDesignation::class, 'id', 'designation_id' );
    }
}
