<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Pertanyaan;

class PertanyaanController extends Controller
{
    public function Pertanyaan()
    {
        $pertanyaan = Pertanyaan::all();
        return response()->json(['data' => $pertanyaan], 200);
    }

    public function createPertanyaan(Request $request)
{
    $validator = validator::make($request->all(), [
        'pertanyaan' => 'required|string',
        'jenis' => 'required|in:skala,tertutup',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $pertanyaan = Pertanyaan::create($request->all());
    return response()->json(['data' => $pertanyaan, 'message' => 'pertanyaan created successfully'], 201);
}


public function MelihatPertanyaan($id)
{
    // Find pertanyaan by the correct column name, e.g., id_pertanyaan
    $pertanyaan = Pertanyaan::
                            where('id_pertanyaan', $id) // change this if the column is named differently
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
}