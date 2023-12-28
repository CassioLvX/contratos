<?php

namespace App\Repositories;

use App\Models\Contract;
use App\Repositories\Interfaces\ContratoRepositoryInterface;

class ContratoRepository extends Repository implements ContratoRepositoryInterface
{
    /**
     * @var string
     */
    private const FIELD_FORNECEDOR = 'supplier';

    /**
     * @var string
     */
    private const FIELD_DEPARTAMENTOS = 'department.department';

    /**
     * @var string
     */
    private const FIELD_TIPO_CONTRATO = 'type';

    /**
     * @var string
     */
    private const FIELD_INICIO = 'start_on';

    /**
     * @var string
     */
    private const FIELD_TERMINO = 'finish_on';

    /**
     * @var string
     */
    private const FIELD_START = 'start';

    /**
     * @var string
     */
    private const FIELD_END = 'end';

    /**
     * @var Contract
     */
    protected $model;

    /**
     * ContratoRepository Constructor
     *
     * @param Contract $model
     */
    public function __construct(Contract $model)
    {
        $this->model = $model;
    }

    /**
     * Obtém todos os contratos com informações de fornecedores e departamentos.
     *
     * @return array
     */
    public function getAllWithFornecedorAndDepartamentos(): array
    {
        $contratos = $this->model->with([self::FIELD_FORNECEDOR, self::FIELD_DEPARTAMENTOS])->get();

        return $contratos->toArray();
    }

    /**
     * Realiza uma pesquisa flexível nos contratos com base nos filtros fornecidos.
     *
     * @param array $dataFilter Um array associativo contendo os filtros para a pesquisa.
     *
     * @return array
     */
    public function search(array $dataFilter): array
    {
        $query = $this->model;

        if ($dataFilter[self::FIELD_FORNECEDOR]) {
            $query = $query->whereHas(
                self::FIELD_FORNECEDOR,
                function ($query) use ($dataFilter) {
                    $query->where(
                        'name',
                        'LIKE',
                        '%' . $dataFilter[self::FIELD_FORNECEDOR] . '%'
                    );
                }
            );
        }

        if ($dataFilter[self::FIELD_TIPO_CONTRATO]) {
            $query = $query->where(
                self::FIELD_TIPO_CONTRATO,
                $dataFilter[self::FIELD_TIPO_CONTRATO]
            );
        }

        if ($dataFilter[self::FIELD_INICIO] || $dataFilter[self::FIELD_TERMINO]) {
            $query = $query->where(function ($query) use ($dataFilter) {
                $dates = [
                    self::FIELD_START => $dataFilter[self::FIELD_INICIO] ?: '',
                    self::FIELD_END => $dataFilter[self::FIELD_TERMINO] ?: '',
                ];

                if ($dates[self::FIELD_START] && $dates[self::FIELD_END]) {
                    $query->whereBetween(
                            self::FIELD_INICIO,
                            [
                                $dates[self::FIELD_START],
                                $dates[self::FIELD_END]
                            ]
                        )
                        ->orWhereBetween(
                            self::FIELD_TERMINO,
                            [
                                $dates[self::FIELD_START],
                                $dates[self::FIELD_END]
                            ]
                        );
                } elseif ($dates[self::FIELD_START]) {

                    $query->where(self::FIELD_INICIO, '>=', $dates[self::FIELD_START]);

                } elseif ($dates[self::FIELD_END]) {

                    $query->orWhere(self::FIELD_TERMINO, '<=', $dates[self::FIELD_END]);

                }
            });
        }

        return $query->with(
            [
                self::FIELD_FORNECEDOR,
                self::FIELD_DEPARTAMENTOS
            ]
            )->get()
            ->toArray();
    }
}
