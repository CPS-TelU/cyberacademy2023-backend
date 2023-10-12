<?php

namespace App\Http\Controllers;

use App\Models\Assistant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AssistantController extends Controller
{
    public function register(Request $request){
        $data =  $request->validate([
            'name' => 'required',
            'assistant_code' => 'required',
            'email' => 'required',
            'password' => 'required',
        ],[
            'name.unique' => 'nama sudah terdaftar',
            'nim.unique' => 'MIM sudah terdaftar',
            'email.unique' => 'email sudah terdaftar',
        ]);

        $errorMessages = [];
        foreach (['name', 'assistant_code', 'email'] as $field) {
            $existingAssistant = Assistant::where($field, $data[$field])->first();
            if ($existingAssistant) {
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
        $assistant = new Assistant();
        $assistant->name = $data['name'];
        $assistant->assistant_code = $data['assistant_code'];
        $assistant->email = $data['email'];
        $assistant->password = $data['password'];
        $assistant->save();

        return response()->json([
            'status'=> 200,
            'message'=> 'OK',
            'data' => $assistant
        ],200);
    }
    public function login(Request $request)
    {
        $credentials =  $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = Assistant::where('email', $request->email)->first();
 
    if (! $credentials || ! Hash::check($request->password, $credentials->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }
 
    $token = 'Bearer '.$credentials->createToken('user login')->plainTextToken;
    return response()->json([
        'status'=> 200,
        'message'=> 'OK',
        'data' => $token
    ],200);
    
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}