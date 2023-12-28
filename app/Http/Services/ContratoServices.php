<?php

namespace App\Http\Services;

use App\Http\Services\Interfaces\ContratoServicesInterface;
use App\Repositories\Interfaces\ContratoDepartamentoRepositoryInterface;
use App\Repositories\Interfaces\ContratoRepositoryInterface;
use App\Repositories\Interfaces\RelacaoDeptContrRepositoryInterface;
use Exception;
use App\Exceptions\ContratoException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ContratoServices implements ContratoServicesInterface
{
    /**
     * @var string
     */
    private const FIELD_ID_CONTRATO = 'contract_id';

    /**
     * @var string
     */
    private const FIELD_ID_DEPARTAMENTO = 'department_id';

    /**
     * @var string
     */
    private const FIELD_DEPARTAMENTOS = 'departments';

    /**
     * @var ContratoRepositoryInterface
     */
    protected $contratoRepository;

    /**
     * @var ContratoDepartamentoRepositoryInterface
     */
    protected $contractDepartmentRepository;

    /**
     * ContratoServices Constructor
     *
     * @param ContratoRepositoryInterface $contratoRepository
     * @param ContratoDepartamentoRepositoryInterface $contractDepartmentRepository
     */
    public function __construct(
        ContratoRepositoryInterface $contratoRepository,
        ContratoDepartamentoRepositoryInterface $contractDepartmentRepository
    ) {
        $this->contratoRepository = $contratoRepository;
        $this->contractDepartmentRepository = $contractDepartmentRepository;
    }

    /**
     * Retorna todos os contratos com suas respectivas relações
     *
     * @return array
     */
    public function getAll(): array
    {
        return $this->contratoRepository->getAllWithFornecedorAndDepartamentos();
    }

    /**
     * Armazena um novo contrato e suas relações com departamentos no banco de dados.
     *
     * @param  array  $contratoPayload
     * @return bool
     * @throws ContratoException
     */
    public function store(array $contratoPayload): bool
    {
        try {
            DB::beginTransaction();

                $departamentos = Arr::get($contratoPayload, self::FIELD_DEPARTAMENTOS);
                $contratoPayload = Arr::except($contratoPayload, [self::FIELD_DEPARTAMENTOS]);

                $contratoSalvo = $this->contratoRepository->store($contratoPayload);

                foreach ($departamentos as $departamentoId) {

                    $data = [
                            self::FIELD_ID_CONTRATO => $contratoSalvo->id,
                            self::FIELD_ID_DEPARTAMENTO => $departamentoId
                    ];

                    $this->contractDepartmentRepository->store($data);
                }

            DB::commit();

            return true;

        } catch (Exception $exception) {
            DB::rollBack();

            Log::error('Falha ao tentar salvar contrato ' . self::class, [
                'exception' => $exception,
                'payload'=> $contratoPayload
            ]);

            throw new ContratoException("Não foi possível salvar o contrato");
        }
    }

    /**
     * Usada para filtar os contratos a serem exibidos
     *
     * @param array $dataFilter
     * @return array|null
     */
    public function filter(array $dataFilter): ?array
    {
        $contratosFiltrados = $this->contratoRepository->search($dataFilter);

        return $contratosFiltrados;
    }
}
