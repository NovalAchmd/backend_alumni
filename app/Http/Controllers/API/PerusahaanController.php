<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Perusahaan;

class PerusahaanController extends Controller
{
    public function Perusahaan()
    {
        $perusahaan = Perusahaan::all();
        return response()->json(['data' => $perusahaan], 200);
    }

    public function CreatePerusahaan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_perusahaan' => 'required|string',
            'nib' => 'required|string',
            'alamat' => 'required|string',
            'email_perusahaan' => 'required|email',
            'sektor_bisnis' => 'required|string',
            'deskripsi_perusahaan' => 'required|string',
            'no_tlp' => 'required|string',
            'email' => 'required|email',
            'foto' => 'required|string',
            'website_perusahaan' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $perusahaanData = $request->all();
        $perusahaanData['user_id'] = auth()->id(); // Assuming you're using authentication
        $perusahaanData['status'] = 'mengunggu'; // Set initial status

        $perusahaan = Perusahaan::create($perusahaanData);

        return response()->json(['message' => 'Perusahaan created successfully', 'data' => $perusahaan], 201);
    }

    public function MelihatPerusahaan($id_perusahaan)
    {
        $perusahaan = Perusahaan::find($id_perusahaan);
        
        if (!$perusahaan) {
            return response()->json(['message' => 'Perusahaan not found'], 404);
        }

        return response()->json(['data' => $perusahaan], 200);
    }

    public function UpdatePerusahaan(Request $request, $id_perusahaan)
    {
        $validator = Validator::make($request->all(), [
            'nama_perusahaan' => 'string',
            'nib' => 'string',
            'alamat' => 'string',
            'email_perusahaan' => 'email',
            'sektor_bisnis' => 'string',
            'deskripsi_perusahaan' => 'string',
            'no_tlp' => 'string',
            'email' => 'email',
            'foto' => 'string',
            'website_perusahaan' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $perusahaan = Perusahaan::find($id_perusahaan);

        if (!$perusahaan) {
            return response()->json(['message' => 'Perusahaan not found'], 404);
        }

        $perusahaan->update($request->all());

        return response()->json(['message' => 'Perusahaan updated successfully', 'data' => $perusahaan], 200);
    }

    public function DeletePerusahaan($id_perusahaan)
    {
        $perusahaan = Perusahaan::find($id_perusahaan);

        if (!$perusahaan) {
            return response()->json(['message' => 'Perusahaan not found'], 404);
        }

        $perusahaan->delete();

        return response()->json(['message' => 'Perusahaan deleted successfully'], 200);
    }
}