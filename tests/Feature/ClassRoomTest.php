<?php

namespace Tests\Feature;

use App\Models\ClassRoom;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClassRoomTest extends TestCase
{
    public function getToken()
    {
        $user = User::factory()->create();
        return $user->createToken('API Token')->plainTextToken;
    }

    //api/class_room/index
    public function testClassRoomIndexSuccess()
    {
        
        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('get', '/api/class_room/index');

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'result'
            ]
        ]);

    }

    public function testindexClassRoomOffToken()
    {
        $response = $this->json('GET', '/api/class_room/index', [], ['Accept' => 'application/json']);
        $response->assertStatus(401);
    }


    public function testClassRoomStoreSuccess()
    {
        $user = User::factory()->create();

        $student = Student::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome',
            'age' => '15'
        ]);

        $teacher = Teacher::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome'
        ]);

        $data = [
            "name" => "Pre 1",
            'student_id' => $student->id,
            'teacher_id' => $teacher->id
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
        ->json('POST', '/api/class_room/store', $data, ['Accept' => 'application/json']);
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'result'
            ]
        ]);
    }
    //api/class_room/index

    //api/class_room/store
    public function testClassRoomStoreOffToken()
    {
        $user = User::factory()->create();

        $student = Student::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome',
            'age' => '15'
        ]);

        $teacher = Teacher::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome'
        ]);

        $data = [
            "name" => "Pre 1",
            'student_id' => $student->id,
            'teacher_id' => $teacher->id
        ];

        $response = $this->json('POST', '/api/class_room/store', $data, ['Accept' => 'application/json']);
        $response->assertStatus(401);
    }

    public function testClassRoomStoreOffName()
    {
        $user = User::factory()->create();

        $student = Student::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome',
            'age' => '15'
        ]);

        $teacher = Teacher::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome'
        ]);

        $data = [
            'student_id' => $student->id,
            'teacher_id' => $teacher->id
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
        ->json('POST', '/api/class_room/store', $data, ['Accept' => 'application/json']);
        
        $response->assertStatus(400);

    }
    //api/class_room/store

    //api/class_room/show
    public function testClassRoomShowSuccess()
    {
        $user = User::factory()->create();

        $student = Student::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome',
            'age' => '15'
        ]);

        $teacher = Teacher::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome'
        ]);

        $class_room = ClassRoom::create([
            "name" => "Pre 1",
            'student_id' => $student->id,
            'teacher_id' => $teacher->id
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('get', '/api/class_room/show/'.$class_room->id);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'data' => [
                'result'
            ]
        ]);

    }

    public function testClassRoomShowFindError()
    {

        $user = User::factory()->create();

        $student = Student::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome',
            'age' => '15'
        ]);

        $teacher = Teacher::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome'
        ]);

        $class_room = ClassRoom::create([
            "name" => "Pre 1",
            'student_id' => $student->id,
            'teacher_id' => $teacher->id
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('get', '/api/class_room/show/1000');

        $response->assertStatus(400);

    }

    public function testshowClassRoomOffToken()
    {
        $user = User::factory()->create();

        $student = Student::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome',
            'age' => '15'
        ]);

        $teacher = Teacher::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome'
        ]);

        $class_room = ClassRoom::create([
            "name" => "Pre 1",
            'student_id' => $student->id,
            'teacher_id' => $teacher->id
        ]);

        $response = $this->json('get', '/api/class_room/show/'.$class_room->id);

        $response->assertStatus(401);

    }
    //api/class_room/show

    //api/class_room/update
    public function testClassRoomUpdateSuccess()
    {
        $user = User::factory()->create();

        $student = Student::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome',
            'age' => '15'
        ]);

        $teacher = Teacher::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome'
        ]);

        $class_room = ClassRoom::create([
            "name" => "Pre 1",
            'student_id' => $student->id,
            'teacher_id' => $teacher->id
        ]);

        $new_class_room = [
            "name" => "Pre 2",
            'student_id' => $student->id,
            'teacher_id' => $teacher->id
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('PUT', '/api/class_room/update/'.$class_room->id, $new_class_room, ['Accept' => 'application/json']);

        $response->assertStatus(200);

    }

    public function testClassRoomUpdateErrorFindId()
    {
        $user = User::factory()->create();

        $student = Student::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome',
            'age' => '15'
        ]);

        $teacher = Teacher::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome'
        ]);

        $class_room = ClassRoom::create([
            "name" => "Pre 1",
            'student_id' => $student->id,
            'teacher_id' => $teacher->id
        ]);

        $new_class_room = [
            "name" => "Pre 2",
            'student_id' => $student->id,
            'teacher_id' => $teacher->id
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('PUT', '/api/class_room/update/1000', $new_class_room, ['Accept' => 'application/json']);

        $response->assertStatus(404);

    }

    public function testClassRoomUpdateErrorOffToken()
    {
        $user = User::factory()->create();

        $student = Student::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome',
            'age' => '15'
        ]);

        $teacher = Teacher::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome'
        ]);

        $class_room = ClassRoom::create([
            "name" => "Pre 1",
            'student_id' => $student->id,
            'teacher_id' => $teacher->id
        ]);

        $new_class_room = [
            "name" => "Pre 2",
            'student_id' => $student->id,
            'teacher_id' => $teacher->id
        ];

        $response = $this->json('PUT', '/api/class_room/update/'.$class_room->id, $new_class_room, ['Accept' => 'application/json']);

        $response->assertStatus(401);

    }
    //api/class_room/update

    //api/class_room/destroy
    public function testClassRoomDestroySuccess()
    {
        $user = User::factory()->create();

        $student = Student::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome',
            'age' => '15'
        ]);

        $teacher = Teacher::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome'
        ]);

        $ClassRoom = ClassRoom::create([
            "name" => "Pre 1",
            'student_id' => $student->id,
            'teacher_id' => $teacher->id
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('DELETE', '/api/class_room/destroy/'.$ClassRoom->id, [], ['Accept' => 'application/json']);

        $response->assertStatus(200);

    }

    public function testClassRoomDestroyErrorFindId()
    {
        $user = User::factory()->create();

        $student = Student::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome',
            'age' => '15'
        ]);

        $teacher = Teacher::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome'
        ]);

        $ClassRoom = ClassRoom::create([
            "name" => "Pre 1",
            'student_id' => $student->id,
            'teacher_id' => $teacher->id
        ]);

        $response = $this->withHeader('Authorization', 'Bearer ' . $this->getToken())
            ->json('DELETE', '/api/class_room/destroy/1000', [], ['Accept' => 'application/json']);

        $response->assertStatus(404);

    }

    public function testClassRoomDestroyOffToken()
    {
        $user = User::factory()->create();

        $student = Student::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome',
            'age' => '15'
        ]);

        $teacher = Teacher::create([
            'created_by_user_id' => $user->id,
            'name' => 'teste da silva',
            'address' => 'Rua sem nome'
        ]);

        $ClassRoom = ClassRoom::create([
            "name" => "Pre 1",
            'student_id' => $student->id,
            'teacher_id' => $teacher->id
        ]);

        $response = $this->json('DELETE', '/api/class_room/destroy/'.$ClassRoom->id, [], ['Accept' => 'application/json']);

        $response->assertStatus(401);

    }
    //api/class_room/destroy
}
