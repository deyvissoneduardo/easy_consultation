<?php

namespace App\Http\Controllers;

use App\Models\Cidades;

use App\Utils\RequestResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CidadesController extends Controller
{
    public function index()
    {
        $cities = DB::select('SELECT id, nome, estado FROM cidades ORDER BY id');
        if ($cities === []) {
            return RequestResponse::success([], 'No Content', Response::HTTP_NO_CONTENT);
        }
        return RequestResponse::success($cities, '');
    }

    public function show($id)
    {
    }

    public function create(Request $request)
    {
        try {
            $this->validate($request, [
                'nome' => 'required|string',
                'estado' => 'required|string',
            ]);

            $city = Cidades::where('nome', $request->nome)->first();

            if (!$city) {
                $city = Cidades::create([
                    'nome' => $request->nome,
                    'estado' => $request->estado,
                ]);
                return RequestResponse::success($city, '');
            } else {
                return RequestResponse::error('City Already Registered');
            }
        } catch (ValidationException $e) {
            return RequestResponse::error('Validation Error', $e->errors());
        } catch (\Exception $e) {
            return RequestResponse::error('Internal Server Error', $e, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
