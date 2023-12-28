<?php

namespace App\Repositories\Interfaces;

interface RepositoryInterface
{
    /**
     * Retorna todos os registros do modelo de Contrato.
     *
     * @return array
     */
    public function all();

    /**
     * Armazena um novo registro de Contrato no banco de dados.
     *
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(array $data);
}
