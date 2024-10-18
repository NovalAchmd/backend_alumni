<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Pendidikan;

class PendidikanController extends Controller
{
    public function Pendidikan()
    {
        $pendidikan = Pendidikan::with('alumni:id_alumni,nama')->get();
        return response()->json(['data' => $pendidikan], 200);
    }

    public function CreatePendidikan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_alumni' => 'required|exists:alumni,id_alumni',
            'perguruan_tinggi' => 'required|string',
            'jurusan' => 'required|string',
            'tahun_lulus' => 'required|string',
            'ipk' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $pendidikan = Pendidikan::create($request->all());

        return response()->json(['message' => 'Pendidikan created successfully', 'data' => $pendidikan], 201);
    }

    public function MelihatPendidikan($id_pdd)
    {
        $pendidikan = Pendidikan::with('alumni:id_alumni,nama')->find($id_pdd);
        
        if (!$pendidikan) {
            return response()->json(['message' => 'Pendidikan not found'], 404);
        }

        return response()->json(['data' => $pendidikan], 200);
    }

    public function UpdatePendidikan(Request $request, $id_pdd)
    {
        $validator = Validator::make($request->all(), [
            'id_alumni' => 'exists:alumni,id_alumni',
            'perguruan_tinggi' => 'string',
            'jurusan' => 'string',
            'tahun_lulus' => 'string',
            'ipk' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $pendidikan = Pendidikan::find($id_pdd);

        if (!$pendidikan) {
            return response()->json(['message' => 'Pendidikan not found'], 404);
        }

        $pendidikan->update($request->all());

        return response()->json(['message' => 'Pendidikan updated successfully', 'data' => $pendidikan], 200);
    }

    public function DeletePendidikan($id_pdd)
    {
        $pendidikan = Pendidikan::find($id_pdd);

        if (!$pendidikan) {
            return response()->json(['message' => 'Pendidikan not found'], 404);
        }

        $pendidikan->delete();

        return response()->json(['message' => 'Pendidikan deleted successfully'], 200);
    }
}