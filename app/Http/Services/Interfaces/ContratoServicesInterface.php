<?php

namespace App\Http\Services\Interfaces;

interface ContratoServicesInterface
{
    /**
     * Retorna todos os contratos com suas respectivas relações
     *
     * @return array
     */
    public function getAll(): array;

    /**
     * Armazena um novo contrato e suas relações com departamentos no banco de dados.
     *
     * @param  array  $storeData
     * @return bool
     * @throws \App\Exceptions\ContratoException
     */
    public function store(array $storeData): bool;

    /**
     * Usada para filtar os contratos a serem exibidos
     *
     * @param array $dataFilter
     * @return array|null
     */
    public function filter(array $data): ?array;

}
