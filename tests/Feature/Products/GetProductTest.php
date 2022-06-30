<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\ProductModel;
use Illuminate\Support\Str;

class GetProductTest extends TestCase
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

    public function test_get_product() : void
    {
        $product = ProductModel::factory()->create();

        $response = $this->getJson(route('products.get.single', [$product]));

        $response->assertStatus(200)
                    ->assertJson($product->toArray());
    }

    public function test_get_product_not_found() : void
    {
        $response = $this->actingAs($this->user, 'api')
                    ->putJson(route('products.get.single', [-1]));

        $response->assertStatus(404);
    }

    public function test_get_products() : void
    {
        $product = ProductModel::factory()->count(10)->create();

        $response = $this->getJson(route('products.get'));

        $response->assertStatus(200);

        $responseData = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('next_page_url', $responseData);
        $this->assertArrayHasKey('path', $responseData);
        $this->assertArrayHasKey('per_page', $responseData);
        $this->assertArrayHasKey('prev_page_url', $responseData);
        $this->assertArrayHasKey('to', $responseData);
        $this->assertArrayHasKey('total', $responseData);
        $this->assertArrayHasKey('current_page', $responseData);
        $this->assertArrayHasKey('data', $responseData);

        $this->assertEquals(10, count($responseData['data']));
        foreach ($responseData['data'] as $product) {
            $this->assertArrayHasKey('name', $product);
            $this->assertArrayHasKey('description', $product);
            $this->assertArrayHasKey('salary', $product);
        }
    }

    /**
     * @dataProvider invalidDataProvider
     */
    public function test_get_products_invalid_data(array $invalidData, $fieldToCheck) : void
    {
        $response = $this->getJson(route('products.get', $invalidData));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors($fieldToCheck);
    }

    public function invalidDataProvider(): array
    {
        return [
            [['limit' => "a"], 'limit'],
            [['limit' => -1], 'limit'],
            [['limit' => 51], 'limit'],

            [['page' => "a"], 'page'],
            [['page' => -1], 'page'],

            [['sort_by' => "string"], 'sort_by'],

            [['order_by' => "string"], 'order_by'],

            [['search' => "a"], 'search'],
            [['search' => "a" . Str::random(2048)], 'search'],
        ];
    }
}
