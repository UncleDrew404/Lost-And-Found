<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class RolePermissionApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function test_registration_assigns_staff_role_and_permissions(): void
    {
        $response = $this->postJson('/api/v1/register', [
            'email' => 'staff@example.com',
            'password' => 'password',
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.user.roles.0', 'staff')
            ->assertJsonPath('data.user.permissions.0', 'items.view')
            ->assertJsonStructure([
                'data' => [
                    'token',
                ],
            ]);
    }

    public function test_unauthenticated_users_can_view_items_but_cannot_manage_them(): void
    {
        $item = $this->createItem();

        $this->getJson('/api/v1/items')->assertOk();
        $this->getJson("/api/v1/items/{$item->id}")->assertOk();
        $this->postJson('/api/v1/items', $this->itemPayload())->assertUnauthorized();
        $this->patchJson("/api/v1/items/{$item->id}", ['title' => 'Updated item'])->assertUnauthorized();
        $this->deleteJson("/api/v1/items/{$item->id}")->assertUnauthorized();
    }

    public function test_students_can_view_items_but_cannot_manage_them(): void
    {
        $student = $this->userWithRole('student');
        $item = $this->createItem();
        Sanctum::actingAs($student);

        $this->getJson('/api/v1/items')->assertOk();
        $this->getJson("/api/v1/items/{$item->id}")->assertOk();
        $this->postJson('/api/v1/items', $this->itemPayload())->assertForbidden();
        $this->patchJson("/api/v1/items/{$item->id}", ['title' => 'Updated item'])->assertForbidden();
        $this->deleteJson("/api/v1/items/{$item->id}")->assertForbidden();
    }

    public function test_staff_can_view_and_manage_items(): void
    {
        $staff = $this->userWithRole('staff');
        $item = $this->createItem();
        Sanctum::actingAs($staff);

        $this->getJson('/api/v1/items')->assertOk();
        $this->postJson('/api/v1/items', $this->itemPayload())->assertCreated();
        $this->patchJson("/api/v1/items/{$item->id}", ['title' => 'Updated item'])
            ->assertOk()
            ->assertJsonPath('data.title', 'Updated item');
        $this->deleteJson("/api/v1/items/{$item->id}")->assertOk();
    }

    public function test_admin_can_list_users_roles_and_assign_roles(): void
    {
        $admin = $this->userWithRole('admin');
        $student = $this->userWithRole('student');
        Sanctum::actingAs($admin);

        $this->getJson('/api/v1/users')->assertOk();
        $this->getJson('/api/v1/roles')->assertOk();

        $this->patchJson("/api/v1/users/{$student->id}/role", ['role' => 'staff'])
            ->assertOk()
            ->assertJsonPath('data.roles.0', 'staff');

        $this->assertTrue($student->fresh()->hasRole('staff'));
    }

    public function test_non_admin_cannot_assign_roles(): void
    {
        $staff = $this->userWithRole('staff');
        $student = $this->userWithRole('student');
        Sanctum::actingAs($staff);

        $this->patchJson("/api/v1/users/{$student->id}/role", ['role' => 'staff'])
            ->assertForbidden();
    }

    private function userWithRole(string $role): User
    {
        $user = User::factory()->create();
        $user->assignRole($role);

        return $user;
    }

    private function createItem(): Item
    {
        return Item::factory()->create([
            'user_id' => $this->userWithRole('staff')->id,
            'category_id' => Category::factory()->create()->id,
        ]);
    }

    private function itemPayload(): array
    {
        return [
            'category_id' => Category::factory()->create()->id,
            'title' => 'Lost ID card',
            'description' => 'A school ID card found near the lobby.',
            'type' => 'lost',
            'status' => 'active',
            'location' => 'Main lobby',
            'date_occured' => now()->toDateTimeString(),
            'contact_info' => '09171234567',
        ];
    }
}
