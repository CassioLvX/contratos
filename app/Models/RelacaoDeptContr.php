<?php

namespace App\Models;

use App\Models\Departamento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelacaoDeptContr extends Model
{
    use HasFactory;

    protected $table = 'relacao_dept_contr';
    protected $fillable = ['id_contrato', 'id_departamento'];

    public function contrato()
    {
        return $this->belongsTo(Contrato::class, 'id_contrato');
    }

    public function withContrato()
    {
        return $this->with('contrato');
    }

    public function departamento()
    {
        return $this->belongsTo(Departamento::class, 'id_departamento');
    }

    public function withDepartamentos()
    {
        return $this->with('departamentos');
    }
}
