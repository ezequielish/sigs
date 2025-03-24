<?php
namespace Tests\Feature;

use App\Models\CategoriaModel;
use App\Models\ProductoModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductoRoutesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        CategoriaModel::factory()->create(['id' => 1, 'nombre' => 'Test Cat']);
        ProductoModel::factory()->create(['id' => 1, 'nombre' => 'Test Pro', 'categoria_id' => 1, 'precio' => 10, 'stock' => 10, 'descripcion' => 'test']);

    }

    public function testIndexRoute(): void
    {
        $response = $this->get('/api/producto');
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'error',
            'data' => [
                '*' => [
                    'id',
                    'nombre',
                    'categoria' => [
                        'id',
                        'nombre',
                    ],
                ],
            ],
        ]);
    }

    public function testShowRoute(): void
    {
        $response = $this->get('/api/producto/1'); // Cambiado a /api/producto/1

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'error',
            'data' => [
                'id',
                'nombre',
                'categoria' => [
                    'id',
                    'nombre',
                ],
            ],
        ]);

        $response404 = $this->get('/api/producto/2'); // Cambiado a /api/producto/2
        $response404->assertStatus(404);
    }

    public function testUpdateRoute(): void
    {
        $response                   = $this->putJson('/api/producto/1', [ // Cambiado a /api/producto/1
            'nombre'       => 'Producto act',
            'categoria_id' => 1,
            'precio'       => '30.00',
            'stock'        => 30,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('productos', ['nombre' => 'Producto act']);
    }

    public function testDestroyRoute(): void
    {

        $response = $this->deleteJson('/api/producto/1'); // Cambiado a /api/producto/1
        $response->assertStatus(200);
        $this->assertDatabaseMissing('productos', ['id' => 1]);

        $response404 = $this->deleteJson('/api/producto/2'); // Cambiado a /api/producto/2
        $response404->assertStatus(404);
    }

    public function testIndexWithFiltersRoute(): void
    {
        $response = $this->get('/api/producto?nombre=Test&categoria_id=1&precio_min=5&precio_max=15'); // Cambiado a /api/producto

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'error',
            'data' => [
                '*' => [
                    'id',
                    'nombre',
                    'categoria' => [
                        'id',
                        'nombre',
                    ],
                ],
            ],
        ]);
    }

    public function testStoreRoute(): void
    {
        ProductoModel::truncate();
        $response = $this->postJson('/api/producto', [ // Cambiado a /api/producto
            'id'           => 33,
            'nombre'       => 'Nuevo nuevo',
            'categoria_id' => 1,
            'precio'       => '20.00',
            'stock'        => 20,
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('productos', ['nombre' => 'Nuevo nuevo']);
    }

}
