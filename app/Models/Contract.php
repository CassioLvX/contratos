<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $table = 'contract';

    protected $fillable = ['description', 'type', 'value', 'start_on', 'finish_on', 'supplier_id'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }
    public function withSupplier()
    {
        return $this->with('supplier');
    }

    public function department()
    {
        return $this->hasMany(ContractDepartment::class, 'contract_id');
    }

    public function withDepartment()
    {
        return $this->with('departments');
    }
}
