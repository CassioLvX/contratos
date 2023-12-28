<?php

namespace App\Repositories;

use App\Models\Department;
use App\Repositories\Interfaces\DepartamentoRepositoryInterface;

class DepartamentoRepository extends Repository implements DepartamentoRepositoryInterface
{
    /**
     * @var Department
     */
    protected $model;

    /**
     * DepartamentoRepository Constructor
     *
     * @param Department $model
     */
    public function __construct(Department $model)
    {
        $this->model = $model;
    }
}
