<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContratoRequest;
use App\Http\Requests\FilterRequest;
use App\Http\Services\Interfaces\ContratoServicesInterface;
use Exception;
use App\Exceptions\ContratoException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CadastroContratoController extends Controller
{
    /**
     * @var ContratoServicesInterface
     */
    protected $contratoServices;

    /**
     * CadastroContratoController Constructor
     *
     * @param ContratoServicesInterface $contratoServices
     */
    public function __construct(
        ContratoServicesInterface $contratoServices
    ) {
        $this->contratoServices = $contratoServices;
    }

    /**
     * Retorna todos os contratos cadastrados usando uma service
     *
     * @return void
     */
    public function getAll(){
        try {
            Log::info('Todos os contratos foram requisitados');

            $data = $this->contratoServices->getAll();

            Log::info('Todos os contratos foram retornados com Sucesso');

            return response()->json($data, Response::HTTP_OK );
        } catch (Exception $exception) {
            Log::error('Falha ao tentar pegar todos os ' . self::class, [
                'exception' => $exception,
            ]);

            return response()->json(['Error ao retornar contratos: Servidor'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    /**
     * Usa Service para salvar um novo Contrato no banco de dados
     *
     * @param ContratoRequest $request
     * @return void
     */
    public function store(ContratoRequest $request)
    {
        try {
            Log::info('Iniciando processo para salvar novo Contrato');

            $valitedData = $request->validated();

            if (!$valitedData) {
                throw new Exception('Dados inválidos');
            }

            $data = $this->contratoServices->store($valitedData);

            Log::info('Contrato salvo com sucesso');

            return response()->json($data, Response::HTTP_CREATED );
        } catch (QueryException $exception) {
            Log::error('Falha ao tentar salvar contrato: Banco de dados ' . self::class, [
                'exception' => $exception,
                'payload'=> $request
            ]);

            return response()->json(['Error ao salvar contrato: Banco de dados'], Response::HTTP_INTERNAL_SERVER_ERROR );

        } catch (ContratoException $exception) {
            Log::error('Falha ao tentar salvar contrato: Serviço ' . self::class, [
                'exception' => $exception,
                'payload'=> $request
            ]);

            return response()->json(['Error ao salvar contrato: Serviço'], Response::HTTP_INTERNAL_SERVER_ERROR );

        } catch (Exception $exception) {
            Log::error('Falha ao tentar salvar contrato: Servidor ' . self::class, [
                'exception' => $exception,
                'payload'=> $request
            ]);

            return response()->json(['Error ao salvar contrato: Servidor'], Response::HTTP_INTERNAL_SERVER_ERROR );

        }

    }

    /**
     * Retorna todos os contratos cadastrados baseados no filtro
     *
     * @param FilterRequest $request
     * @return void
     */
    public function filter(FilterRequest $request)
    {
        try {
            Log::info('Contratos foram requisitados pelos filtros');

            $valitedData = $request->validated();

            if (!$valitedData) {
                throw new Exception('Dados inválidos');
            }

            $data = $this->contratoServices->filter($valitedData);

            Log::info('Todos os contratos filtrados foram retornados com Sucesso');

            return response()->json($data, Response::HTTP_OK );
        } catch (Exception $exception) {
            Log::error('Falha ao tentar filtrar contratos: Servidor ' . self::class, [
                'exception' => $exception,
                'payload'=> $request
            ]);

            return response()->json(['Error ao filtrar contratos: Servidor'], Response::HTTP_INTERNAL_SERVER_ERROR );

        }

    }

}
