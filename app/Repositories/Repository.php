<?php

namespace App\Repositories;

use App\Repositories\Interfaces\RepositoryInterface;

abstract class Repository implements RepositoryInterface
{

    /**
     * Retorna todos os registros do modelo de Contrato.
     *
     * @return array
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Armazena um novo registro de Contrato no banco de dados.
     *
     * @param array $data
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function store(array $data)
    {
        return $this->model->create($data);
    }
}
