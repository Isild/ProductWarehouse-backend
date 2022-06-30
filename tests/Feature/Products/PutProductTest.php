<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\ProductModel;
use Illuminate\Support\Str;

class PutProductTest extends TestCase
{
    private User $user;

    private string $token;

    private $startData = [
        'name' => 'name',
        'description' => 'description',
        'salary' => [
            10,
            12,
            14,
        ]
    ];

    private $validData = [
        'name' => 'nameU',
        'description' => 'descriptionU',
        'salary' => [
            11,
            13,
            15,
        ]
    ];

    public function setUp() : void
    {
        parent::setUp();

        $data = $this->generateAuthenticateUser();

        $this->user = $data['user'];
        $this->token = $data['token'];
    }

    public function test_put_product() : void
    {
        $product = ProductModel::factory()->create($this->startData);

        $response = $this->actingAs($this->user, 'api')
                    ->putJson(route('products.put', [$product]), $this->validData);

        $response->assertStatus(204);
        $this->assertDatabaseHas('products', $this->validData);
        $this->assertDatabaseMissing('products', $this->startData);
    }

    public function test_put_product_not_found() : void
    {
        $response = $this->actingAs($this->user, 'api')
                    ->putJson(route('products.put', [-1]), $this->validData);

        $response->assertStatus(404);
    }

    /**
     * @dataProvider invalidDataProvider
     */
    public function test_post_product_invalid_data(array $invalidData, $fieldToCheck) : void
    {
        $product = ProductModel::factory()->create($this->startData);

        $response = $this->actingAs($this->user, 'api')
                    ->putJson(route('products.put', [$product]), $invalidData);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors($fieldToCheck);
    }

    public function invalidDataProvider(): array
    {
        return [
            [['name' => 1], 'name'],
            [['name' => true], 'name'],
            [['name' => null], 'name'],
            [['name' => []], 'name'],
            [['name' => 'a'], 'name'],
            [['name' => 'a' . Str::random(255) ], 'name'],

            [['description' => 1], 'description'],
            [['description' => true], 'description'],
            [['description' => null], 'description'],
            [['description' => []], 'description'],
            [['description' => 'a'], 'description'],
            [['description' => 'a' . Str::random(2048) ], 'description'],

            [['salary' => 1], 'salary'],
            [['salary' => true], 'salary'],
            [['salary' => null], 'salary'],
            [['salary' => 'a'], 'salary'],
            [['salary' => ['a'] ], 'salary.0'],
            [['salary' => [true] ], 'salary.0'],
            [['salary' => [null] ], 'salary.0'],
        ];
    }

}
