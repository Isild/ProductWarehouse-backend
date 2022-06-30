<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\ProductModel;
use Illuminate\Support\Str;

class DeleteProductTest extends TestCase
{
    private User $user;

    private string $token;

    public function setUp() : void
    {
        parent::setUp();

        $data = $this->generateAuthenticateUser();

        $this->user = $data['user'];
        $this->token = $data['token'];
    }

    /**
     * DELETE: /products/{id}
     * @return void
     */
    public function test_delete_product() : void
    {
        $product = ProductModel::factory()->create();

        $response = $this->actingAs($this->user, 'api')
                    ->deleteJson(route('products.delete', [$product]));

        $response->assertStatus(204);
        $this->assertDatabaseMissing('products', $product->toArray());
    }

    public function test_delete_product_not_found() : void
    {
        $response = $this->actingAs($this->user, 'api')
                    ->putJson(route('products.put', [-1]));

        $response->assertStatus(404);
    }
}
