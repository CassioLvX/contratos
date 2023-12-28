<?php

namespace App\Http\Services\Interfaces;

interface FornecedoresServicesInterface
{
    /**
     * Salva o fornecedor no banco de dados
     *
     * @param array
     * @return null|array
     *
     * @throws \App\Exceptions\FornecedorException
     */
    public function store(array $storeData): ?array;

    /**
     * Retorna todos os fornecedores cadastrados
     *
     * @param
     * @return null|array
     *
     */
    public function getAll(): ?array;
}
