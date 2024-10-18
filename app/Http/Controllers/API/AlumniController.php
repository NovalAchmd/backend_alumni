<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alumni;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Stmt\Catch_;

class AlumniController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Alumni()
    {
        $alumni = Alumni::select('nama_alumni', 'nim', 'angkatan', 'tanggal_lahir', 'alamat', 'email','foto', 'status',);
        return response()->json(['data' => $alumni], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function CreateAlumni(Request $request)
{   
    $validator = Validator::make($request->all(), [
        'nama_alumni' => 'required|string|max:255',
        'nim' => 'required|string|max:10|unique:alumni',
        'angkatan' => 'required|string',
        'tanggal_lahir' => 'nullable|date',
        'alamat' => 'nullable|string',
        'no_tlp' => 'required|string',
        'email' => 'required|email|unique:alumni',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $alumniData = $request->only([
        'user_id', 'nama_alumni', 'nim', 'angkatan', 'tanggal_lahir',
        'alamat', 'no_tlp', 'email', 'status'
    ]);

    // Set default values for nullable fields
    $alumniData['tanggal_lahir'] = $request->tanggal_lahir ?? null;
    $alumniData['alamat'] = $request->alamat ?? null;
    $alumniData['status'] = $request->status ?? 'aktif';

    if ($request->hasFile('foto')) {
        $fotoPath = $request->file('foto')->store('alumni_photos', 'public');
        $alumniData['foto'] = $fotoPath;
    }

    $alumni = Alumni::create($alumniData);

    return response()->json(['data' => $alumni, 'message' => 'Alumni created successfully'], 201);
}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function MelihatAlumni($id)
    {
        $alumni = Alumni::find($id);
        if (!$alumni) {
            return response()->json(['message' => 'Alumni not found'], 404);
        }
        return response()->json(['data' => 'nama_alumni', 'nim', 'angkatan', 'tanggal_lahir', 'alamat', 'email','foto', 'status'], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function UpdateAlumni(Request $request)
{
    // Mendapatkan user yang sedang login
    $user = auth()->user();
    
    // Memastikan bahwa user yang login memiliki data alumni
    $alumni = $user->alumni; // ini sudah benar jika relasi alumni sudah benar
    if (!$alumni) {
        return response()->json(['message' => 'Alumni data not found for this user'], 404);
    }

    // Validasi data (semua field adalah opsional)
    $validator = Validator::make($request->all(), [
        'name' => 'nullable|string|max:255',
        'angkatan' => 'nullable|string',
        'no_hp' => 'nullable|string',
        'email' => 'nullable|email|unique:alumni,email,' . $alumni->id_alumni . ',id_alumni',
        'tanggal_lahir' => 'nullable|date', // Validasi untuk tanggal lahir
        'alamat' => 'nullable|string|max:255', // Validasi untuk alamat
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Validasi untuk foto (optional)
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Siapkan data untuk update
    $updateData = [];

    // Hanya tambahkan field yang disertakan dalam permintaan
    if ($request->has('name')) {
        $updateData['nama_alumni'] = $request->name;
    }
    if ($request->has('angkatan')) {
        $updateData['angkatan'] = $request->angkatan;
    }
    if ($request->has('no_hp')) {
        $updateData['no_tlp'] = $request->no_hp;
    }
    if ($request->has('email')) {
        $updateData['email'] = $request->email;
    }
    if ($request->has('tanggal_lahir')) {
        $updateData['tanggal_lahir'] = $request->tanggal_lahir;
    }
    if ($request->has('alamat')) {
        $updateData['alamat'] = $request->alamat;
    }
    if ($request->hasFile('foto')) {
        // Simpan foto dan tambahkan path ke updateData
        $updateData['foto'] = $request->file('foto')->store('uploads/foto', 'public');
    }

    // Perbarui data alumni dengan data yang ada di $updateData
    $alumni->update($updateData); // ini seharusnya tidak bermasalah

    return response()->json([
        'data' => $alumni,
        'message' => 'Alumni updated successfully'
    ], 200);
}



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteAlumni($id)
    {
        $alumni = Alumni::find($id);
        if (!$alumni) {
            return response()->json(['message' => 'Alumni not found'], 404);
        }

        // Delete photo file
        if ($alumni->foto) {
            Storage::disk('public')->delete($alumni->foto);
        }

        $alumni->delete();
        return response()->json(['message' => 'Alumni deleted successfully'], 200);
    }
}