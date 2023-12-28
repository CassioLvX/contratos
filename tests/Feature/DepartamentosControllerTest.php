<?php

namespace Tests\Feature;

use App\Http\Services\DepartamentoServices;
use App\Models\Department;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Tests\TestCase;

class DepartamentosControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var array
     */
    private const DEPARTAMENTO_DATA = [
        'name' => 'Departamento Teste',
        'description' => 'Descrição do Departamento Teste',
    ];

    /**
     * @var string
     */
    private const ROUTE_URI = '/departments';

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
    private const DATABASE_TABLE = 'department';

    /** @test */
    public function it_can_get_all_contratos()
    {
        // Arrange
        Department::factory(2)->create();

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
    public function test_it_returns_internal_server_error_on_exception()
    {
        // Arrange
        $contratoServicesMock = $this->mock(DepartamentoServices::class);
        $contratoServicesMock->shouldReceive('getAll')
            ->andThrow(new Exception('Test Exception'));

        // Act
        $response = $this->get(self::ROUTE_URI);

        // Assert
        $response->assertStatus(500);
        $response->assertJson(['Error ao retornar departamentos: Servidor']);
    }

    public function test_should_save_departamentos_on_db()
    {
        // Act
        $response = $this->post(self::ROUTE_URI, self::DEPARTAMENTO_DATA);

        // Assert
        $response->assertStatus(201);
        $this->assertDatabaseHas(self::DATABASE_TABLE, self::DEPARTAMENTO_DATA);
    }

    /**
     * Verifica se a ao estourar uma exception, ela é capturada e tratadas
     * antes de retornar ao usuário
     *
     * @test
     * @expectedException \Exception
     * @return void
     */
    public function test_it_returns_internal_server_error_on_exception_at_save()
    {
        // Arrange
        $contratoServicesMock = $this->mock(DepartamentoServices::class);
        $contratoServicesMock->shouldReceive('store')
            ->andThrow(new Exception('Test Exception'));

        // Act
        $response = $this->post(self::ROUTE_URI, self::DEPARTAMENTO_DATA);

        // Assert
        $response->assertStatus(500);
        $response->assertJson(['Error ao salvar departamentos: Servidor']);
    }

    /**
     * Verifica se falha ao salvar um novo departamento com campo Name vazio
     *
     * @test
     * @return void
     */
    public function test_should_not_save_by_field_name_is_null()
    {
        // Arrange
        $data = Arr::except(self::DEPARTAMENTO_DATA, self::NAME_FIELD);

        // Act
        $response = $this->post(self::ROUTE_URI, $data);

        // Assert
        $response->assertStatus(302);
        $response->assertSessionHas('errors', function ($errors) {
            return $errors->first(self::NAME_FIELD) === 'O campo nome é obrigatório.';
        });
        $this->assertDatabaseMissing(self::DATABASE_TABLE, $data);
    }

    /**
     * Verifica se falha ao salvar um novo departamento com campo Description vazio
     *
     * @test
     * @return void
     */
    public function test_should_not_save_by_field_description_is_null()
    {
        // Arrange
        $data = Arr::except(self::DEPARTAMENTO_DATA, self::DESCRIPTION_FIELD);

        // Act
        $response = $this->post(self::ROUTE_URI, $data);

        // Assert
        $response->assertStatus(302);
        $response->assertSessionHas('errors', function ($errors) {
            return $errors->first(self::DESCRIPTION_FIELD) === 'O campo descrição é obrigatório.';
        });
        $this->assertDatabaseMissing(self::DATABASE_TABLE, $data);
    }
}
