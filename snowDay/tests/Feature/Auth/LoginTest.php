<?php

// factory(User::class)->create(); // Creates a user and inserts him into the database
// factory(User::class)->make(); // Creates a user object

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testUserCanViewALoginForm() {

        $response = $this->get('/login');
        $response->assertSuccessful();
        $response->assertViewIs('auth.login');
    }

    public function testUserCannotViewALoginFormWhenAuthenticated() {

        $user = factory(User::class)->make();
        $response = $this->actingAs($user)->get('/login');
        $response->assertRedirect('/votes/create');
    }  

    public function testUserCanLoginWithCorrectCredentials()
    {
        $user = factory(User::class)->create([
            'password' => bcrypt('canLogin?'),
            'email' => 'email@email.com',
            'school' => 'NSCC'
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'canLogin?',
        ]);

        $response->assertRedirect('/votes/create');
        $this->assertAuthenticatedAs($user);
    }

    public function testRedirectToVotesShow()  {
        
        $response = $this->from('/votes/create')->post('/votes/create', [
            'name' => 'Chris',
            'school' => 'NSCC',
            'vote' => 0
        ]);
        
        $response->assertRedirect('/votes/show');
    }
}
