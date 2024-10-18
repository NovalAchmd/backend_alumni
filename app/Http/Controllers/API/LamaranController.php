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

    public function CreateLamaran(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_alumni' => 'required|exists:alumni,id_alumni',
            'id_lowongan' => 'required|exists:lowongan,id_lowongan',
            'nama_pelamar' => 'required|string',
            'CV' => 'required|string',
            'transkrip_nilai' => 'required|string',
            'sertifikat' => 'required|string',
            'portopolio' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $lamaranData = $request->all();
        $lamaranData['status'] = 'pending'; // Set initial status to pending

        $lamaran = Lamaran::create($lamaranData);

        // Hide status in the response
        $lamaran = $lamaran->makeHidden(['status']);

        return response()->json(['message' => 'Lamaran created successfully', 'data' => $lamaran], 201);
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