<?php

namespace App\Http\Controllers;

use App\Models\Departament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartamentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departaments = Departament::all();

        return response()->json($departaments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'min:1', 'max:100']
        ];

        $validator = Validator::make($request->input(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        $departament = new Departament($request->input());
        $departament->save();

        return response()->json([
            'status' => true,
            'message' => 'Se a creado correctamente'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(Departament $departament)
    {
        return response()->json([
            'status' => true,
            'data' => $departament
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Departament $departament)
    {
        $rules = [
            'name' => ['required', 'string', 'min:1', 'max:100']
        ];

        $validator = Validator::make($request->input(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->all()
            ], 400);
        }

        $departament->update($request->input());

        return response()->json([
            'status' => true,
            'message' => 'Se a actualizado correctamente'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Departament $departament)
    {
        $departament->delete();

        return response()->json([
            'status' => true,
            'message' => 'Se a eliminado correctamente'
        ], 200);
    }
}
