<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
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
        $doctors = Medico::all();

        if($doctors === []){
            return response()->json(['result' => ['message' => 'No Content']], Response::HTTP_NO_CONTENT);
        }

        return response()->json(['result' => ['doctors' => $doctors]], Response::HTTP_OK);
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

            return response()->json(['result' => ['message' => 'Doctor created successful.', 'doctor' => $doctor]], Response::HTTP_OK);

        }else{
            return response()->json(['result' => ['message' => 'Doctor Already Registered']], Response::HTTP_CONFLICT);
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
    public function show(string $id_cidade)
    {
        $doctors = Medico::where('cidades_id', $id_cidade)->get();
        if($doctors === []) {
            return response()->json(['result' => ['doctors' => 'No Content']], Response::HTTP_NO_CONTENT);
        }
        return response()->json(['result' => ['doctors' => $doctors]], Response::HTTP_OK);
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
