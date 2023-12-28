<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'department';

    protected $fillable = ['name', 'description'];

    public function contract()
    {
        return $this->hasMany(ContractDepartment::class, 'department_id');
    }
}
