<?php

namespace App\Http\Controllers;

use App\Exceptions\DepartamentoException;
use App\Http\Requests\DepartamentoRequest;
use App\Http\Services\Interfaces\DepartamentoServicesInterface;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class DepartamentosController extends Controller
{
    /**
     * @var DepartamentoServicesInterface
     */
    protected $departamentoServices;

    /**
     * DepartamentosController Constructor
     *
     * @param DepartamentoServicesInterface $departamentoServices
     */
    public function __construct(
        DepartamentoServicesInterface $departamentoServices
    ) {
        $this->departamentoServices = $departamentoServices;
    }

    /**
     * Retorna todos os departamentos cadastrados usando uma service
     *
     * @return void
     */
    public function getAll(){
        try {
            Log::info('Todos os departamentos foram requisitados');

            $data = $this->departamentoServices->getAll();

            Log::info('Todos os departamentos foram retornados com Sucesso');
            return response()->json($data,  Response::HTTP_OK );
        } catch (QueryException $exception) {
            Log::error('Falha ao tentar pegar contrato: Banco de dados ' . self::class, [
                'exception' => $exception
            ]);

            return response()->json(['Error ao retornar departamentos: Banco de dados'], Response::HTTP_INTERNAL_SERVER_ERROR);

        } catch (Exception $exception) {
            Log::error('Falha ao tentar pegar Departamentos: Servidor ' . self::class, [
                'exception' => $exception
            ]);

            return response()->json(['Error ao retornar departamentos: Servidor'], Response::HTTP_INTERNAL_SERVER_ERROR);

        }

    }

    /**
     * Usa Service para salvar um novo departamento no banco de dados
     *
     * @param DepartamentoRequest $request
     * @return void
     */
    public function store(DepartamentoRequest $request){
        try {
            Log::info('Iniciando processo para salvar novo departamento');

            $valitedData = $request->validated();

            if (!$valitedData) {
                throw new Exception('Dados inválidos');
            }

            $data = $this->departamentoServices->store($valitedData);

            Log::info('Departamento salvo com sucesso');

            return response()->json($data,  Response::HTTP_CREATED );

        } catch (QueryException $exception) {
            Log::error('Falha ao tentar salvar departamentos: Banco de dados ' . self::class, [
                'exception' => $exception,
                'payload'=> $request
            ]);

            return response()->json(['Error ao salvar departamentos: Banco de dados'], Response::HTTP_INTERNAL_SERVER_ERROR);

        } catch (DepartamentoException $exception) {
            Log::error('Falha ao tentar salvar departamentos: Serviço ' . self::class, [
                'exception' => $exception,
                'payload'=> $request
            ]);

            return response()->json(['Error ao salvar departamentos: Serviço'], Response::HTTP_INTERNAL_SERVER_ERROR);

        } catch (Exception $exception) {
            Log::error('Falha ao tentar salvar departamentos: Servidor ' . self::class, [
                'exception' => $exception,
                'payload'=> $request
            ]);

            return response()->json(['Error ao salvar departamentos: Servidor'], Response::HTTP_INTERNAL_SERVER_ERROR);

        }

    }

}
