<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;


class StudentController extends Controller
{
    use ApiResponser;

     /**
    * @OA\Get(
    * path="/api/student/index",
    * security={ {"bearerToken":{}} },
    * operationId="ListStudents",
    * tags={"Student"},
    * summary="List Students",
    * description="Return all Students",
    *      @OA\Response(
    *          response=200,
    *          description="Register Successfully",
    *          @OA\JsonContent()
    *       ),
    *      @OA\Response(response=401, description="Resource Not Found"),
    * )
    */
    public function index()
    {
        $response = Student::all();
        return $this->success(['result' => $response]);
    }

    /**
    * @OA\Post(
    * path="/api/student/store",
    * security={ {"bearerToken":{}} },
    * operationId="StoreStudent",
    * tags={"Student"},
    * summary="StoreStudent",
    * description="Create Students",
    *     @OA\RequestBody(
    *         @OA\JsonContent(),
    *         @OA\MediaType(
    *            mediaType="multipart/form-data",
    *            @OA\Schema(
    *               type="object",
    *               required={"name","address", "created_by_user_id", "age"},
    *               @OA\Property(property="name", type="text"),
    *               @OA\Property(property="address", type="text"),
    *               @OA\Property(property="age", type="text"),
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
    public function store(Request $request)
    {
        try {

            $response = Student::create([
                'created_by_user_id' => $request->created_by_user_id,
                'name' => $request->name,
                'address' => $request->address,
                'age' => $request->age
            ]);
            return $this->success(['result' => $response]);

        } catch (\Throwable $th) {
            return $this->error($th, 400);

        }
    }

    /**
    * @OA\Get(
    * path="/api/student/show/{id}",
    * security={ {"bearerToken":{}} },
    * operationId="SearchStudents",
    * tags={"Student"},
    *      @OA\Parameter(
    *          name="id",
    *          description="Students id",
    *          required=true,
    *          in="path",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    * summary="Search student",
    * description="Return one student",
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
        $response = Student::with('createdByUserId', 'classRoom')->find($id);
        return $this->IsEmptyOrNo($response);
    }


    /**
    * @OA\Put(
    * path="/api/student/update/{id}",
    * security={ {"bearerToken":{}} },
    * operationId="UpdateStudent",
    * tags={"Student"},
    * summary="UpdateStudent",
    *      @OA\Parameter(
    *          name="id",
    *          description="Student id",
    *          required=true,
    *          in="path",
    *          @OA\Schema(
    *              type="integer"
    *          )
    *      ),
    * description="Update Student",
    *     @OA\RequestBody(
    *         @OA\JsonContent(),
    *         @OA\MediaType(
    *            mediaType="multipart/form-data",
    *            @OA\Schema(
    *               type="object",
    *               required={"name","address", "created_by_user_id", "age"},
    *               @OA\Property(property="name", type="text"),
    *               @OA\Property(property="address", type="text"),
    *               @OA\Property(property="age", type="text"),
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
        try {

            $student = Student::find($id);
    
            if (!$student) {
    
                return $this->error('Not Found', 404);
            }
    
            $result = $student->update([
                'created_by_user_id' => $request->created_by_user_id,
                'name' => $request->name,
                'address' => $request->address,
                'age' => $request->age
            ]);
    
            return $this->success(['result' => $result]);

        } catch (\Throwable $th) {
            
            return $this->error($th, 400);
            
        }
    }

     /**
     * @OA\Delete(
     *      path="/api/student/destroy/{id}",
     *      operationId="deleteStudent",
     *      tags={"Student"},
     *      security={ {"bearerToken":{}} },
     *      summary="Delete existing Student",
     *      description="Deletes a record and returns no content",
     *      @OA\Parameter(
     *          name="id",
     *          description="Student id",
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
        $student = Student::find($id);

        if (!$student) {

            return $this->error('Not Found', 404);

        } 

        $result = $student->delete();

        return $this->success(['result' => $result]);
    }
}
