<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
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
        // $alumni = Alumni::select('nama_alumni', 'nim', 'angkatan', 'tanggal_lahir', 'alamat', 'email','foto', 'status');
        $alumni = Alumni::all();
        foreach ($alumni as $al) {
            $al->Alumni;
        }
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
        try{
            $validator = Validator::make($request->all(), [
                // 'user_id' => 'required|exists:users,id',
                'nama_alumni' => 'required|string|max:255',
                'nim' => 'required|string|max:10',
                'angkatan' => 'required|string',
                'tanggal_lahir' => 'required|date',
                'alamat' => 'required|string',
                'no_tlp' => 'required|string',
                'email' => 'required|email|unique:alumni',
                'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'status' => 'required|in:aktif,pasif',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
    
            $fotoPath = $request->file('foto')->store('alumni_photos', 'public');
    
            $alumni = Alumni::create([
                // 'user_id' => $request->user_id,
                'nama_alumni' => $request->nama_alumni,
                'angkatan' => $request->angkatan,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'no_tlp' => $request->no_tlp,
                'email' => $request->email,
                'foto' => $fotoPath,
                'status' => $request->status,
            ]);
    
            return response()->json(['data' => $alumni, 'message' => 'Alumni created successfully'], 201);
        }catch(\Exception $e) {
            Log::error('Error retrieving report: ' . $e->getMessage());

            return response()->json([
                'message' => 'Tidak berhasil membuat alumni',
            ], 500);
        }
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
        return response()->json(['data' => $alumni], 200);
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
    $user = auth()->user();
    $alumni = $user->alumni;

    if (!$alumni) {
        return response()->json(['message' => 'Alumni data not found for this user'], 404);
    }

    try {
        // Validate input data
        $validator = Validator::make($request->all(), [
            'nama_alumni' => 'nullable|string|max:255',
            'angkatan' => 'nullable|string',
            'no_tlp' => 'nullable|string',
            'email' => 'nullable|email|unique:alumni,email,' . $alumni->id_alumni . ',id_alumni',
            'alamat' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Prepare data for update
        $dataToUpdate = [
            'nama_alumni' => $request->nama_alumni ?? $alumni->nama_alumni,
            'angkatan' => $request->angkatan ?? $alumni->angkatan,
            'no_tlp' => $request->no_tlp ?? $alumni->no_tlp,
            'email' => $request->email ?? $alumni->email,
            'alamat' => $request->alamat ?? $alumni->alamat,
            'tanggal_lahir' => $request->tanggal_lahir ?? $alumni->tanggal_lahir,
            
        ];

        // Handle photo upload if provided
        if ($request->hasFile('foto')) {
            // Delete the old photo if it exists
            if ($alumni->foto) {
                Storage::disk('public')->delete($alumni->foto);
            }
            // Save the new photo and update its path
            $dataToUpdate['foto'] = $request->file('foto')->store('alumni_photos', 'public');
        } else {
            // If no new photo is provided, retain the old photo
            $dataToUpdate['foto'] = $alumni->foto;
        }

        // Update the alumni data
        $alumni->update($dataToUpdate);

        return response()->json([
            'data' => $alumni,
            'message' => 'Alumni updated successfully'
        ], 200);
    } catch (\Exception $e) {
        Log::error('Error updating alumni: ' . $e->getMessage());

        return response()->json([
            'message' => 'Tidak berhasil memperbarui alumni',
        ], 500);
    }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteAlumni(Request $request, $id)
{
    $alumni = Alumni::find($id);

    if (!$alumni) {
        return response()->json(['message' => 'Alumni tidak ditemukan'], 404);
    }

    // Tentukan data apa saja yang boleh dihapus berdasarkan input dari request
    $dataToUpdate = [];

    if ($request->has('hapus_foto')) {
        $dataToUpdate['foto'] = null;
        // Hapus foto di storage jika ada
        if ($alumni->foto) {
            Storage::disk('public')->delete($alumni->foto);
        }
    }

    if ($request->has('hapus_tanggal_lahir')) {
        $dataToUpdate['tanggal_lahir'] = null;
    }

    if ($request->has('hapus_alamat')) {
        $dataToUpdate['alamat'] = null;
    }

    if ($request->has('hapus_no_tlp')) {
        $dataToUpdate['no_tlp'] = null;
    }

    if ($request->has('hapus_email')) {
        $dataToUpdate['email'] = null;
    }

    // Update data tanpa menyentuh nim, id_user, id_alumni, dan status
    $alumni->update($dataToUpdate);

    return response()->json([
        'message' => 'Data alumni berhasil dihapus berdasarkan permintaan',
        'data' => $alumni
    ], 200);
}

}