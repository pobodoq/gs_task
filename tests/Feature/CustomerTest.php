<?php

namespace Tests\Feature;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A feature test to add a customer
     *
     * @return void
     */
    public function test_add_customer()
    {
        $payload = Customer::factory()->make()->toArray();

        $response = $this->post('api/customers', $payload);

        $response
            ->assertStatus(201)
            ->assertJsonStructure(
                [
                    '*' => [
                        'firstName',
                        'lastName',
                        'email',
                        'phoneNumber',
                        'street',
                        'houseNumber',
                        'postCode',
                        'city',
                        'created_at',
                        'updated_at',
                        'id'
                    ],
                ]
            );
    }
    /**
     * A feature test to show all customers
     */
    public function test_get_all_customers()
    {
        Customer::factory()->count(20)->create();

        $this->get('/api/customers')
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    'data' =>  [
                        '*' => [
                            'firstName',
                            'lastName',
                            'email',
                            'phoneNumber',
                            'street',
                            'houseNumber',
                            'postCode',
                            'city',
                            'created_at',
                            'updated_at',
                            'id'
                        ],
                    ]
                ]
            );
    }

    /**
     * A feature test to show a specific customer
     */
    public function test_get_customer(): void
    {
        Customer::factory()->create();

        $response = $this->get('/api/customers/1');

        $response->assertStatus(200);
    }

    /**
     * A feature test to show a customer that don't exist 
     */
    public function test_get_nonexistent_customer(): void
    {
        $response = $this->get('/api/customers/1');

        $response->assertStatus(404)
            ->assertJsonStructure(
                [
                    'errors' => [
                        'message'
                    ]
                ]
            );
    }

    /**
     * A feature test to delete a customer
     */
    public function test_delete_customer(): void
    {
        Customer::factory()->create();

        $response = $this->delete('/api/customers/1');

        $response->assertStatus(200);
    }

    /**
     * A feature test to delete a none-existent customer
     */
    public function test_delete_noneexistent_customer(): void
    {
        $response = $this->delete('/api/customers/1');

        $response->assertStatus(404)
            ->assertJsonStructure(
                [
                    'errors' => [
                        'message'
                    ]
                ]
            );
    }

    /**
     * A feature test to update a customer
     */
    public function test_update_customer(): void
    {
        $customer = Customer::factory()->create();

        $customer->firstName = 'newName';
        unset($customer->email);

        $response = $this->patch('/api/customers/1', $customer->toArray());

        $response
            ->assertStatus(200)
            ->assertJsonStructure(
                [
                    '*' => [
                        'firstName',
                        'lastName',
                        'email',
                        'phoneNumber',
                        'street',
                        'houseNumber',
                        'postCode',
                        'city',
                        'created_at',
                        'updated_at',
                        'id'
                    ],
                ]
            );
    }
}
