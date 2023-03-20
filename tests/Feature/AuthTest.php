<?php

namespace Tests\Feature;

use App\Models\ResetCodePassword;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{

    use RefreshDatabase;


    public function testSuccessfulLogin()
    {

        User::factory()->create([
            'email' => 'sample@test.com',
            'password' => bcrypt('sample123'),
         ])->toArray();


        $loginData = ['email' => 'sample@test.com', 'password' => 'sample123'];

        $response = $this->json('POST', 'api/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "status",
                "message",
                "data" => [
                    "token"
                ]
            ]);
            
        $this->assertAuthenticated();
    }

    public function testMustEnterEmailAndPassword()
    {
        $this->json('POST', 'api/login')
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    'email' => ["The email field is required."],
                    'password' => ["The password field is required."],
                ]
            ]);
    }

    
    public function testSuccessfulRegistration()
    {
        $userData = [
            "name" => "John Doe",
            "email" => "doe@example.com",
            "password" => "demo12345",
            "password_confirmation" => "demo12345"
        ];

        $this->json('POST', 'api/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                "status",
                "message",
                "data" => [
                    "token"
                ]
            ]);
    }

    public function testRequiredFieldsForRegistration()
    {
        $this->json('POST', 'api/register', ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "name" => ["The name field is required."],
                    "email" => ["The email field is required."],
                    "password" => ["The password field is required."],
                ]
            ]);
    }

    //api/password/email

    public function testSuccessForgotPassword()
    {
        $user = User::factory()->create();

        $data = [
            'email' => $user->email
        ];

        $this->json('POST', 'api/password/email', $data, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "status",
                "message",
                "data" => [
                    "result" => [
                        "code",
                        "email"
                    ]
                ]
            ]);
    }

    public function testErrorUserEmailNotExistForgotPassword()
    {
        $user = User::factory()->create();

        $data = [
            'email' => 'papibaquigrafo@gmail.com'
        ];

        $this->json('POST', 'api/password/email', $data, ['Accept' => 'application/json'])
            ->assertStatus(422);
    }

    //api/password/email

    //api/password/code/check

    public function testSuccessCodeCheck()
    {

        //pede o resete da senha
        $user = User::factory()->create();

        $forgotPassword = ResetCodePassword::create([
            'code' => mt_rand(100000, 999999),
            'email'=> $user->email
        ]);
        
        $data = [
            'code' => strval($forgotPassword->code),
            'password' => '123456'
        ];
        
        $response = $this->json('POST', 'api/password/code/check', $data, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "message",
            ]);
        
        //realiza o login para validar se houve success
        $loginData = ['email' => $user->email, 'password' => '123456'];

        $response = $this->json('POST', 'api/login', $loginData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "status",
                "message",
                "data" => [
                    "token"
                ]
            ]);
    }

    public function testErrorCodeCheck()
    {

        $user = User::factory()->create();

        $forgotPassword = ResetCodePassword::create([
            'code' => mt_rand(100000, 999999),
            'email'=> $user->email
        ]);
        
        $data = [
            'code' => "df654f5s6f45s4f",
            'password' => '123456'
        ];
        
        $response = $this->json('POST', 'api/password/code/check', $data, ['Accept' => 'application/json'])
            ->assertStatus(422);
        
    }

    //api/password/code/check

}
