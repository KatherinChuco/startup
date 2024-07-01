<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\Subdepartment;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deparments = Department::with(['superiorDepartment', 'subdepartments'])
        ->withCount('subdepartments')
        ->get();

        $deparmentsCleanUp = $deparments->map(function ($department) {
            return [
                'id' => $department->id,
                'department_name' => $department->department_name,
                'superior_department_name' => $department->superiorDepartment ? $department->superiorDepartment->department_name : 'Ninguno',
                'ambassador_name' => $department->ambassador_name ?? '-' ,
                'employee_count' => $department->employee_count,
                'level' => $department->level,
                'subdepartments_total' => $department->subdepartments_count
            ];
        });
        
        return response()->json($deparmentsCleanUp);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'department_name' => 'required|unique:departments|max:45',
            'superior_department_id' => 'nullable|exist:departments,id',
            'ambassador_name' => 'nullable',
            'employee_count' => 'required|integer|min:0',
            'level' => 'required|integer|min:0',
        ]);

        return Department::create($request->all());
    }


    public function show($id)
    {
        return Department::findOrFail($id);
    }


    public function update(Request $request, $id)
    {
        $department = Department::findOrFail($id);

        $request->validate([
            'department_name' => 'required|unique:departments|max:45',
            'superior_department_id' => 'nullable|exist:departments,id',
            'ambassador_name' => 'nullable',
            'employee_count' => 'required|integer|min:0',
            'level' => 'required|integer|min:0',
        ]);

        return $department->update($request->all());
    }


    public function destroy(int $id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return response()->json(['message' => 'Department deleted successfully']);
    }

    public function subdepartments(int $id)
    {
        $subdepartments = Deparment::where('superior_department_id', $id)->get();
        return response()->json($subdepartments);
    }
}

