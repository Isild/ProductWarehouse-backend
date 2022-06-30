<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\ProductModel;
use Illuminate\Support\Str;

class PostProductTest extends TestCase
{
    private User $user;

    private string $token;

    private $validData = [
        'name' => 'name',
        'description' => 'description',
        'salary' => [
            10,
            12,
            14,
        ]
    ];

    public function setUp() : void
    {
        parent::setUp();

        $data = $this->generateAuthenticateUser();

        $this->user = $data['user'];
        $this->token = $data['token'];
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_post_product() : void
    {
        $response = $this->actingAs($this->user, 'api')
                    ->postJson(route('products.post'), $this->validData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('products', $this->validData);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_post_product_no_payload() : void
    {
        $response = $this->actingAs($this->user, 'api')
                    ->postJson(route('products.post'), []);

        $response->assertStatus(422);
    }

    /**
     * @dataProvider invalidDataProvider
     */
    public function test_post_product_invalid_data(array $invalidData, $fieldToCheck) : void
    {
        $response = $this->actingAs($this->user, 'api')
                    ->postJson(route('products.post'), $invalidData);

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
