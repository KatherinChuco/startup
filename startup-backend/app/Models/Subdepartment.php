<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subdepartment extends Model
{
    use HasFactory;

    protected $table = 'subdepartments';
    protected $connection = 'mysql';

    public function parentDepartment()
    {
        return $this->belongsTo(Department::class, 'parent_department_id');
    }
}
