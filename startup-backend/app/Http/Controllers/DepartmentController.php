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
        return Department::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'ambassador_name' => 'nullable',
            'employee_count' => 'required|integer|min:0',
            'level' => 'required|integer|min:0',
        ]);

        return Department::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(number $department)
    {
        return Department::findOrFail($department->id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $department = Department::findOrFail($id);

        $request->validate([
            'department_name' => 'required|unique:departments|max:45',
            'ambassador_name' => 'nullable',
            'employee_count' => 'required|integer|min:0',
            'level' => 'required|integer|min:0',
        ]);

        $department->update($request->all());

        return $department;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $department = Department::findOrFail($departmen->id);
        $department->delete();

        return response()->json(['message' => 'Department deleted successfully']);
    }

    public function subdepartments($id)
    {
        $subdepartments = Subdepartment::where('parent_department_id', $id)->get();
        return $subdepartments;
    }
}

