<?php

namespace App\Http\Services;

use App\Exceptions\FornecedorException;
use App\Http\Services\Interfaces\FornecedoresServicesInterface;
use App\Repositories\Interfaces\FornecedoresRepositoryInterface;

class FornecedoresServices implements FornecedoresServicesInterface
{
    /**
     * @var FornecedoresRepositoryInterface
     */
    protected $fornecedoresRepository;

    /**
     * FornecedoresServices Constructor
     *
     * @param FornecedoresRepositoryInterface $fornecedoresRepository
     */
    public function __construct(
        FornecedoresRepositoryInterface $fornecedoresRepository
    ) {
        $this->fornecedoresRepository = $fornecedoresRepository;
    }

    /**
     * Retorna todos os dados de Fornecedores
     *
     * @return array
     */
    public function getAll(): array
    {
        return $this->fornecedoresRepository->all()->toArray();
    }

    /**
     * Salva novo fornecedor no banco de dados
     *
     * @param array $fornecedorPayload
     * @return null|array
     *
     * @throws FornecedorException
     */
    public function store(array $fornecedorPayload): ?array
    {
        $fornecedorSalvo = $this->fornecedoresRepository->store($fornecedorPayload);

        if (!$fornecedorSalvo) {
            throw new FornecedorException("Error de serviço, verificar track " . self::class);
        }

        return $fornecedorSalvo->toArray();
    }

}
