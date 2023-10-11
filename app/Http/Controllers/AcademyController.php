<?php

namespace App\Http\Controllers;

use App\Models\Academy;
use Illuminate\Http\Request;

class AcademyController extends Controller
{
    public function store(Request $request){
        $data =  $request->validate([
            'name' => 'required',
            'nim' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
            'document' => 'required',
            'gender' => 'required',
            'year_of_enrollment' => 'required',
            'faculty' => 'required',
            'major' => 'required',
            'class' => 'required',
        ],[
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
        $academy->save();

        $totalRegistrations = Academy::count();

        if ($totalRegistrations >= 80) {
            return response()->json([
                'status' => 422,
                'message ' => 'Unprocessable entity',
            ],422);
        }
        return response()->json([
            'status' => 200,
            'message ' => 'Pendaftaran Berhasil',
            'data' => $academy
        ],200);
    }

    public function index(){
        $academies = Academy::all();
        return response()->json([
            'status' => 200,
            'message'=> 'OK',
            'data' => $academies
        ],200);
    }

    public function show($id){
        $academies = Academy::find($id);
        if (!$academies){
            return response()->json([
                'status'=> 404,
                'message'=> 'peserta tidak ada dalam database',
                'error' => 'Not Found'
            ], 404);
        }
        return response()->json([
            'status'=> 200,
            'message'=> 'OK',
            'data' => $academies
        ],200);
    }
}
