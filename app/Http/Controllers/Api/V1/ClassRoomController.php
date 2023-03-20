<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class ClassRoomController extends Controller
{
    use ApiResponser;


    /**
    * @OA\Get(
    * path="/api/class_room/index",
    * security={ {"bearerToken":{}} },
    * operationId="ListClass",
    * tags={"Class"},
    * summary="List class",
    * description="Return all class",
    *      @OA\Response(
    *          response=200,
    *          description="Register Successfully",
    *          @OA\JsonContent()
    *       ),
    *      @OA\Response(response=404, description="Resource Not Found"),
    * )
    */
    public function index()
    {
        $response = ClassRoom::all();
        return $this->success(['result' => $response]);
    }


     /**
    * @OA\Post(
    * path="/api/class_room/store",
    * security={ {"bearerToken":{}} },
    * operationId="ClassStore",
    * tags={"Class"},
    * summary="ClassStore",
    * description="Create Class",
    *     @OA\RequestBody(
    *         @OA\JsonContent(),
    *         @OA\MediaType(
    *            mediaType="multipart/form-data",
    *            @OA\Schema(
    *               type="object",
    *               required={"name","student_id", "teacher_id"},
    *               @OA\Property(property="name", type="text"),
    *               @OA\Property(property="student_id", type="int"),
    *               @OA\Property(property="teacher_id", type="int")
    *            ),
    *        ),
    *    ),
    *      @OA\Response(
    *          response=204,
    *          description="Register Successfully",
    *          @OA\JsonContent()
    *       ),
    *      @OA\Response(response=400, description="Bad request"),
    * )
    */
    public function store(Request $request)
    {
        try {

            $response = ClassRoom::create([
                'name' => $request->name,
                'student_id' => $request->student_id,
                'teacher_id' => $request->teacher_id
            ]);
            return $this->success(['result' => $response]);

        } catch (\Throwable $th) {
            
            return $this->error($th, 400);
            
        }
    }

    /**
    * @OA\Get(
    * path="/api/class_room/show/{id}",
    * security={ {"bearerToken":{}} },
    * operationId="SearchClassById",
    * tags={"Class"},
    *      @OA\Parameter(
    *          name="id",
    *          description="Class id",
    *          required=true,
    *          in="path",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    * summary="Search Class",
    * description="Return one Class",
    *      @OA\Response(
    *          response=200,
    *          description="Register Successfully",
    *          @OA\JsonContent()
    *       ),
    *      @OA\Response(response=404, description="Resource Not Found"),
    * )
    */
    public function show($id)
    {
        $response = ClassRoom::with('student', 'teacher')->find($id);
        return $this->IsEmptyOrNo($response);
    }


    /**
    * @OA\Post(
    * path="/api/class_room/find_by_class_name",
    * security={ {"bearerToken":{}} },
    * operationId="SearchClassByName",
    * tags={"Class"},
    * summary="Search class by name",
    * description="Create Class",
    *     @OA\RequestBody(
    *         @OA\JsonContent(),
    *         @OA\MediaType(
    *            mediaType="multipart/form-data",
    *            @OA\Schema(
    *               type="object",
    *               required={"name"},
    *               @OA\Property(property="name", type="text")
    *            ),
    *        ),
    *    ),
    *      @OA\Response(
    *          response=204,
    *          description="Register Successfully",
    *          @OA\JsonContent()
    *       ),
    *      @OA\Response(response=400, description="Bad request"),
    * )
    */
    public function find_by_class_name(Request $request)
    {
        $response = ClassRoom::with('student', 'teacher')->where('name', $request->name)->get();
        return $this->IsEmptyOrNo($response);
    }


     /**
    * @OA\Put(
    * path="/api/class_room/update/{id}",
    * security={ {"bearerToken":{}} },
    * operationId="UpdateClass",
    * tags={"Class"},
    * summary="Update class",
    *      @OA\Parameter(
    *          name="id",
    *          description="Class id",
    *          required=true,
    *          in="path",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    * description="Update Class",
    *     @OA\RequestBody(
    *         @OA\JsonContent(),
    *         @OA\MediaType(
    *            mediaType="multipart/form-data",
    *            @OA\Schema(
    *               type="object",
    *               required={"name","address", "created_by_user_id"},
    *               @OA\Property(property="name", type="text"),
    *               @OA\Property(property="address", type="text"),
    *               @OA\Property(property="created_by_user_id", type="int")
    *            ),
    *        ),
    *    ),
    *      @OA\Response(
    *          response=204,
    *          description="Register Successfully",
    *          @OA\JsonContent()
    *       ),
    *      @OA\Response(response=400, description="Bad request"),
    * )
    */
    public function update(Request $request, $id)
    {
        $class_room = ClassRoom::find($id);

        if (!$class_room) {

            return $this->error('Not Found', 404);
        }

        $result = $class_room->update([
            'name' => $request->name,
            'student_id' => $request->student_id,
            'teacher_id' => $request->teacher_id
        ]);

        return $this->success(['result' => $result]);
    }

    /**
     * @OA\Delete(
     *      path="/api/class_room/destroy/{id}",
     *      operationId="deleteClass",
     *      tags={"Class"},
     *      security={ {"bearerToken":{}} },
     *      summary="Delete existing class",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Class id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function destroy($id)
    {
        $class_room = ClassRoom::find($id);

        if (!$class_room) {

            return $this->error('Not Found', 404);

        } 

        $result = $class_room->delete();

        return $this->success(['result' => $result]);

    }
}
