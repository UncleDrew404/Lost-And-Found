<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserProfile;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Spatie\Permission\PermissionRegistrar;
use Tests\TestCase;

class UserProfileApiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function test_unauthenticated_users_cannot_access_profile_endpoints(): void
    {
        $this->getJson('/api/v1/profile')->assertUnauthorized();
        $this->putJson('/api/v1/profile', $this->profilePayload())->assertUnauthorized();
        $this->patchJson('/api/v1/profile', $this->profilePayload())->assertUnauthorized();
    }

    public function test_authenticated_user_can_read_existing_profile(): void
    {
        $user = User::factory()->create();
        UserProfile::factory()->create([
            'user_id' => $user->id,
            'first_name' => 'Drew',
            'middle_name' => 'Lee',
            'last_name' => 'Santos',
            'gender' => 'male',
            'phone_number' => '09171234567',
            'bio' => 'Profile bio.',
            'avatar' => 'avatars/drew.png',
            'department' => 'Computer Science',
            'student_id' => 'STU-12345',
        ]);
        Sanctum::actingAs($user);

        $this->getJson('/api/v1/profile')
            ->assertOk()
            ->assertJsonPath('data.id', $user->id)
            ->assertJsonPath('data.profile.first_name', 'Drew')
            ->assertJsonPath('data.profile.middle_name', 'Lee')
            ->assertJsonPath('data.profile.last_name', 'Santos')
            ->assertJsonPath('data.profile.full_name', 'Drew Lee Santos')
            ->assertJsonPath('data.profile.gender', 'male')
            ->assertJsonPath('data.profile.phone_number', '09171234567')
            ->assertJsonPath('data.profile.bio', 'Profile bio.')
            ->assertJsonPath('data.profile.avatar', 'avatars/drew.png')
            ->assertJsonPath('data.profile.department', 'Computer Science')
            ->assertJsonPath('data.profile.student_id', 'STU-12345');
    }

    public function test_authenticated_user_without_profile_can_read_profile(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $this->getJson('/api/v1/profile')
            ->assertOk()
            ->assertJsonPath('data.id', $user->id)
            ->assertJsonPath('data.profile', null);
    }

    public function test_authenticated_user_can_create_profile(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $this->putJson('/api/v1/profile', $this->profilePayload([
            'first_name' => 'Jane',
            'last_name' => 'Cruz',
            'gender' => 'female',
        ]))
            ->assertOk()
            ->assertJsonPath('data.profile.first_name', 'Jane')
            ->assertJsonPath('data.profile.last_name', 'Cruz')
            ->assertJsonPath('data.profile.gender', 'female');

        $this->assertDatabaseHas('user_profiles', [
            'user_id' => $user->id,
            'first_name' => 'Jane',
            'last_name' => 'Cruz',
            'gender' => 'female',
        ]);
    }

    public function test_authenticated_user_can_update_existing_profile(): void
    {
        $user = User::factory()->create();
        UserProfile::factory()->create([
            'user_id' => $user->id,
            'first_name' => 'Old',
            'last_name' => 'Name',
        ]);
        Sanctum::actingAs($user);

        $this->patchJson('/api/v1/profile', [
            'first_name' => 'New',
            'phone_number' => '09998887777',
        ])
            ->assertOk()
            ->assertJsonPath('data.profile.first_name', 'New')
            ->assertJsonPath('data.profile.last_name', 'Name')
            ->assertJsonPath('data.profile.phone_number', '09998887777');

        $this->assertDatabaseHas('user_profiles', [
            'user_id' => $user->id,
            'first_name' => 'New',
            'last_name' => 'Name',
            'phone_number' => '09998887777',
        ]);
    }

    public function test_profile_update_validates_fields(): void
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $this->patchJson('/api/v1/profile', [
            'first_name' => str_repeat('a', 256),
            'gender' => 'unknown',
            'phone_number' => str_repeat('1', 51),
            'bio' => str_repeat('a', 2001),
            'avatar' => str_repeat('a', 2049),
            'department' => str_repeat('a', 256),
            'student_id' => str_repeat('a', 256),
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'first_name',
                'gender',
                'phone_number',
                'bio',
                'avatar',
                'department',
                'student_id',
            ]);
    }

    private function profilePayload(array $overrides = []): array
    {
        return [
            'first_name' => 'Drew',
            'middle_name' => 'Lee',
            'last_name' => 'Santos',
            'gender' => 'male',
            'phone_number' => '09171234567',
            'bio' => 'Profile bio.',
            'avatar' => 'avatars/drew.png',
            'department' => 'Computer Science',
            'student_id' => 'STU-12345',
            ...$overrides,
        ];
    }
}
