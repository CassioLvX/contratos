<?php

namespace App\Http\Services\Interfaces;

interface DepartamentoServicesInterface

{
    /**
     * Salva o departamento no banco de dados
     *
     * @param array
     * @return null|array
     *
     * @throws \App\Exceptions\DepartamentoException
     */
    public function store(array $storeData): ?array;

    /**
     * Retorna todos os Departamentos cadastrados
     *
     * @param
     * @return null|array
     *
     */
    public function getAll(): ?array;
}
