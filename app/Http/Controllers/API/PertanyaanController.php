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
        $pertanyaan = Pertanyaan::with('alumni:id_alumni')
                                ->get();
        return response()->json(['data' => $pertanyaan], 200);
    }

    public function CreatePertanyaan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_alumni' => 'required|exists:alumni,id_alumni',
            'pertanyaan' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $pertanyaan = Pertanyaan::create($request->all());

        return response()->json(['message' => 'Pertanyaan created successfully', 'data' => $pertanyaan], 201);
    }

    public function MelihatPertanyaan($id)
    {
        $pertanyaan = Pertanyaan::with('alumni:id_alumni,nama')
                                ->find($id);
        
        if (!$pertanyaan) {
            return response()->json(['message' => 'Pertanyaan not found'], 404);
        }

        return response()->json(['data' => $pertanyaan], 200);
    }

    public function UpdatePertanyaan(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_alumni' => 'required|exists:alumni,id_alumni',
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