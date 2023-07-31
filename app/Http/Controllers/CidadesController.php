<?php

namespace App\Http\Controllers;

use App\Models\Cidades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CidadesController extends Controller
{
    public function index()
    {
        $cities = DB::select('SELECT nome, estado FROM cidades ORDER BY nome');
        if($cities === []){
            return response()->json(['result' => ['message' => 'No Content']], 204);
        }
        return response()->json(['result' => ['cities' => $cities]], 200);
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

            return response()->json(['result' => ['message' => 'City created successful.', 'city' => $city]], 201);

        }else{
            return response()->json(['result' => ['message' => 'City Already Registered']], 409);
        }
    }

}
