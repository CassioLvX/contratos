<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;

    protected $fillable = ['descricao', 'valor', 'inicio', 'termino', 'fornecedor_id'];

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedores::class, 'fornecedor_id');
    }
    public function withFornecedor()
    {
        return $this->with('fornecedor');
    }

    public function departamentos()
    {
        return $this->hasMany(RelacaoDeptContr::class, 'id_contrato');
    }

    public function withDepartamentos()
    {
        return $this->with('departamentos');
    }
}
