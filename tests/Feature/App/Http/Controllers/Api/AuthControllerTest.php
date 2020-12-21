<?php


namespace App\Http\Controllers\Api;


use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Class AuthControllerTest
 * @package App\Http\Controllers\Api
 */
class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('passport:install');
    }

    public function testSignup()
    {
        $response = $this->post(route('signup'), [
            'name' => 'Test',
            'email' => 'test@test.test',
            'password' => 'test'
        ], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(201);
        $response->assertJson(['message' => 'Successfully created user!']);
    }

    /**
     * This test case login and Logout
     */
    public function testLoginAndLogout(): void
    {
        $userFactory = factory(User::class)->create();

        $response = $this->post(route('login'), [
            'email' => $userFactory->email,
            'password' => 'password',
            'remember_me' => true
        ], [
            'Accept' => 'application/json'
        ]);


        $response->assertStatus(200);
        $response->assertJsonStructure(['access_token', 'token_type', 'expires_at']);

        $token = json_decode($response->getContent(), true);

        $responseLogout = $this->actingAs($userFactory)
            ->get(route('logout'),
                [
                    'Accept' => 'application/json',
                    'Authorization' => $token['token_type'] . " " . $token['access_token']
                ]);

        $responseLogout->assertStatus(200);
        $responseLogout->assertJson(['message' => 'Successfully logged out']);
    }

    public function testLoginUnauthorized(): void
    {
        $userFactory = factory(User::class)->create();

        $response = $this->post(route('login'), [
            'email' => $userFactory->email,
            'password' => '_incorrect',
            'remember_me' => true
        ], [
            'Accept' => 'application/json'
        ]);


        $response->assertStatus(401);
        $response->assertJson(['message' => 'Unauthorized']);
    }

    public function testLogoutUnauthorized(): void
    {
        $userFactory = factory(User::class)->create();

        $response = $this->post(route('login'), [
            'email' => $userFactory->email,
            'password' => 'password',
            'remember_me' => true
        ], [
            'Accept' => 'application/json'
        ]);


        $response->assertStatus(200);
        $response->assertJsonStructure(['access_token', 'token_type', 'expires_at']);

        $token = json_decode($response->getContent(), true);

        $responseLogout = $this->actingAs($userFactory)
            ->get(route('logout'),
                [
                    'Accept' => 'application/json',
                    'Authorization' => 'error'
                ]);

        $responseLogout->assertStatus(200);
        $responseLogout->assertJson(['message' => 'unauthenticated']);
    }

}
