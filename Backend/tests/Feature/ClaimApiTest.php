<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Claim;
use App\Models\Item;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class ClaimApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function test_unauthenticated_users_cannot_access_claim_endpoints(): void
    {
        $claim = Claim::factory()->create([
            'item_id' => $this->createFoundItem()->id,
            'user_id' => $this->userWithRole('student')->id,
        ]);

        $this->getJson('/api/v1/claims')->assertUnauthorized();
        $this->patchJson("/api/v1/claims/{$claim->id}/status", ['status' => 'approved'])->assertUnauthorized();
    }

    public function test_moderator_can_list_claims_and_update_status(): void
    {
        $staff = $this->userWithRole('staff');
        $claim = Claim::factory()->create([
            'item_id' => $this->createFoundItem()->id,
            'user_id' => $this->userWithRole('student')->id,
            'status' => 'pending',
        ]);
        Sanctum::actingAs($staff);

        $this->getJson('/api/v1/claims')
            ->assertOk()
            ->assertJsonPath('data.0.id', $claim->id);

        $this->patchJson("/api/v1/claims/{$claim->id}/status", ['status' => 'approved'])
            ->assertOk()
            ->assertJsonPath('data.status', 'approved');

        $this->assertDatabaseHas('claims', [
            'id' => $claim->id,
            'status' => 'approved',
        ]);
    }

    public function test_student_cannot_moderate_claims(): void
    {
        $student = $this->userWithRole('student');
        $claim = Claim::factory()->create([
            'item_id' => $this->createFoundItem()->id,
            'user_id' => $student->id,
            'status' => 'pending',
        ]);
        Sanctum::actingAs($student);

        $this->getJson('/api/v1/claims')->assertForbidden();
        $this->patchJson("/api/v1/claims/{$claim->id}/status", ['status' => 'approved'])->assertForbidden();
    }

    private function userWithRole(string $role): User
    {
        $user = User::factory()->create();
        $user->assignRole($role);

        return $user;
    }

    private function createFoundItem(array $attributes = []): Item
    {
        return Item::factory()->create([
            'user_id' => $this->userWithRole('staff')->id,
            'category_id' => Category::factory()->create()->id,
            'type' => 'found',
            ...$attributes,
        ]);
    }
}
