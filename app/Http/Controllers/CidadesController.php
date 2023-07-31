<?php

namespace App\Http\Controllers;

use App\Models\Cidades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class CidadesController extends Controller
{
    public function index()
    {
        $cities = DB::select('SELECT nome, estado FROM cidades ORDER BY nome');
        if($cities === []){
            return response()->json(['result' => ['message' => 'No Content']], Response::HTTP_NO_CONTENT);
        }
        return response()->json(['result' => ['cities' => $cities]], Response::HTTP_OK);
    }

    public function show($id)
    {

    }

    public function create(Request $request)
    {
        $city = Cidades::where('nome', $request->nome)->first();
        if(!$city){
            $city = new Cidades();
            $city->nome = $request->nome;
            $city->estado = $request->estado;
            $city->save();

            return response()->json(['result' => ['message' => 'City created successful.', 'city' => $city]], Response::HTTP_OK);

        }else{
            return response()->json(['result' => ['message' => 'City Already Registered']], Response::HTTP_CONFLICT);
        }
    }

}
