<?php

namespace Tests\Api\V1;

use App\Models\Group;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class GroupsControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Route Group List (/api/v1/groups)
     * Return array with 3 items
     */
    public function testGroupListWithItems()
    {
        factory(Group::class, 3)->create();

        $user = factory(User::class)->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->getJson('/api/v1/groups');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    /**
     * Route Group List (/api/v1/groups)
     * Test Limit
     */
    public function testGroupListWithLimit()
    {
        factory(Group::class, 10)->create();

        $user = factory(User::class)->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->getJson('/api/v1/groups?limit=2');

        $response->assertJsonCount(2);
    }

    /**
     * Route Group List (/api/v1/groups)
     * Test Offset
     */
    public function testGroupListWithOffset()
    {
        factory(Group::class, 10)->create();

        $user = factory(User::class)->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->getJson('/api/v1/groups?offset=2');

        $response->assertJsonCount(8);

        $data = json_decode($response->content());
        $this->assertEquals(3, $data[0]->id);
    }

    /**
     * Route Group List (/api/v1/groups)
     * Test Cnpj Filter
     */
    public function testGroupListWithCnpj()
    {
        $cnpjs = ['18.271.383/0001-06', '42.481.669/0001-92', '45.903.491/0001-19', '59.693.571/0001-00'];

        foreach ($cnpjs as $cnpj) {
            factory(Group::class)->create(['cnpj' => preg_replace('/\D/', '', $cnpj)]);
        }

        $user = factory(User::class)->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->getJson('/api/v1/groups?cnpj=' . $cnpjs[0] . ',' . preg_replace('/\D/', '', $cnpjs[3]))
            ->decodeResponseJson();

        $this->assertCount(2, $response);
        $this->assertEquals(preg_replace('/\D/', '', $cnpjs[0]), $response[0]['cnpj']);
        $this->assertEquals(preg_replace('/\D/', '', $cnpjs[3]), $response[1]['cnpj']);
    }

    /**
     * Route Store Group (/api/v1/groups)
     * Test Store
     */
    public function testStoreGroup()
    {
        factory(Group::class)->create();
        $user = factory(User::class)->create();
        $token = JWTAuth::fromUser($user);

        $data = [
            "name" => "FBS Sistemas",
            "cnpj" => "80.066.527/0001-58",
            "code" => 137,
            "active" => 1
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/v1/groups', $data);

        $response->assertStatus(201);
    }

    /**
     * Route Show Group (/api/v1/groups)
     * Test Show
     */
    public function testShowGroup()
    {
        $group = factory(Group::class)->create();
        $user = factory(User::class)->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->getJson('/api/v1/groups/' . $group->id)
            ->decodeResponseJson();

        $this->assertEquals($group->id, $response['id']);
        $this->assertEquals($group->name, $response['name']);
        $this->assertEquals($group->code, $response['code']);
        $this->assertEquals($group->cnpj, $response['cnpj']);
        $this->assertEquals($group->type, intVal($response['type']));
        $this->assertEquals($group->active, intVal($response['active']));
    }

    /**
     * Route Update Group (/api/v1/groups)
     * Test Update
     */
    public function testUpdateGroup()
    {
        $group = factory(Group::class)->create();
        $user = factory(User::class)->create();
        $token = JWTAuth::fromUser($user);

        $data = [
            "name" => "FBS Sistemas",
            "cnpj" => "80.066.527/0001-58",
            "code" => 137,
            "type" => 1,
            "active" => 1
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->putJson('/api/v1/groups/' . $group->id, $data);

        $response->assertStatus(200);

        $this->assertEquals($data['name'], $response['name']);
        $this->assertEquals($data['code'], $response['code']);
        $this->assertEquals(preg_replace('/\D/', '', $data['cnpj']), $response['cnpj']);
        $this->assertEquals($data['type'], intVal($response['type']));
        $this->assertEquals($data['active'], intVal($response['active']));
    }

    /**
     * Route Delete Group (/api/v1/groups)
     * Test Delete
     */
    public function testDeleteGroup()
    {
        $group = factory(Group::class)->create();
        $user = factory(User::class)->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->deleteJson('/api/v1/groups/' . $group->id);

        $response->assertStatus(200);

        $this->assertEquals('ok', $response['result']);
    }

    /**
     * Route Store Group Batches (/api/v1/groups/batches)
     * Test Store Batches
     */
    public function testStoreGroupBatches()
    {
        factory(Group::class)->create();
        $user = factory(User::class)->create();
        $token = JWTAuth::fromUser($user);

        $data = [
            "groups" => [
                [
                    "name" => "FBS Sistemas Ltda",
                    "cnpj" => "80.066.527/0001-58",
                    "code" => 137,
                    "type" => 1,
                    "active" => 1
                ],
                [
                    "name" => "Informatica New",
                    "cnpj" => "23.138.950/0001-82",
                    "code" => 246,
                    "type" => 0,
                    "active" => 1
                ],
            ]
        ];

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->postJson('/api/v1/groups/batches', $data);

        $this->assertEquals('ok', $response['result']);
    }

    /**
     * Route Update Group Batches (/api/v1/groups/batches)
     * Test Update Batches
     */
    public function testUpdateGroupBatches()
    {
        $data = [
            "groups" => [
                [
                    "name" => "FBS Sistemas Ltda",
                    "cnpj" => "80.066.527/0001-58",
                    "code" => 137,
                    "type" => 1,
                    "active" => 1
                ],
                [
                    "name" => "Informatica New",
                    "cnpj" => "23.138.950/0001-82",
                    "code" => 246,
                    "type" => 0,
                    "active" => 1
                ],
            ]
        ];

        foreach ($data['groups'] as $group) {
            factory(Group::class)->create(['cnpj' => preg_replace('/\D/', '', $group['cnpj'])]);
        }

        $user = factory(User::class)->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->putJson('/api/v1/groups/batches', $data);

        $this->assertEquals('ok', $response['result']);
    }

    /**
     * Route Update Group Batches (/api/v1/groups/batches)
     * Test Update Batches
     */
    public function testDeleteGroupBatches()
    {
        $data = [
            "groups" => [
                ["cnpj" => "80.066.527/0001-58"],
                ["cnpj" => "23.138.950/0001-82"],
            ]
        ];

        foreach ($data['groups'] as $group) {
            factory(Group::class)->create(['cnpj' => preg_replace('/\D/', '', $group['cnpj'])]);
        }

        $user = factory(User::class)->create();
        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->deleteJson('/api/v1/groups/batches', $data);

        $this->assertEquals('ok', $response['result']);
    }
}
