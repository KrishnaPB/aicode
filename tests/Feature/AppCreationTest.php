<?php

namespace Tests\Feature;

use App\Models\User;
use App\Modules\Apps\Models\App;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AppCreationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_from_create_form(): void
    {
        $this->get('/apps/create')->assertRedirect('/login');
    }

    public function test_guest_is_redirected_when_storing_app(): void
    {
        $this->post('/apps', ['name' => 'My App'])->assertRedirect('/login');
    }

    public function test_authenticated_user_can_view_create_form(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/apps/create')->assertOk();
    }

    public function test_authenticated_user_can_create_app(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/apps', [
            'name' => 'My App',
            'description' => 'A test app',
        ]);

        $this->assertDatabaseHas('apps', [
            'user_id' => $user->id,
            'name' => 'My App',
        ]);
        $this->assertInstanceOf(App::class, $user->apps()->first());
        $response->assertRedirect(route('dashboard'));
    }

    public function test_name_is_required_to_create_app(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/apps', ['name' => ''])
            ->assertSessionHasErrors('name');
    }
}
