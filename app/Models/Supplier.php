<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $table = 'supplier';

    protected $fillable = [
        'name',
        'description',
        'address',
        'phone',
        'email',
    ];

    public function contract()
    {
        return $this->hasMany(Contract::class, 'supplier');
    }
}
