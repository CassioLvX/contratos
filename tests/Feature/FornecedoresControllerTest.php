<?php

namespace Tests\Feature;

use App\Http\Services\FornecedoresServices;
use App\Models\Supplier;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\TestCase;

class FornecedoresControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var array
     */
    private const SUPPLIER_DATA = [
        'name' => 'Suco Amargamente Doce',
        'description' => 'Vou fingir que pensei em algo pra por aqui.',
        'address' => 'Rua Principal, 123',
        'phone' => '(11) 1234-5678',
        'email' => 'vendas@example.com',
    ];

    /**
     * @var string
     */
    private const ROUTE_URI = '/suppliers';

    /**
     * @var string
     */
    private const NAME_FIELD = 'name';

    /**
     * @var string
     */
    private const DESCRIPTION_FIELD = 'description';

    /**
     * @var string
     */
    private const ADDRESS_FIELD = 'address';

    /**
     * @var string
     */
    private const PHONE_FIELD = 'phone';

    /**
     * @var string
     */
    private const EMAIL_FIELD = 'email';

    /**
     * @var string
     */
    private const DATABASE_TABLE = 'supplier';

    /**
     * Verifica se a rota retorna todos os fornecedores cadastrados
     *
     * @test
     * @return void
     */
    public function should_get_all_suppliers()
    {
        // Arrange
        Supplier::factory(2)->create();

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
        $contratoServicesMock = $this->mock(FornecedoresServices::class);
        $contratoServicesMock->shouldReceive('getAll')
            ->andThrow(new Exception('Test Exception'));

        // Act
        $response = $this->get(self::ROUTE_URI);

        // Assert
        $response->assertStatus(500);
        $response->assertJson(['Error ao retornar fornecedor: Servidor']);
    }

    /**
     * Verifica se consegue salvar um novo fornecedor no banco de dados
     *
     * @test
     * @return void
     */
    public function test_should_save_supplier_on_db()
    {
        // Act
        $response = $this->post(self::ROUTE_URI, self::SUPPLIER_DATA);

        // Assert
        $response->assertStatus(201);
        $this->assertDatabaseHas(self::DATABASE_TABLE, self::SUPPLIER_DATA);
    }

    /**
     * Verifica se a ao estourar uma exception enquanto tenta salvar um novo fornecedor,
     * ela é capturada e tratadas antes de retornar ao usuário
     *
     * @test
     * @expectedException \Exception
     * @return void
     */
    public function test_should_returns_internal_server_error_on_exception_at_save()
    {
        // Arrange
        $contratoServicesMock = $this->mock(FornecedoresServices::class);
        $contratoServicesMock->shouldReceive('store')
            ->andThrow(new Exception('Test Exception'));

        // Assert
        $response = $this->post(self::ROUTE_URI, self::SUPPLIER_DATA);

        // Act
        $response->assertStatus(500);
        $response->assertJson(['Error ao salvar fornecedor: Servidor']);
    }

    /**
     * Verifica se falha ao salvar um novo fornecedor com campo Name vazio
     *
     * @test
     * @return void
     */
    public function test_should_not_save_by_field_name_is_null()
    {
        // Arrange
        $data = Arr::except(self::SUPPLIER_DATA, self::NAME_FIELD);

        // Act
        $response = $this->post(self::ROUTE_URI, $data);

        // Assert
        $response->assertStatus(302);
        $response->assertSessionHas('errors', function ($errors) {
            return $errors->first(self::NAME_FIELD) === 'O campo Nome é obrigatório.';
        });
        $this->assertDatabaseMissing(self::DATABASE_TABLE, $data);
    }

    /**
     * Verifica se falha ao salvar um novo fornecedor com campo Description vazio
     *
     * @test
     * @return void
     */
    public function test_should_not_save_by_field_description_is_null()
    {
        // Arrange
        $data = Arr::except(self::SUPPLIER_DATA, self::DESCRIPTION_FIELD);

        // Act
        $response = $this->post(self::ROUTE_URI, $data);

        // Assert
        $response->assertStatus(302);
        $response->assertSessionHas('errors', function ($errors) {
            return $errors->first(self::DESCRIPTION_FIELD) === 'O campo Descrição é obrigatório.';
        });
        $this->assertDatabaseMissing(self::DATABASE_TABLE, $data);
    }


    /**
     * Verifica se falha ao salvar um novo fornecedor com campo Address vazio
     *
     * @test
     * @return void
     */
    public function test_should_not_save_by_field_address_is_null()
    {
        // Arrange
        $data = Arr::except(self::SUPPLIER_DATA, self::ADDRESS_FIELD);

        // Act
        $response = $this->post(self::ROUTE_URI, $data);

        // Assert
        $response->assertStatus(302);
        $response->assertSessionHas('errors', function ($errors) {
            return $errors->first(self::ADDRESS_FIELD) === 'O campo Endereço é obrigatório.';
        });
        $this->assertDatabaseMissing(self::DATABASE_TABLE, $data);
    }

    /**
     * Verifica se falha ao salvar um novo fornecedor com campo Phone vazio
     *
     * @test
     * @return void
     */
    public function test_should_not_save_by_field_phone_is_null()
    {
        // Arrange
        $data = Arr::except(self::SUPPLIER_DATA, self::PHONE_FIELD);

        // Act
        $response = $this->post(self::ROUTE_URI, $data);

        // Assert
        $response->assertStatus(302);
        $response->assertSessionHas('errors', function ($errors) {
            return $errors->first(self::PHONE_FIELD) === 'O campo Telefone é obrigatório.';
        });
        $this->assertDatabaseMissing(self::DATABASE_TABLE, $data);
    }

    /**
     * Verifica se falha ao salvar um novo fornecedor com campo Email vazio
     *
     * @test
     * @return void
     */
    public function test_should_not_save_by_field_email_is_null()
    {
        // Arrange
        $data = Arr::except(self::SUPPLIER_DATA, self::EMAIL_FIELD);

        // Act
        $response = $this->post(self::ROUTE_URI, $data);

        // Assert
        $response->assertStatus(302);
        $response->assertSessionHas('errors', function ($errors) {
            return $errors->first(self::EMAIL_FIELD) === 'O campo E-mail é obrigatório.';
        });
        $this->assertDatabaseMissing(self::DATABASE_TABLE, $data);
    }
}
