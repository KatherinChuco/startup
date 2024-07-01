<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';
    protected $connection = 'mysql'; 

    public function superiorDepartment () 
    {
        return $this->belongsTo(Department::class, 'superior_department_id');
    }

    public function subdepartments()
    {
        return $this->hasMany(Department::class, 'superior_department_id');
    }
}
