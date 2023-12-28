<?php

namespace App\Repositories\Interfaces;

interface ContratoRepositoryInterface extends RepositoryInterface
{
    /**
     * Obtém todos os contratos com informações de fornecedores e departamentos.
     *
     * @return array
     */
    public function getAllWithFornecedorAndDepartamentos(): array;

    /**
     * Realiza uma pesquisa flexível nos contratos com base nos filtros fornecidos.
     *
     * @param array $dataFilter
     *
     * @return array
     */
    public function search(array $dataFilter): array;
}
