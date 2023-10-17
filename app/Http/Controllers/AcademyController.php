<?php

namespace App\Http\Controllers;

use App\Models\Academy;
use Illuminate\Http\Request;

class AcademyController extends Controller
{
    public function store(Request $request)
    {
        $data =  $request->validate([
            'name' => 'required',
            'nim' => 'required|min:10|max:12',
            'email' => 'required|email',
            'phone_number' => 'required',
            'document' => 'required',
            'gender' => 'required',
            'year_of_enrollment' => 'required',
            'faculty' => 'required',
            'major' => 'required',
            'class' => 'required',
        ], [
            'name.unique' => 'nama sudah terdaftar',
            'nim.unique' => 'MIM sudah terdaftar',
            'email.unique' => 'email sudah terdaftar',
            'phone_number.unique' => 'nomor hp sudah terdaftar',
            'document.unique' => 'link document sudah ada di database',
        ]);

        $errorMessages = [];
        foreach (['name', 'nim', 'email', 'phone_number', 'document'] as $field) {
            $existingAcademy = Academy::where($field, $data[$field])->first();
            if ($existingAcademy) {
                $errorMessages[] = ucfirst($field) . ' sudah terdaftar';
            }
        }

        if ($errorMessages) {
            return response()->json([
                'status' => 422,
                'error' => 'Unprocessable Entity',
                'message' => implode(', ', $errorMessages),
            ], 422);
        }

        $totalRegistrations = Academy::count();

        $academy = new Academy();
        $academy->name = $data['name'];
        $academy->nim = $data['nim'];
        $academy->email = $data['email'];
        $academy->phone_number = $data['phone_number'];
        $academy->document = $data['document'];
        $academy->gender = $data['gender'];
        $academy->year_of_enrollment = $data['year_of_enrollment'];
        $academy->faculty = $data['faculty'];
        $academy->major = $data['major'];
        $academy->class = $data['class'];


        if ($totalRegistrations >= 2) {
            return response()->json([
                'status' => 422,
                'message ' => 'Kuota sudah penuh',
            ], 422);
        } else {
            $academy->save();
        }

        return response()->json([
            'status' => 200,
            'message ' => 'Pendaftaran Berhasil',
            'data' => $academy
        ], 200);
    }

    public function index()
    {
        $academies = Academy::all();
        return response()->json([
            'status' => 200,
            'message' => 'OK',
            'data' => $academies
        ], 200);
    }

    public function show($id)
    {
        $academies = Academy::find($id);
        if (!$academies) {
            return response()->json([
                'status' => 404,
                'message' => 'peserta tidak ada dalam database',
                'error' => 'Not Found'
            ], 404);
        }
        return response()->json([
            'status' => 200,
            'message' => 'OK',
            'data' => $academies
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $academy = Academy::find($id);

        if (!$academy) {
            return response()->json([
                'status' => 404,
                'message' => 'Peserta tidak ada dalam database',
            ], 404);
        }

        $data = $request->validate([
            'name' => 'sometimes|required',
            'nim' => 'sometimes|required',
            'email' => 'sometimes|required|email',
            'phone_number' => 'sometimes|required',
            'document' => 'sometimes|required',
            'gender' => 'sometimes|required',
            'year_of_enrollment' => 'sometimes|required',
            'faculty' => 'sometimes|required',
            'major' => 'sometimes|required',
            'class' => 'sometimes|required',
        ]);

        $academy->update($data);

        return response()->json([
            'status' => 200,
            'message' => 'Data berhasil diperbarui',
            'data' => $academy,
        ], 200);
    }


    public function destroy($id)
    {
        $academies = Academy::find($id);
        if (!$academies) {
            return response()->json([
                'status' => 404,
                'message' => 'peserta tidak ada dalam database',
            ]);
        }
        $academies->delete();
        return response()->json([
            'status' => 200,
            'message' => 'data berhasil dihapus',
        ]);
    }

    public function countdownQuota()
    {
        $totalRegistrations = Academy::count();
        $remainingQuota = 2 - $totalRegistrations;

        if ($remainingQuota == 0) {
            $remainingQuota = "Kuota sudah penuh";
        }

        return response()->json([
            'status' => 200,
            'message' => 'OK',
            'remaining_quota' => $remainingQuota,
        ], 200);
    }
}
