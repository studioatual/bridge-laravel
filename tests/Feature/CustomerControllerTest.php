<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Route List Customers (/api/customers)
     * Return status code 200 with empty array
     */
    public function testCustomerListWithStatusOk()
    {
        $response = $this->getJson('/api/customers');
        $response->assertStatus(200)
            ->assertJson([]);
    }

    /**
     * Route List Customers (/api/customers)
     * Return array with 3 items
     */
    public function testCustomerListWithItems()
    {
        factory(User::class, 1)->create();
        factory(Customer::class, 3)->create();

        $response = $this->getJson('/api/customers');
        $response->assertJsonCount(3);
    }

    /**
     * Route List Customers (/api/customers)
     * Test Limit array
     */
    public function testCustomerListWithLimit()
    {
        factory(User::class, 1)->create();
        factory(Customer::class, 10)->create();

        $response = $this->getJson('/api/customers?limit=2');
        $response->assertJsonCount(2);
    }

    /**
     * Route List Customers (/api/customers)
     * Test Offset 2
     */
    public function testCustomerListWithOffset()
    {
        factory(User::class, 1)->create();
        factory(Customer::class, 10)->create();

        $response = $this->getJson('/api/customers?offset=2');
        //dd($response->getContent());
        $data = json_decode($response->content());
        $this->assertEquals(3, $data[0]->id);
    }

    /**
     * Route List Customers (/api/customers)
     * Test Offset 2
     */
    public function testCustomerListWithCnpj()
    {
        factory(User::class, 1)->create();
        $customer1 = factory(Customer::class)->create([
            'cnpj' => '18271383000106'
        ]);
        $customer2 = factory(Customer::class)->create([
            'cnpj' => '42481669000192'
        ]);
        $customer3 = factory(Customer::class)->create([
            'cnpj' => '45903491000119'
        ]);
        $customer4 = factory(Customer::class)->create([
            'cnpj' => '59693571000100'
        ]);

        $response = $this->getJson('/api/customers?cnpj=18.271.383/0001-06,45903491000119');
        $data = json_decode($response->content());

        $this->assertEquals($customer1->cnpj, $data[0]->cnpj);
        $this->assertEquals($customer3->cnpj, $data[1]->cnpj);
    }
}
