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
        $lowongan = Lowongan::all();
        foreach ($lowongan as $al) {
            $al->lowongan;
        }
        return response()->json(['data' => $lowongan], 200);
    }

    public function CreateLowongan(Request $request)
{
    // Cek apakah pengguna sudah login
    $user = auth()->user();

    // Pastikan pengguna yang membuat lowongan adalah perusahaan
    if (!$user || $user->role !== 2) { // Misalnya role perusahaan bernilai 2
        return response()->json(['message' => 'Hanya perusahaan yang dapat membuat lowongan'], 403);
    }

    // Validasi input
    $validator = Validator::make($request->all(), [
        'nib' => 'required|exists:perusahaan,nib',
        'judul_lowongan' => 'required|string',
        'posisi_pekerjaan' => 'required|string',
        'deskripsi_pekerjaan' => 'required|string',
        'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'tipe_pekerjaan' => 'required|in:Full_time,Part_time,internship',
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

    // Proses upload gambar
    $lowonganData = $request->all();
    if ($request->hasFile('gambar')) {
        $imagePath = $request->file('gambar')->store('lowongan_photos', 'public');
        $lowonganData['gambar'] = $imagePath;
    }

    // Tambahkan status pending secara default
    $lowonganData['status'] = 'pending';

    // Simpan data lowongan ke database
    $lowongan = Lowongan::create($lowonganData);

    return response()->json(['message' => 'Lowongan created successfully', 'data' => $lowongan], 201);
}



    // public function UpdateLowongan(Request $request, $id_lowongan)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'id_perusahaan' => 'exists:perusahaan,id_perusahaan',
    //         'judul_lowongan' => 'string',
    //         'posisi_pekerjaan' => 'string',
    //         'deskripsi_pekerjaan' => 'string',
    //         'tipe_pekerjaan' => 'in:Full_time,Part_time,internship',
    //         'sistem_kerja' => 'in:WFH,WFO',
    //         'jumlah_kandidat' => 'string',
    //         'lokasi' => 'string',
    //         'tanggal_aktif' => 'date',
    //         'rentang_gaji' => 'string',
    //         'pengalaman_kerja' => 'string',
    //         'kontak' => 'string',
    //     ]);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 422);
    //     }

    //     $lowongan = Lowongan::find($id_lowongan);

    //     if (!$lowongan) {
    //         return response()->json(['message' => 'Lowongan not found'], 404);
    //     }

    //     $lowongan->update($request->all());

    //     return response()->json(['message' => 'Lowongan updated successfully', 'data' => $lowongan], 200);
    // }

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