<?php

namespace App\Repositories;

use App\Models\Supplier;
use App\Repositories\Interfaces\FornecedoresRepositoryInterface;

class FornecedoresRepository extends Repository implements FornecedoresRepositoryInterface
{
    /**
     * @var Supplier
     */
    protected $model;

    /**
     * FornecedoresRepository Constructor
     *
     * @param Supplier $model
     */
    public function __construct(Supplier $model)
    {
        $this->model = $model;
    }
}
