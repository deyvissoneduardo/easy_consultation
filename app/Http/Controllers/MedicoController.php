<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use Illuminate\Http\Request;

class MedicoController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $doctor = Medico::where('nome', $request->nome)->first();
        if(!$doctor){
            $doctor = new Medico();
            $doctor->nome = $request->nome;
            $doctor->especialidade = $request->especialidade;
            $doctor->cidades_id = $request->cidades_id;
            $doctor->save();

            return response()->json(['message' => 'Doctor created successful.', 'user' => $doctor], 201);

        }else{
            return response()->json(['message' => 'Doctor Already Registered'], 409);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
