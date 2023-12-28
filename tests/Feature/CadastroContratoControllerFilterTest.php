<?php

namespace Tests\Feature;

use App\Http\Services\ContratoServices;
use App\Models\Contract;
use App\Models\Supplier;
use App\Models\ContractDepartment;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CadastroContratoControllerFilterTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @var array
     */
    private const DATA_FILTER = [
        'type' => 'assumenda',
        'supplier' => 'Will',
        'start_on' => '2002-05-07',
        'finish_on' => '2028-12-27',
    ];

    /**
     * @var string
     */
    private const ROUTE_URI = '/contracts';

    /**
     * @var string
     */
    const FIELD_ONE = "type";

    /**
     * @var string
     */
    const FIELD_TWO = "supplier";

    /**
     * @var string
     */
    const FIELD_TREE = "start_on";

    /**
     * @var string
     */
    const FIELD_FOUR = "finish_on";

    /**
     * Set up tests
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $fornecedor = Supplier::factory()->create([
            'name' => 'Will',
        ])->toArray();

        $contratoOne = Contract::factory()->create([
            'type' => 'assumenda',
            'supplier_id' => $fornecedor['id'],
            'start_on' => '2002-05-07',
            'finish_on' => '2028-12-27',
        ])->toArray();

        ContractDepartment::factory()->create([
            'contract_id' => $contratoOne['id'],
        ]);

        ContractDepartment::factory(2)->create();
    }

    /**
     * Retira os valores de determinada chave do Array permitindo que o indice retorne com valor nulo
     * permitindo que o indice retorne com valor nulo
     *
     * @param array $keys
     * @return array
     */
    private function returnNullValueKey(array $keys): array
    {
        $data = self::DATA_FILTER;
        foreach ($keys as $chave) {
            if (array_key_exists($chave, $data)) {
                $data[$chave] = null;
            }
        }

        return $data;
    }

    /**
     * Verifica se a rota retorna todos os contratos
     *
     * @test
     * @return void
     */
    public function should_get_all_contratos()
    {
        // Arrange
        $dataFilter = [
            'type' => '',
            'supplier' => '',
            'start_on' => '',
            'finish_on' => '',
        ];

        // Act
        $response = $this->put(self::ROUTE_URI, $dataFilter);

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
    public function should_cant_get_all_contracts_by_exception()
    {
        // Arrange
        $contratoServicesMock = $this->mock(ContratoServices::class);
        $contratoServicesMock->shouldReceive('filter')
            ->andThrow(new Exception('Test Exception'));

        $dataFilter = self::DATA_FILTER;

        // Act
        $response = $this->put(self::ROUTE_URI, $dataFilter);

        // Assert
        $response->assertStatus(500);
        $response->assertJson(['Error ao filtrar contratos: Servidor']);
    }

    /**
     * Verifica se a rota retorna todos os contratos filtados pelo campo Type
     *
     * @test
     * @return void
     */
    public function should_can_filter_contracts_by_type()
    {
        // Arrange
        $dataFilter = self::returnNullValueKey([self::FIELD_TWO,self::FIELD_TREE,self::FIELD_FOUR]);

        // Act
        $response = $this->put(self::ROUTE_URI, $dataFilter);

        // Assert
        $response->assertStatus(200);
    }

    /**
     * Verifica se a rota retorna todos os contratos filtados pelo campo Supplier
     *
     * @test
     * @return void
     */
    public function should_can_filter_contracts_by_supplier()
    {
        // Arrange
        $dataFilter = self::returnNullValueKey([self::FIELD_ONE,self::FIELD_TREE,self::FIELD_FOUR]);

        // Act
        $response = $this->put(self::ROUTE_URI, $dataFilter);

        // Assert
        $response->assertStatus(200);
    }

    /**
     * Verifica se a rota retorna todos os contratos filtados pelo campo Start_on
     *
     * @test
     * @return void
     */
    public function should_can_filter_contracts_by_start_date()
    {
        // Arrange
        $dataFilter = self::returnNullValueKey([self::FIELD_ONE,self::FIELD_TWO,self::FIELD_FOUR]);

        // Act
        $response = $this->put(self::ROUTE_URI, $dataFilter);

        // Assert
        $response->assertStatus(200);
    }

    /**
     * Verifica se a rota retorna todos os contratos filtados pelo campo Finish_on
     *
     * @test
     * @return void
     */
    public function should_can_filter_contracts_by_finish_date()
    {
        // Arrange
        $dataFilter = self::returnNullValueKey([self::FIELD_ONE,self::FIELD_TWO,self::FIELD_TREE]);

        // Act
        $response = $this->put(self::ROUTE_URI, $dataFilter);

        // Assert
        $response->assertStatus(200);
    }

    /**
     * Verifica se a rota retorna todos os contratos filtados pelos campos Type e Supplier
     *
     * @test
     * @return void
     */
    public function should_can_filter_contracts_by_type_and_supplier()
    {
        // Arrange
        $dataFilter = self::returnNullValueKey([self::FIELD_TREE,self::FIELD_FOUR]);

        // Act
        $response = $this->put(self::ROUTE_URI, $dataFilter);

        // Assert
        $response->assertStatus(200);
    }

    /**
     * Verifica se a rota retorna todos os contratos filtados pelos campos Type e Start_on
     *
     * @test
     * @return void
     */
    public function should_can_filter_contracts_by_type_and_start_date()
    {
        // Arrange
        $dataFilter = self::returnNullValueKey([self::FIELD_TWO,self::FIELD_FOUR]);

        // Act
        $response = $this->put(self::ROUTE_URI, $dataFilter);

        // Assert
        $response->assertStatus(200);
    }

    /**
     * Verifica se a rota retorna todos os contratos filtados pelos campos Type e Finish_on
     *
     * @test
     * @return void
     */
    public function should_can_filter_contracts_by_type_and_finish_date()
    {
        // Arrange
        $dataFilter = self::returnNullValueKey([self::FIELD_TWO,self::FIELD_TREE]);

        // Act
        $response = $this->put(self::ROUTE_URI, $dataFilter);

        // Assert
        $response->assertStatus(200);
    }

    /**
     * Verifica se a rota retorna todos os contratos filtados pelos campos Supplier e Start_on
     *
     * @test
     * @return void
     */
    public function should_can_filter_contracts_by_supplier_and_start_date()
    {
        // Arrange
        $dataFilter = self::returnNullValueKey([self::FIELD_ONE,self::FIELD_FOUR]);

        // Act
        $response = $this->put(self::ROUTE_URI, $dataFilter);

        // Assert
        $response->assertStatus(200);
    }

    /**
     * Verifica se a rota retorna todos os contratos filtados pelos campos Supplier e Finish_on
     *
     * @test
     * @return void
     */
    public function should_can_filter_contracts_by_supplier_and_finish_date()
    {
        // Arrange
        $dataFilter = self::returnNullValueKey([self::FIELD_ONE,self::FIELD_TREE]);

        // Act
        $response = $this->put(self::ROUTE_URI, $dataFilter);

        // Assert
        $response->assertStatus(200);
    }

    /**
     * Verifica se a rota retorna todos os contratos filtados pelos campos Start_on e Finish_on
     *
     * @test
     * @return void
     */
    public function should_can_filter_contracts_by_start_date_and_finish_date()
    {
        // Arrange
        $dataFilter = self::returnNullValueKey([self::FIELD_ONE,self::FIELD_TWO]);

        // Act
        $response = $this->put(self::ROUTE_URI, $dataFilter);

        // Assert
        $response->assertStatus(200);
    }

    /**
     * Verifica se a rota retorna todos os contratos filtados pelos campos Type, Supplier e Start_on
     *
     * @test
     * @return void
     */
    public function should_can_filter_contracts_by_type_and_supplier_and_start_date()
    {
        // Arrange
        $dataFilter = self::returnNullValueKey([self::FIELD_FOUR]);

        // Act
        $response = $this->put(self::ROUTE_URI, $dataFilter);

        // Assert
        $response->assertStatus(200);
    }

    /**
     * Verifica se a rota retorna todos os contratos filtados pelos campos Type, Supplier e Finish_on
     *
     * @test
     * @return void
     */
    public function should_can_filter_contracts_by_type_and_supplier_and_finish_date()
    {
        // Arrange
        $dataFilter = self::returnNullValueKey([self::FIELD_TREE]);

        // Act
        $response = $this->put(self::ROUTE_URI, $dataFilter);

        // Assert
        $response->assertStatus(200);
    }

    /**
     * Verifica se a rota retorna todos os contratos filtados pelos campos Type, Start_on e Finish_on
     *
     * @test
     * @return void
     */
    public function should_can_filter_contracts_by_type_and_start_date_and_finish_date()
    {
        // Arrange
        $dataFilter = self::returnNullValueKey([self::FIELD_TWO]);

        // Act
        $response = $this->put(self::ROUTE_URI, $dataFilter);

        // Assert
        $response->assertStatus(200);
    }

    /**
     * Verifica se a rota retorna todos os contratos filtados pelos campos Supplier, Start_on e Finish_on
     *
     * @test
     * @return void
     */
    public function should_can_filter_contracts_by_supplier_and_start_date_and_finish_date()
    {
        // Arrange
        $dataFilter = self::returnNullValueKey([self::FIELD_ONE]);

        // Act
        $response = $this->put(self::ROUTE_URI, $dataFilter);

        // Assert
        $response->assertStatus(200);
    }

    /**
     * Verifica se a rota retorna todos os contratos filtados pelos campos Type, Supplier, Start_On e Finish_on
     *
     * @test
     * @return void
     */
    public function should_can_filter_contracts_by_all_fields()
    {
        // Arrange
        $dataFilter = self::DATA_FILTER;

        // Act
        $response = $this->put(self::ROUTE_URI, $dataFilter);

        // Assert
        $response->assertStatus(200);
    }

}
