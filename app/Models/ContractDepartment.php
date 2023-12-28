<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractDepartment extends Model
{
    use HasFactory;

    protected $table = 'contract_department';
    protected $fillable = ['contract_id', 'department_id'];

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function withContract()
    {
        return $this->with('contract');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function withDepartment()
    {
        return $this->with('department');
    }
}
