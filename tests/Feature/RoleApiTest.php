<?php

declare(strict_types=1);

use Modules\User\Models\Role;

describe('Role API', function () {
    beforeEach(function () {
        $this->admin = \Modules\User\Models\User::factory()->create();
        $this->token = $this->admin->createToken('Test Token')->accessToken;
    });

    it('can create a new role', function () {
        $response = $this->withHeader('Authorization', "Bearer {$this->token}")
            ->postJson('/api/roles', [
                'name' => 'moderator',
                'description' => 'Moderator role',
                'permissions' => [],
            ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('roles', [
            'name' => 'moderator',
        ]);
    });

    it('can retrieve all roles', function () {
        Role::factory()->count(3)->create();

        $response = $this->withHeader('Authorization', "Bearer {$this->token}")
            ->getJson('/api/roles');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'description'],
            ],
            'pagination',
        ]);
    });

    it('can retrieve a single role', function () {
        $role = Role::factory()->create();

        $response = $this->withHeader('Authorization', "Bearer {$this->token}")
            ->getJson("/api/roles/{$role->id}");

        $response->assertStatus(200);
        $response->assertJsonPath('data.id', $role->id);
    });

    it('can update a role', function () {
        $role = Role::factory()->create();

        $response = $this->withHeader('Authorization', "Bearer {$this->token}")
            ->putJson("/api/roles/{$role->id}", [
                'description' => 'Updated description',
            ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('roles', [
            'id' => $role->id,
            'description' => 'Updated description',
        ]);
    });

    it('can delete a role', function () {
        $role = Role::factory()->create();

        $response = $this->withHeader('Authorization', "Bearer {$this->token}")
            ->deleteJson("/api/roles/{$role->id}");

        $response->assertStatus(200);
        $this->assertSoftDeleted($role);
    });
});
