<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherStoreRequest;
use App\Http\Requests\TeacherUpdateRequest;
use App\Models\Teacher;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;


/**
 * @OA\SecurityScheme(
 *  type="http",
 *  description="Acess token obtido na autenticação",
 *  name="Authorization",
 *  in="header",
 *  scheme="bearer",
 *  bearerFormat="JWT",
 *  securityScheme="bearerToken"
 * )
 */

class TeacherController extends Controller
{

    use ApiResponser;
    
    /**
    * @OA\Get(
    * path="/api/teacher/index",
    * security={ {"bearerToken":{}} },
    * operationId="ListTeachers",
    * tags={"Teacher"},
    * summary="List teacher",
    * description="Return all teacher",
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
        $response = Teacher::all();
        return $this->success(['result' => $response]);
    }
    
    /**
    * @OA\Post(
    * path="/api/teacher/store",
    * security={ {"bearerToken":{}} },
    * operationId="Store",
    * tags={"Teacher"},
    * summary="Store",
    * description="Create teacher",
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
    public function store(TeacherStoreRequest $teacherStoreRequest)
    {
        try {

            $response = Teacher::create([
                'created_by_user_id' => $teacherStoreRequest->created_by_user_id,
                'name' => $teacherStoreRequest->name,
                'address' => $teacherStoreRequest->address
            ]);
            return $this->success(['result' => $response]);

        } catch (\Throwable $th) {
            
            return $this->error($th, 404);

        }
    }

        /**
    * @OA\Get(
    * path="/api/teacher/show/{id}",
    * security={ {"bearerToken":{}} },
    * operationId="SearchTeacher",
    * tags={"Teacher"},
    *      @OA\Parameter(
    *          name="id",
    *          description="Teacher id",
    *          required=true,
    *          in="path",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    * summary="Search teacher",
    * description="Return one teacher",
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
        $response = Teacher::with('createdByUserId', 'classRoom')->find($id);
        return $this->IsEmptyOrNo($response);
    }

    /**
    * @OA\Put(
    * path="/api/teacher/update/{id}",
    * security={ {"bearerToken":{}} },
    * operationId="Update",
    * tags={"Teacher"},
    * summary="Update",
    *      @OA\Parameter(
    *          name="id",
    *          description="Teacher id",
    *          required=true,
    *          in="path",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    * description="Update teacher",
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
    public function update(TeacherUpdateRequest $request, $id)
    {
        $teacher = Teacher::find($id);

        if (!$teacher) {

            return $this->error('Not Found', 404);
        }

        $result = $teacher->update([
            'created_by_user_id' => $request->created_by_user_id,
            'name' => $request->name,
            'address' => $request->address
        ]);

        return $this->success(['result' => $result]);
    }

     /**
     * @OA\Delete(
     *      path="/api/teacher/destroy/{id}",
     *      operationId="deleteTeacher",
     *      tags={"Teacher"},
     *      security={ {"bearerToken":{}} },
     *      summary="Delete existing teacher",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Teacher id",
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
        $teacher = Teacher::find($id);

        if (!$teacher) {

            return $this->error('Not Found', 404);

        } 

        $result = $teacher->delete();

        return $this->success(['result' => $result]);

    }
}
