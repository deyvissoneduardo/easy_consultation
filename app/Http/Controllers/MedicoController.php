<?php

namespace App\Http\Controllers;

use App\Models\Medico;
use App\Utils\RequestResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class MedicoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index']]);
    }

    public function index()
    {
        $doctors = DB::table('medico')
            ->selectRaw('medico.nome as medico, medico.especialidade, cidades.nome as cidade')
            ->join('cidades', 'medico.cidades_id', '=', 'cidades.id')
            ->get();

        if ($doctors === []) {
            return RequestResponse::success([], 'No Content', Response::HTTP_NO_CONTENT);
        }

        return response()->json(['result' => ['doctors' => $doctors]], Response::HTTP_OK);
    }

    public function create(Request $request)
    {
        try {
            $this->validate($request, [
                'nome' => 'required|string',
                'especialidade' => 'required|string',
                'cidades_id' => 'required|integer|exists:cidades,id',
            ]);

            $doctor = Medico::where('nome', $request->nome)->first();
            if (!$doctor) {
                $doctor = new Medico();
                $doctor->nome = $request->nome;
                $doctor->especialidade = $request->especialidade;
                $doctor->cidades_id = $request->cidades_id;
                $doctor->save();

                return RequestResponse::success($doctor, '');
            } else {
                return RequestResponse::error('Doctor Already Registered');
            }
        } catch (ValidationException $e) {
            return RequestResponse::error('Validation Error', $e->errors());
        } catch (\Exception $e) {
            return RequestResponse::error('Internal Server Error', $e, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(string $id_cidade)
    {
        try {
            $doctors = DB::table('medico')
                ->selectRaw('medico.nome as medico, medico.especialidade, cidades.nome as cidade')
                ->join('cidades', 'medico.cidades_id', '=', 'cidades.id')
                ->where('cidades.id', $id_cidade)
                ->get();

            if ($doctors->isEmpty()) {
                return RequestResponse::success([], 'No Content', Response::HTTP_NO_CONTENT);
            }
            return RequestResponse::success($doctors, '');
        } catch (\Exception $e) {
            return RequestResponse::error('Internal Server Error', $e, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
