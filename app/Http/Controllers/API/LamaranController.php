<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Lamaran;


class LamaranController extends Controller
{
    public function Lamaran()
    {
        $lamaran = Lamaran::with(['alumni:id_alumni,nama', 'lowongan:id_lowongan,judul_lowongan'])
                          ->get()
                          ->makeHidden(['status']); // Hide status for all applications
        return response()->json(['data' => $lamaran], 200);
    }

    public function createLamaran(Request $request, $idLowongan)
{
    // Check if user is authenticated
    $user = auth()->user();
    if (!$user) {
        return response()->json(['message' => 'User not authenticated'], 401);
    }

    // Retrieve alumni data linked to the authenticated user
    $alumni = $user->alumni;
    if (!$alumni) {
        return response()->json(['message' => 'Alumni data not found for this user'], 404);
    }

    // Validate the request data
    $validator = Validator::make($request->all(), [
        'nama_pelamar' => 'required|string',
        'email' => 'required',
        'CV' => 'required|file|mimes:pdf,doc,docx|max:2048',
        'transkrip_nilai' => 'required|file|mimes:pdf,doc,docx|max:2048',
        'sertifikat' => 'required|file|mimes:pdf,doc,docx|max:2048',
        'portopolio' => 'required|file|mimes:pdf,doc,docx|max:2048',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Handle file uploads
    $cvPath = $request->file('CV')->store('lamaran_photos', 'public');
    $transkripPath = $request->file('transkrip_nilai')->store('lamaran_photos', 'public');
    $sertifikatPath = $request->file('sertifikat')->store('lamaran_photos', 'public');
    $portofolioPath = $request->file('portopolio')->store('lamaran_photos', 'public');

    // Create lamaran data
    $lamaran = Lamaran::create([
        'id_alumni' => $alumni->id_alumni,
        'id_lowongan' => $idLowongan,
        'nama_pelamar' => $request->nama_pelamar,
        'email' => $request->email,
        'CV' => $cvPath,
        'transkrip_nilai' => $transkripPath,
        'sertifikat' => $sertifikatPath,
        'portopolio' => $portofolioPath,
        'status' => 'pending', // Set default status
    ]);

    // Hide status in the response
    $lamaran->makeHidden(['status']);

    return response()->json([
        'message' => 'Lamaran created successfully',
        'data' => $lamaran
    ], 201);
}

    
    public function MelihatLamaran($id_lamaran)
    {
        $lamaran = Lamaran::with(['alumni:id_alumni,nama', 'lowongan:id_lowongan,judul_lowongan'])
                          ->find($id_lamaran);
        
        if (!$lamaran) {
            return response()->json(['message' => 'Lamaran not found'], 404);
        }

        // Show status only if it's not 'pending'
        if ($lamaran->status === 'pending') {
            $lamaran = $lamaran->makeHidden(['status']);
        }

        return response()->json(['data' => $lamaran], 200);
    }

    public function UpdateLamaran(Request $request, $id_lamaran)
    {
        $user = auth()->user();
    if (!$user) {
        return response()->json(['message' => 'User not authenticated'], 401);
    }

    // Retrieve alumni data linked to the authenticated user
    $admin = $user->admin;
    if (!$admin) {
        return response()->json(['message' => 'admin data not found for this user'], 404);
    }
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:terima,tolak',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $lamaran = Lamaran::find($id_lamaran);

        if (!$lamaran) {
            return response()->json(['message' => 'Lamaran not found'], 404);
        }

        $lamaran->update($request->only('status'));

        return response()->json(['message' => 'Lamaran status updated successfully', 'data' => $lamaran], 200);
    }

    public function DeleteLamaran($id_lamaran)
    {
        $lamaran = Lamaran::find($id_lamaran);

        if (!$lamaran) {
            return response()->json(['message' => 'Lamaran not found'], 404);
        }

        $lamaran->delete();

        return response()->json(['message' => 'Lamaran deleted successfully'], 200);
    }
}