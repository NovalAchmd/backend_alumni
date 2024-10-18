<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Lowongan;

class LowonganController extends Controller
{
    public function Lowongan()
    {
        $lowongan = Lowongan::with('perusahaan:id_perusahaan,nama_perusahaan')
                            ->get();
        return response()->json(['data' => $lowongan], 200);
    }

    public function CreateLowongan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_perusahaan' => 'required|exists:perusahaan,id_perusahaan',
            'judul_lowongan' => 'required|string',
            'posisi_pekerjaan' => 'required|string',
            'deskripsi_pekerjaan' => 'required|string',
            'tipe_pekerjaan' => 'required|in:Full_time,Part_time,internship',
            'sistem_kerja' => 'required|in:WFH,WFO',
            'jumlah_kandidat' => 'required|string',
            'lokasi' => 'required|string',
            'tanggal_aktif' => 'required|date',
            'rentang_gaji' => 'required|string',
            'pengalaman_kerja' => 'required|string',
            'kontak' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $lowongan = Lowongan::create($request->all());

        return response()->json(['message' => 'Lowongan created successfully', 'data' => $lowongan], 201);
    }

    public function MelihatLowongan($id_lowongan)
    {
        $lowongan = Lowongan::with('perusahaan:id_perusahaan,nama_perusahaan')
                            ->find($id_lowongan);
        
        if (!$lowongan) {
            return response()->json(['message' => 'Lowongan not found'], 404);
        }

        return response()->json(['data' => $lowongan], 200);
    }

    public function UpdateLowongan(Request $request, $id_lowongan)
    {
        $validator = Validator::make($request->all(), [
            'id_perusahaan' => 'exists:perusahaan,id_perusahaan',
            'judul_lowongan' => 'string',
            'posisi_pekerjaan' => 'string',
            'deskripsi_pekerjaan' => 'string',
            'tipe_pekerjaan' => 'in:Full_time,Part_time,internship',
            'sistem_kerja' => 'in:WFH,WFO',
            'jumlah_kandidat' => 'string',
            'lokasi' => 'string',
            'tanggal_aktif' => 'date',
            'rentang_gaji' => 'string',
            'pengalaman_kerja' => 'string',
            'kontak' => 'string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $lowongan = Lowongan::find($id_lowongan);

        if (!$lowongan) {
            return response()->json(['message' => 'Lowongan not found'], 404);
        }

        $lowongan->update($request->all());

        return response()->json(['message' => 'Lowongan updated successfully', 'data' => $lowongan], 200);
    }

    public function DeleteLowongan($id_lowongan)
    {
        $lowongan = Lowongan::find($id_lowongan);

        if (!$lowongan) {
            return response()->json(['message' => 'Lowongan not found'], 404);
        }

        $lowongan->delete();

        return response()->json(['message' => 'Lowongan deleted successfully'], 200);
    }
}