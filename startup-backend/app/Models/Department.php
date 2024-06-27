<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments';
    protected $connection = 'mysql'; 

    public function subdepartments()
    {
        return $this->hasMany(Subdepartment::class, 'parent_department_id');
    }
}
