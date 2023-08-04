<?php

namespace App\Http\Controllers;

use App\Http\Requests\PatientRegisterRequest;
use App\Http\Requests\PatientUpdateRequest;
use App\Models\Medico;
use App\Models\Paciente;
use App\Utils\RequestResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class PacienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $patients = Paciente::all();

        if ($patients->isEmpty()) {
            return RequestResponse::success('No Content');
        }
        return RequestResponse::success($patients);
    }

    public function create(PatientRegisterRequest $request)
    {
        try {
            $patient = Paciente::create([
                'nome' => $request->nome,
                'cpf' => $request->cpf,
                'celular' => $request->celular,
            ]);

            return RequestResponse::success($patient);
        } catch (ValidationException $e) {
            return RequestResponse::error('Validation Error', $e->errors());
        } catch (\Exception $e) {
            return RequestResponse::error('Internal Server Error', $e, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(string $id)
    {
        try {
            $patient = Paciente::find($id);

            if (!$patient) {
                return RequestResponse::error([], 'Patient Not Found', Response::HTTP_NOT_FOUND);
            }

            return RequestResponse::success($patient);
        } catch (\Exception $e) {
            return RequestResponse::error('Internal Server Error', $e, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(PatientUpdateRequest $request, string $id)
    {
        try {
            if (!$id) {
                return RequestResponse::error([], 'Bad Request');
            }

            $patient = Paciente::find($id);
            if (!$patient) {
                return RequestResponse::error([], 'Patient Not Found', Response::HTTP_NOT_FOUND);
            }

            $patient->nome = $request->nome;
            $patient->celular = $request->celular;
            $patient->save();

            return RequestResponse::success($patient);
        } catch (\Exception $e) {
            return RequestResponse::error('Internal Server Error', $e, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(string $id)
    {
        try {
            $patient = Paciente::find($id);

            if (!$patient) {
                return RequestResponse::error([], 'Patient Not Found', Response::HTTP_NOT_FOUND);
            }

            $patient->delete();

            return RequestResponse::success([], 'Patient deleted successfully');
        } catch (\Exception $e) {
            return RequestResponse::error('Internal Server Error', $e, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getPatinentByDoctor($id_medico)
    {
        try {
            $doctor = Medico::findOrFail($id_medico);
            $patients = $doctor->patient;

            if($patients === null){
                return RequestResponse::success('No Content');
            }

            return RequestResponse::success($patients);
        } catch (\Exception $e) {
            return RequestResponse::error('Erro ao obter pacientes vinculados ao médico', $e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
