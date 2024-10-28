<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Pertanyaan;
use App\Models\Data_jawaban;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PertanyaanController extends Controller
{
    public function Pertanyaan()
    {
        $pertanyaan = Pertanyaan::all();
        return response()->json(['data' => $pertanyaan], 200);
    }

    public function createPertanyaan(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'jenis' => 'required|in:terbuka,skala',
        ]);

        $pertanyaan = Pertanyaan::create([
            'pertanyaan' => $request->pertanyaan,
            'jenis' => $request->jenis,
        ]);

        return response()->json(['message' => 'Pertanyaan berhasil dibuat', 'data' => $pertanyaan], 201);
    }


public function MelihatPertanyaan($id)
{
    $pertanyaan = Pertanyaan::
                            where('id_pertanyaan', $id) 
                            ->first();

    if (!$pertanyaan) {
        return response()->json(['message' => 'Pertanyaan not found'], 404);
    }

    return response()->json(['data' => $pertanyaan], 200);
}


    public function UpdatePertanyaan(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'pertanyaan' => 'required|string',
            'jenis' => 'required|in:terbuka,skala',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $pertanyaan = Pertanyaan::find($id);

        if (!$pertanyaan) {
            return response()->json(['message' => 'Pertanyaan not found'], 404);
        }

        $pertanyaan->update($request->all());

        return response()->json(['message' => 'Pertanyaan updated successfully', 'data' => $pertanyaan], 200);
    }

    public function DeletePertanyaan($id)
    {
        $pertanyaan = Pertanyaan::find($id);

        if (!$pertanyaan) {
            return response()->json(['message' => 'Pertanyaan not found'], 404);
        }

        $pertanyaan->delete();

        return response()->json(['message' => 'Pertanyaan deleted successfully'], 200);
    }

    public function jawabPertanyaan(Request $request, $idPertanyaan)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['message' => 'User not authenticated'], 401);
        }
    
        $alumni = $user->alumni;
    
        if (!$alumni) {
            return response()->json(['message' => 'Alumni data not found for this user'], 404);
        }
    
        // Validasi input
        $request->validate([
            'jawaban_terbuka' => 'nullable|string',
            'jawaban_skala' => 'nullable|integer|between:1,5', // contoh skala
        ]);
    
        // Simpan jawaban
        $jawaban = new Data_jawaban();
        $jawaban->id_alumni = $alumni->id_alumni;
        $jawaban->id_pertanyaan = $idPertanyaan;
        $jawaban->jawaban_terbuka = $request->jawaban_terbuka ?? ''; // Set to an empty string if null
        $jawaban->jawaban_skala = $request->jawaban_skala;
        $jawaban->save();

    
        return response()->json([
            'message' => 'Jawaban berhasil disimpan',
            'data' => $jawaban
        ], 200);
    }
}