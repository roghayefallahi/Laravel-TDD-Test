<?php

namespace Tests\Feature\Views;

use App\Models\User;
use Illuminate\Auth\Authenticatable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LayoutViewTest extends TestCase
{
    use Authenticatable;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLayoutViewRenderWhenUserIsAdmin()
    {
        $user = User::factory()->state(['role' => 'admin'])->create();


        $this->actingAs($user);

        $view = $this->view('layouts.app');

        $view->assertSee('<a href="admin/dashboard">adminPanel</a>', false);
    }

    public function testLayoutViewRenderWhenUserIsNotAdmin()
    {
        $user = User::factory()->state(['role' => 'user'])->create();

        $this->actingAs($user);

        $view = $this->view('layouts.app');

        $view->assertDontSee('<a href="admin/dashboard">adminPanel</a>
       ', false);
    }
}
