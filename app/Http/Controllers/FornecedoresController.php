<?php

namespace App\Http\Controllers;

use App\Http\Requests\FornecedorRequest;
use App\Http\Services\Interfaces\FornecedoresServicesInterface;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Exceptions\FornecedorException;
use Illuminate\Database\QueryException;
use Exception;

class FornecedoresController extends Controller
{
    /**
     * @var FornecedoresServicesInterface
     */
    protected $FornecedoresServices;

    /**
     * FornecedoresController Constructor
     *
     * @param FornecedoresServicesInterface $FornecedoresServices
     */
    public function __construct(
        FornecedoresServicesInterface $FornecedoresServices
    ) {
        $this->FornecedoresServices = $FornecedoresServices;
    }

    /**
     *  Retorna todos os fornecedores cadastrados usando uma service
     *
     * @return void
     */
    public function getAll()
    {
        try {
            Log::info('Todos os fornecedores foram requisitados');

            $data = $this->FornecedoresServices->getAll();

            Log::info('Todos os fornecedores foram retornados com Sucesso');
            return response()->json($data,  Response::HTTP_OK );
        } catch (Exception $exception) {
            Log::error('Falha ao tentar pegar fornecedor: Servidor ' . self::class, [
                'exception' => $exception
            ]);

            return response()->json(['Error ao retornar fornecedor: Servidor'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * Usa Service para salvar um novo fornecedor no banco de dados
     *
     * @param FornecedorRequest $request
     * @return void
     */
    public function store(FornecedorRequest $request)
    {
        try {
            Log::info('Iniciando processo para salvar novo fornecedor');

            $valitedData = $request->validated();

            if (!$valitedData) {
                throw new Exception('Dados inválidos');
            }
            log::info('data', $valitedData);
            $data = $this->FornecedoresServices->store($valitedData);

            Log::info('Fornecedor salvo com sucesso');

            return response()->json($data,  Response::HTTP_CREATED );
        } catch (QueryException $exception) {
            Log::error('Falha ao tentar salvar fornecedor: Banco de dados ' . self::class, [
                'exception' => $exception,
                'payload'=> $request
            ]);

            return response()->json(['Error ao salvar fornecedor: Banco de dados'], Response::HTTP_INTERNAL_SERVER_ERROR);

        } catch (FornecedorException $exception) {
            Log::error('Falha ao tentar salvar fornecedor: Serviço ' . self::class, [
                'exception' => $exception,
                'payload'=> $request
            ]);

            return response()->json(['Error ao salvar fornecedor: Serviço'], Response::HTTP_INTERNAL_SERVER_ERROR);

        } catch (Exception $exception) {
            Log::error('Falha ao tentar salvar fornecedor: Servidor ' . self::class, [
                'exception' => $exception,
                'payload'=> $request
            ]);

            return response()->json(['Error ao salvar fornecedor: Servidor'], Response::HTTP_INTERNAL_SERVER_ERROR);

        }

    }

}
