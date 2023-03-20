<?php

namespace Tests\Feature;

use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TeacherTest extends TestCase
{
    public function getToken()
    {
        $user = User::factory()->create();
        return $user->createToken('API Token')->plainTextToken;
    }

    //api/teacher/index
    public function testTeacherIndexSuccess()
    {
        
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('get', '/api/teacher/index');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'result'
            ]
        ]);

    }

    public function testindexTeacherOffToken()
    {
        $response = $this->json('GET', '/api/teacher/index', [], ['Accept' => 'application/json']);
        $response->assertStatus(401);
    }


    public function testTeacherStoreSuccess()
    {
        $user = User::factory()->create();

        $data = [
            'created_by_user_id' => $user->id,
            "name" => "Pedrinho Silva",
            'address' => 'Travessa do pedrinho'
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
        ->json('POST', '/api/teacher/store', $data, ['Accept' => 'application/json']);
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'result'
            ]
        ]);
    }
    //api/teacher/index

    //api/teacher/store
    public function testTeacherStoreOffToken()
    {
        $user = User::factory()->create();

        $data = [
            'created_by_user_id' => $user->id,
            "name" => "Pedrinho Silva",
            'address' => 'Travessa do pedrinho',
        ];

        $response = $this->json('POST', '/api/teacher/store', $data, ['Accept' => 'application/json']);
        $response->assertStatus(401);
    }

    public function testTeacherStoreOffName()
    {
        $user = User::factory()->create();

        $data = [
            'created_by_user_id' => $user->id,
            'address' => 'Travessa do pedrinho'
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
        ->json('POST', '/api/teacher/store', $data, ['Accept' => 'application/json']);
        
        $response->assertStatus(422);

    }
    //api/teacher/store

    //api/teacher/show
    public function testTeachertShowSuccess()
    {
        $user = User::factory()->create();

        $teacher = Teacher::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome'
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('get', '/api/teacher/show/'.$teacher->id);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'result'
            ]
        ]);

    }

    public function testTeacherShowFindError()
    {

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('get', '/api/teacher/show/1000');

        $response->assertStatus(400);

    }

    public function testshowTeachertOffToken()
    {
        $user = User::factory()->create();

        $teacher = Teacher::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome'
        ]);

        $response = $this->json('GET', '/api/teacher/show'.$teacher->id, [], ['Accept' => 'application/json']);
        $response->assertStatus(404);
    }
    //api/teacher/show

    //api/teacher/update
    public function testTeacherUpdateSuccess()
    {
        $user = User::factory()->create();

        $teacher = Teacher::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome'
        ]);

        $update_teacher = [
            'created_by_user_id' => $user->id,
            'name' => 'Julio da silva',
            'address' => 'Rua com nome',
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('PUT', '/api/teacher/update/'.$teacher->id, $update_teacher, ['Accept' => 'application/json']);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'result'
            ]
        ]);

    }

    public function testTeacherUpdateErrorFindId()
    {
        $user = User::factory()->create();

        $teacher = Teacher::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome',
            'age' => '15'
        ]);

        $update_teacher = [
            'created_by_user_id' => $user->id,
            'name' => 'Julio da silva',
            'address' => 'Rua com nome',
            'age' => '12'
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('PUT', '/api/teacher/update/1000', $update_teacher, ['Accept' => 'application/json']);

        $response->assertStatus(404);

    }

    public function testTeacherUpdateErrorOffToken()
    {
        $user = User::factory()->create();

        $teacher = Teacher::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome',
            'age' => '15'
        ]);

        $update_teacher = [
            'created_by_user_id' => $user->id,
            'name' => 'Julio da silva',
            'address' => 'Rua com nome',
            'age' => '12'
        ];

        $response = $this->json('PUT', '/api/teacher/update/1000', $update_teacher, ['Accept' => 'application/json']);

        $response->assertStatus(401);

    }
    //api/teacher/update

    //api/teacher/destroy
    public function testTeacherDestroySuccess()
    {
        $user = User::factory()->create();

        $teacher = Teacher::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome',
            'age' => '15'
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('DELETE', '/api/teacher/destroy/'.$teacher->id, [], ['Accept' => 'application/json']);

        $response->assertStatus(200);

    }

    public function testTeacherDestroyErrorFindId()
    {
        $user = User::factory()->create();

        $teacher = Teacher::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome',
            'age' => '15'
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('DELETE', '/api/teacher/destroy/1000', [], ['Accept' => 'application/json']);

        $response->assertStatus(404);

    }

    public function testTeacherDestroyOffToken()
    {
        $user = User::factory()->create();

        $teacher = Teacher::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome',
            'age' => '15'
        ]);

        $response = $this->json('DELETE', '/api/teacher/destroy/'.$teacher->id, [], ['Accept' => 'application/json']);

        $response->assertStatus(401);

    }
    //api/teacher/destroy
}
