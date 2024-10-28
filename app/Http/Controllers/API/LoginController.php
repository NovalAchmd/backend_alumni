<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /**
     * Handle user login requests.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        try {
            
            $validator = Validator::make($request->all(), [
                'nomor_induk' => 'required|string',
                'password' => 'required|string|min:8', 
            ]);

            // Return validation errors if validation fails
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            // Retrieve user by nomor_induk
            $user = User::where('nomor_induk', $request->nomor_induk)->first();

            // Check if user exists
            if (!$user) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Nomor induk tidak ditemukan',
                ], 401);
            }

            // Verify the provided password
            if (!Hash::check($request->password, $user->password)) {
                return response()->json([
                    'status' => 401,
                    'message' => 'Password anda salah',
                ], 401);
            }

            
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Login anda Berhasil',
                'status' => 200,
                'user' => $user,
                'token' => $token,
            ], 200);
        } catch (\Throwable $t) {

            Log::error('Error during login: ' . $t->getMessage(), [
                'exception' => $t,
                'request' => $request->all(),
            ]);
            return response()->json([
                'error' => 'Terjadi kesalahan pada server',
                'message' => 'Internal Server Error', 
            ], 500);
        }
    }
}
