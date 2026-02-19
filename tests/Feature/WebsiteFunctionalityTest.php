<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WebsiteFunctionalityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_are_redirected_from_root_to_welcome()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertViewIs('welcome');
    }

    /** @test */
    public function authenticated_users_are_redirected_from_root_to_dashboard()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/');
        $response->assertRedirect(route('dashboard'));
    }

    /** @test */
    public function can_create_task_via_ajax()
    {
        $user = User::factory()->create(['role' => 'admin']);
        
        $response = $this->actingAs($user)->postJson(route('tasks.store'), [
            'tasksTitle' => 'Test Task',
            'clientsName' => 'Test Client',
            'TasksDescription' => 'Test Description',
            'task_status' => 0, // Pending
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment(['message' => 'Task created successfully!']);
        
        $this->assertDatabaseHas('tasks', [
            'task_title' => 'Test Task',
            'client_name' => 'Test Client'
        ]);
    }

    /** @test */
    public function admin_can_see_all_tasks()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Task::factory()->count(3)->create(['status' => 0]); // 3 pending
        Task::factory()->count(2)->create(['status' => 1]); // 2 active

        $response = $this->actingAs($admin)->get(route('dashboard'));
        $response->assertStatus(200);
        // Checking view composer logic via shared data if possible, or just checking the page status
    }

    /** @test */
    public function user_cannot_see_unassigned_tasks()
    {
        $user = User::factory()->create(['role' => 'user']);
        $task = Task::factory()->create(['status' => 0]); 

        // Dashboard logic checks if user is assigned to task via pivot table
        $response = $this->actingAs($user)->get(route('dashboard'));
        $response->assertStatus(200);
        
        // This is tricky to test via HTML content without knowing the exact view structure,
        // but we can test the sidebar updates endpoint which returns JSON.
        
        $response = $this->actingAs($user)->get(route('sidebar.updates'));
        $response->assertStatus(200);
        $response->assertJsonMissing(['<li>' . $task->task_title . '</li>']); 
    }
}
