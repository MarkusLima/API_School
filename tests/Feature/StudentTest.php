<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\User;
use Tests\TestCase;

class StudentTest extends TestCase
{

    public function getToken()
    {
        $user = User::factory()->create();
        return $user->createToken('API Token')->plainTextToken;
    }

    //api/student/index
    public function testStudentIndexSuccess()
    {
        
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('get', '/api/student/index');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'result'
            ]
        ]);

    }

    public function testindexStudentOffToken()
    {
        $response = $this->json('GET', '/api/student/index', [], ['Accept' => 'application/json']);
        $response->assertStatus(401);
    }


    public function testStudentStoreSuccess()
    {
        $user = User::factory()->create();

        $data = [
            'created_by_user_id' => $user->id,
            "name" => "Pedrinho Silva",
            'address' => 'Travessa do pedrinho',
            "age" => "10"
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
        ->json('POST', '/api/student/store', $data, ['Accept' => 'application/json']);
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'result'
            ]
        ]);
    }
    //api/student/index

    //api/student/store
    public function testStudentStoreOffToken()
    {
        $user = User::factory()->create();

        $data = [
            'created_by_user_id' => $user->id,
            "name" => "Pedrinho Silva",
            'address' => 'Travessa do pedrinho',
            "age" => "10"
        ];

        $response = $this->json('POST', '/api/student/store', $data, ['Accept' => 'application/json']);
        $response->assertStatus(401);
    }

    public function testStudentStoreOffName()
    {
        $user = User::factory()->create();

        $data = [
            'created_by_user_id' => $user->id,
            'address' => 'Travessa do pedrinho',
            "age" => "10"
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
        ->json('POST', '/api/student/store', $data, ['Accept' => 'application/json']);
        
        $response->assertStatus(400);

    }
    //api/student/store

    //api/student/show
    public function testStudentShowSuccess()
    {
        $user = User::factory()->create();

        $tudent = Student::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome',
            'age' => '15'
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('get', '/api/student/show/'.$tudent->id);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'result'
            ]
        ]);

    }

    public function testStudentShowFindError()
    {

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('get', '/api/student/show/1000');

        $response->assertStatus(400);

    }

    public function testshowStudentOffToken()
    {
        $user = User::factory()->create();

        $tudent = Student::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome',
            'age' => '15'
        ]);

        $response = $this->json('GET', '/api/student/show'.$tudent->id, [], ['Accept' => 'application/json']);
        $response->assertStatus(404);
    }
    //api/student/show

    //api/student/update
    public function testStudentUpdateSuccess()
    {
        $user = User::factory()->create();

        $student = Student::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome',
            'age' => '15'
        ]);

        $update_student = [
            'created_by_user_id' => $user->id,
            'name' => 'Julio da silva',
            'address' => 'Rua com nome',
            'age' => '12'
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('PUT', '/api/student/update/'.$student->id, $update_student, ['Accept' => 'application/json']);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'result'
            ]
        ]);

    }

    public function testStudentUpdateErrorFindId()
    {
        $user = User::factory()->create();

        $student = Student::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome',
            'age' => '15'
        ]);

        $update_student = [
            'created_by_user_id' => $user->id,
            'name' => 'Julio da silva',
            'address' => 'Rua com nome',
            'age' => '12'
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('PUT', '/api/student/update/1000', $update_student, ['Accept' => 'application/json']);

        $response->assertStatus(404);

    }

    public function testStudentUpdateErrorOffToken()
    {
        $user = User::factory()->create();

        $student = Student::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome',
            'age' => '15'
        ]);

        $update_student = [
            'created_by_user_id' => $user->id,
            'name' => 'Julio da silva',
            'address' => 'Rua com nome',
            'age' => '12'
        ];

        $response = $this->json('PUT', '/api/student/update/1000', $update_student, ['Accept' => 'application/json']);

        $response->assertStatus(401);

    }
    //api/student/update

    //api/student/destroy
    public function testStudentDestroySuccess()
    {
        $user = User::factory()->create();

        $student = Student::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome',
            'age' => '15'
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('DELETE', '/api/student/destroy/'.$student->id, [], ['Accept' => 'application/json']);

        $response->assertStatus(200);

    }

    public function testStudentDestroyErrorFindId()
    {
        $user = User::factory()->create();

        $student = Student::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome',
            'age' => '15'
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('DELETE', '/api/student/destroy/1000', [], ['Accept' => 'application/json']);

        $response->assertStatus(404);

    }

    public function testStudentDestroyOffToken()
    {
        $user = User::factory()->create();

        $student = Student::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome',
            'age' => '15'
        ]);

        $response = $this->json('DELETE', '/api/student/destroy/'.$student->id, [], ['Accept' => 'application/json']);

        $response->assertStatus(401);

    }
    //api/student/destroy

}
