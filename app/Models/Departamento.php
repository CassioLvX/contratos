<?php

namespace App\Models;

use App\Models\Contrato;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'descricao'];

    public function contratos()
    {
        return $this->hasMany(RelacaoDeptContr::class, 'id_departamento');
    }
}
