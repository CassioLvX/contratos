<?php

namespace Tests\Feature;

use App\Http\Services\ContratoServices;
use App\Models\ContractDepartment;
use App\Models\Department;
use App\Models\Supplier;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class CadastroContratoControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @var array
     */
    private const CONTRACT_DATA = [
        'description' => 'Alguma coisa legal loren',
        'type' => 'Venda',
        'value' => 1500.00,
        'start_on' => '2023-12-27',
        'finish_on' => '2028-12-27',
        'departments' => [1,2,3],
        'supplier_id' => 2,
    ];

    /**
     * @var string
     */
    private const ROUTE_URI = '/contracts';

    /**
     * @var string
     */
    private const SUPPLIER_ID_FIELD = 'supplier_id';

    /**
     * @var string
     */
    private const DEPARTMENTS_FIELD = 'departments';

    /**
     * @var string
     */
    private const DESCRIPTION_FIELD = 'description';

    /**
     * @var string
     */
    private const TYPE_FIELD = 'type';

    /**
     * @var string
     */
    private const VALUE_FIELD = 'value';

    /**
     * @var string
     */
    private const START_ON_FIELD = 'start_on';

    /**
     * @var string
     */
    private const FINISH_ON_FIELD = 'finish_on';

    /**
     * Verifica se a rota retorna todos os contratos cadastrados
     *
     * @test
     * @return void
     */
    public function test_should_receive_all_contracts()
    {
        // Arrange
        ContractDepartment::factory(2)->create();

        // Act
        $response = $this->getJson(self::ROUTE_URI);

        // Assert
        $response->assertStatus(200);

    }

    /**
     * Verifica se a ao estourar uma exception, ela é capturada e tratadas
     * antes de retornar ao usuário
     *
     * @test
     * @expectedException \Exception
     * @return void
     */
    public function test_should_returns_internal_server_error_on_exception()
    {
        // Arrange
        $contratoServicesMock = $this->mock(ContratoServices::class);

        $contratoServicesMock->shouldReceive('getAll')
            ->andThrow(new Exception('Test Exception'));

        // Act
        $response = $this->get(self::ROUTE_URI);

        // Assert
        $response->assertStatus(500);
        $response->assertJson(['Error ao retornar contratos: Servidor']);
    }

    /**
     * Verifica se a rota salva um novo contrato
     *
     * @test
     * @return void
     */
    public function test_should_save_a_new_contract_on_db()
    {
        // Arrange
        $contractData = Arr::except(self::CONTRACT_DATA, [self::SUPPLIER_ID_FIELD, self::DEPARTMENTS_FIELD]);

        $departamentos = Department::factory(3)->create();
        $fornecedor = Supplier::factory(1)->create()->toArray()[0];

        $contractData[self::DEPARTMENTS_FIELD] = $departamentos->pluck('id')->toArray();
        $contractData[self::SUPPLIER_ID_FIELD] = $fornecedor['id'];

        // Act
        $response = $this->post(self::ROUTE_URI, $contractData);

        // Assert
        $response->assertStatus(201);
    }

    /**
     * Verifica se a ao estourar uma exception ao tentar salvar um contrato
     * ela é capturada e tratadas antes de retornar ao usuário
     *
     * @test
     * @expectedException \Exception
     * @return void
     */
    public function test_should_returns_internal_server_error_on_exception_at_save_new_contract()
    {
        // Arrange
        $contratoServicesMock = $this->mock(ContratoServices::class);
        $contratoServicesMock->shouldReceive('store')
            ->andThrow(new Exception('Test Exception'));

        $departamentos = Department::factory(3)->create();
        $fornecedor = Supplier::factory(1)->create()->toArray()[0];

        $contractData = self::CONTRACT_DATA;

        $contractData[self::DEPARTMENTS_FIELD] = $departamentos->pluck('id')->toArray();
        $contractData[self::SUPPLIER_ID_FIELD] = $fornecedor['id'];

        // Act
        $response = $this->post(self::ROUTE_URI, $contractData);

        // Assert
        $response->assertStatus(500)->assertJson(['Error ao salvar contrato: Servidor']);
    }

    /**
     * Verifica se a rota não salva um contrato faltando ID do Fornecedor
     *
     * @test
     * @return void
     */
    public function test_should_dont_save_by_supplier_id_be_null()
    {
        // Arrange
        $contractData = Arr::except(self::CONTRACT_DATA, [self::SUPPLIER_ID_FIELD]);

        // Act
        $response = $this->post(self::ROUTE_URI, $contractData);

        // Assert
        $response->assertStatus(302);
        $response->assertSessionHas('errors', function ($errors) {
            return $errors->first(self::SUPPLIER_ID_FIELD) === 'O campo fornecedor é obrigatório.';
        });
    }

    /**
     * Verifica se a rota não salva um contrato faltando informações dos Departamentos
     *
     * @test
     * @return void
     */
    public function test_should_dont_save_by_departments_data_be_null()
    {
        // Arrange
        $contractData = Arr::except(self::CONTRACT_DATA, [self::DEPARTMENTS_FIELD]);

        // Act
        $response = $this->post(self::ROUTE_URI, $contractData);

        // Assert
        $response->assertStatus(302);
        $response->assertSessionHas('errors', function ($errors) {
            return $errors->first(self::DEPARTMENTS_FIELD) === 'O campo departamentos é obrigatório.';
        });
    }

    /**
     * Verifica se a rota não salva um contrato faltando dados do campo Descrição
     *
     * @test
     * @return void
     */
    public function test_should_dont_save_by_description_data_be_null()
    {
        // Arrange
        $contractData = Arr::except(self::CONTRACT_DATA, [self::DESCRIPTION_FIELD]);

        // Act
        $response = $this->post(self::ROUTE_URI, $contractData);

        // Assert
        $response->assertStatus(302);
        $response->assertSessionHas('errors', function ($errors) {
            return $errors->first(self::DESCRIPTION_FIELD) === 'O campo descrição é obrigatório.';
        });
    }

    /**
     * Verifica se a rota não salva um contrato faltando dados do campo Tipo
     *
     * @test
     * @return void
     */
    public function test_should_dont_save_by_type_data_be_null()
    {
        // Arrange
        $contractData = Arr::except(self::CONTRACT_DATA, [self::TYPE_FIELD]);

        // Act
        $response = $this->post(self::ROUTE_URI, $contractData);

        // Assert
        $response->assertStatus(302);
        $response->assertSessionHas('errors', function ($errors) {
            return $errors->first(self::TYPE_FIELD) === 'O campo tipo de contrato é obrigatório.';
        });
    }

    /**
     * Verifica se a rota não salva um contrato faltando dados do campo Valor
     *
     * @test
     * @return void
     */
    public function test_should_dont_save_by_value_data_be_null()
    {
        // Arrange
        $contractData = Arr::except(self::CONTRACT_DATA, [self::VALUE_FIELD]);

        // Act
        $response = $this->post(self::ROUTE_URI, $contractData);

        // Assert
        $response->assertStatus(302);
        $response->assertSessionHas('errors', function ($errors) {
            return $errors->first(self::VALUE_FIELD) === 'O campo valor é obrigatório.';
        });
    }

    /**
     * Verifica se a rota não salva um contrato faltando dados do campo Data de Início
     *
     * @test
     * @return void
     */
    public function test_should_dont_save_by_start_on_date_be_null()
    {
        // Arrange
        $contractData = Arr::except(self::CONTRACT_DATA, [self::START_ON_FIELD]);

        // Act
        $response = $this->post(self::ROUTE_URI, $contractData);

        // Assert
        $response->assertStatus(302);
        $response->assertSessionHas('errors', function ($errors) {
            return $errors->first(self::START_ON_FIELD) === 'O campo início é obrigatório.';
        });
    }

    /**
     * Verifica se a rota não salva um contrato faltando dados do campo Data de Término
     *
     * @test
     * @return void
     */
    public function test_should_dont_save_by_finish_on_date_be_null()
    {
        // Arrange
        $contractData = Arr::except(self::CONTRACT_DATA, [self::FINISH_ON_FIELD]);

        // Act
        $response = $this->post(self::ROUTE_URI, $contractData);

        // Assert
        $response->assertStatus(302);
        $response->assertSessionHas('errors', function ($errors) {
            return $errors->first(self::FINISH_ON_FIELD) === 'O campo término é obrigatório.';
        });
    }

}
