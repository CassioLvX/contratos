<?php

namespace App\Http\Services;

use App\Exceptions\DepartamentoException;
use App\Http\Services\Interfaces\DepartamentoServicesInterface;
use App\Repositories\Interfaces\DepartamentoRepositoryInterface;

class DepartamentoServices implements DepartamentoServicesInterface
{
    /**
     * @var DepartamentoRepositoryInterface
     */
    protected $departamentoRepository;

    /**
     * DepartamentoServices Constructor
     *
     * @param DepartamentoRepositoryInterface $departamentoRepository
     */
    public function __construct(
        DepartamentoRepositoryInterface $departamentoRepository
    ) {
        $this->departamentoRepository = $departamentoRepository;
    }

   /**
    * Retorna todos os dados de Departamentos
    *
    * @return array
    */
    public function getAll(): array
    {
        return $this->departamentoRepository->all()->toArray();
    }

    /**
     * Salva novo departamento no banco de dados
     *
     * @param array $departamentosPayload
     * @return null|array
     *
     * @throws DepartamentoException
     */
    public function store(array $departamentosPayload): ?array
    {
        $departamentosSalvo = $this->departamentoRepository->store($departamentosPayload);

        if (!$departamentosSalvo) {
            throw new DepartamentoException("Error de serviço, verificar track " . self::class);
        }

        return $departamentosSalvo->toArray();
    }

}
