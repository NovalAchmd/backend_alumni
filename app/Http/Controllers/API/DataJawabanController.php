<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Data_jawaban;
use Illuminate\Http\Request;

class DataJawabanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'id_alumni' => 'required|exists:alumni,id_alumni',
            'id_pertanyaan' => 'required|exists:pertanyaan,id_pertanyaan',
            'jawaban_terbuka' => 'nullable|string',
            'jawaban_skala' => 'nullable|string',
        ]);

        $jawaban = Data_jawaban::create([
            'id_alumni' => $request->id_alumni,
            'id_pertanyaan' => $request->id_pertanyaan,
            'jawaban_terbuka' => $request->jawaban_terbuka,
            'jawaban_skala' => $request->jawaban_skala,
        ]);

        return response()->json(['message' => 'Jawaban berhasil disimpan', 'data' => $jawaban], 201);
    }

    public function melihatJawaban()
    {
        $jawaban = Data_jawaban::all();
        return response()->json(['data' => $jawaban], 200);
    }
}
