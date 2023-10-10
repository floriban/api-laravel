<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::select(
            'employees.*',
            'departaments.name as departament'
        )
            ->join('departaments', 'departaments.id', 'employees.departament_id')
            ->orderBy('employees.id')
            ->paginate(10);

        return response()->json($employees);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'min:1', 'max:100'],
            'email' => ['required', 'email', 'max:80'],
            'phone' => ['required', 'max:15'],
            'departament_id' => ['required', 'numeric']
        ];

        $validator = Validator::make($request->input(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        $employee = new Employee($request->input());
        $employee->save();

        return response()->json([
            'status' => true,
            'message' => 'Se a creado correctamente'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return response()->json([
            'status' => true,
            'data' => $employee
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $rules = [
            'name' => ['required', 'string', 'min:1', 'max:100'],
            'email' => ['required', 'email', 'max:80'],
            'phone' => ['required', 'max:15'],
            'departament_id' => ['required', 'numeric']
        ];

        $validator = Validator::make($request->input(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        $employee->update($request->input());

        return response()->json([
            'status' => true,
            'message' => 'Se a actualizado correctamente'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();

        return response()->json([
            'status' => true,
            'message' => 'Se a eliminado correctamente'
        ], 200);
    }

    public function EmployeeByDepartament()
    {
        $employees = Employee::select(
            DB::raw("COUNT(employees.id) as count"),
            'departaments.name'
        )
            ->rightJoin('departaments', 'departaments.id', 'employees.departament_id')
            ->groupBy('departaments.name')
            ->get();

        return response()->json($employees);
    }

    public function all()
    {
        $employees = Employee::select(
            'employees.*',
            'departaments.name as departament'
        )
            ->join('departaments', 'departaments.id', 'employees.departament_id')
            ->orderBy('employees.id')
            ->get();

        return response()->json($employees);
    }
}
