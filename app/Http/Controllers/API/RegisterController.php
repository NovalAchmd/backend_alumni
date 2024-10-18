<?php

namespace App\Http\Controllers\API;

use App\Models\Admin;
use App\Models\Alumni;
use App\Models\Perusahaan;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /**
     * Handle the registration of new users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // Set validation rules
        $validator = Validator::make($request->all(), [
            'role' => 'required|integer|in:0,1,2',
            'name' => 'required|string|max:255',
            'nomor_induk' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Create specific models based on user role
        if ($request->role == '0') { // Admin
            response()->json([
                'status' => '409',
                'success' => false,
            ], 409);
            $user = User::create([
                'role' => $request->role,
                'name'      => $request->name,
                'nomor_induk'     => $request->nomor_induk,
                'password'  => bcrypt($request->password)
            ]);
            $admin = Admin::create([
                'user_id' => $user->id,
                'nama' => $request->name,
                'no_induk' => $request->nomor_induk,
                'no_hp' => $request->no_hp,
            ]);
            return response()->json(['status' => 201, 'success' => true, 'user' => $user, 'admin' => $admin], 201);
        } elseif ($request->role == '1') { // Mahasiswa (Alumni)
            $user = User::create([
                'role'       => $request->role,
                'name'       => $request->name,
                'nomor_induk'=> $request->nomor_induk,
                'password'   => bcrypt($request->password),
                'email'      => $request->email
            ]);
            $alumni = Alumni::create([
                'user_id' => $user->id,
                'nim' => $request->nomor_induk, // Use nomor_induk as nim
                'nama_alumni' => $request->name,
                'angkatan' => $request->angkatan ?? null, // Add angkatan if available
                'no_tlp' => $request->no_hp,
                'email' => $request->email ?? null, // Add email if available
            ]);
            return response()->json(['status' => 201, 'success' => true, 'user' => $user, 'alumni' => $alumni], 201);
        } elseif ($request->role == '2') { // Perusahaan
            $user = User::create([
                'role' => $request->role,
                'name'      => $request->name,
                'nomor_induk'     => $request->nomor_induk,
                'password'  => bcrypt($request->password)
            ]);
            $perusahaan = Perusahaan::create([
                'user_id' => $user->id,
                'nib' => $request->nomor_induk, // Use nomor_induk as NIB
                'nama_perusahaan' => $request->name,
                'sektor_bisnis' => $request->sektor_bisnis,
                'alamat' => $request->alamat,
                'email_perusahaan' => $request->email,
                'website_perusahaan' => $request->website_perusahaan,
                'foto' => $request->foto ?? null, // Add foto if available
                'no_tlp' => $request->no_hp,
                'status' => 'mengunggu', // Set default status
            ]);
            return response()->json(['status' => 201, 'success' => true, 'user' => $user, 'perusahaan' => $perusahaan], 201);
        }

        // Return a response if no valid role is provided
        return response()->json(['status' => 409, 'success' => false], 409);
    }
}