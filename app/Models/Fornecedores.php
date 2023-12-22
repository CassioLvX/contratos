<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fornecedores extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
        'contato_principal',
        'endereco',
        'telefone',
        'email',
    ];

    public function contratos()
    {
        return $this->hasMany(Contrato::class, 'fornecedor_envolvido');
    }
}
