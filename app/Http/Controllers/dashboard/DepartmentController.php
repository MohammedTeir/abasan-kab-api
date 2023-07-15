<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DepartmentController extends Controller
{
        /**
         * Store a newly created department in storage.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\JsonResponse
         */
        public function store(AddDepartmentRequest $request)
        {
        Department::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
            ]);

            return response()->json([
                'message' => 'تم اٍضافة الدائرة بنجاح.',

            ], Response::HTTP_CREATED);
        }


            /**
             * Update the specified department in storage.
             *
             * @param  \App\Http\Requests\UpdateDepartmentRequest  $request
             * @param  \App\Models\Department  $department
             * @return \Illuminate\Http\JsonResponse
             */
            public function update(UpdateDepartmentRequest $request, Department $department)
            {
                $department->update([
                    'name' => $request->input('name'),
                    'description' => $request->input('description'),
                ]);

                return response()->json([
                    'message' => 'تم تحديث الدائرة بنجاح.',
                    'data' => $department,
                ], Response::HTTP_OK);
            }

            /**
             * Remove the specified department from storage.
             *
             * @param  \App\Models\Department  $department
             * @return \Illuminate\Http\JsonResponse
             */
            public function destroy(Department $department)
            {
                $department->delete();

                return response()->json([
                    'message' => 'تم حذف الدائرة بنجاح.',
                ], Response::HTTP_OK);
            }

            /**
             * Display a listing of the departments.
             *
             * @return \Illuminate\Http\Response
             */
            public function index()
            {
                $departments = Department::all();

                return response()->view('departments.departmentlist',compact('departments'));
            }
}
