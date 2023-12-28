<?php

namespace App\Repositories;

use App\Models\ContractDepartment;
use App\Repositories\Interfaces\ContratoDepartamentoRepositoryInterface;

class ContratoDepartamentoRepository extends Repository implements ContratoDepartamentoRepositoryInterface
{
    /**
     * @var ContractDepartment
     */
    protected $model;

    /**
     * RelacaoDeptContrRepository Constructor
     *
     * @param ContractDepartment $model
     */
    public function __construct(ContractDepartment $model)
    {
        $this->model = $model;
    }
}
