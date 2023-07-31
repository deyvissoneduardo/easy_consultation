<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class PacienteController extends Controller
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
        $patient = Paciente::where('nome', $request->nome)->first();
        if(!$patient){
            $patient = new Paciente();
            $patient->nome = $request->nome;
            $patient->cpf = $request->cpf;
            $patient->celular = $request->celular;
            $patient->save();

            return response()->json(['result' =>
                ['message' => 'Patient created successful.', 'patient' => $patient]],
                Response::HTTP_OK);

        }else{
            return response()->json(['result' => ['message' => 'Patient Already Registered']],
             Response::HTTP_CONFLICT);
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
        if (!$id) {
            return response()->json(['result' => ['message' => 'Bad Request']], Response::HTTP_BAD_REQUEST);
        }

        $patient = Paciente::find($id);
        if($patient != null){
            $patient->nome = $request->nome;
            $patient->celular = $request->celular;
            $patient->save();

            return response()->json(['result' =>
            ['message' => 'Patient updated successful.', 'patient' => $patient]],
            Response::HTTP_OK);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
