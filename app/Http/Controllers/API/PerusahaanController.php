<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
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
    $perusahaan = Perusahaan::find($id_perusahaan);

    if (!$perusahaan) {
        return response()->json(['message' => 'Perusahaan not found'], 404);
    }

    try {
        // Validate input data
        $validator = Validator::make($request->all(), [
            'nama_perusahaan' => 'nullable|string|max:255',
            'nib' => 'nullable|string',
            'alamat' => 'nullable|string',
            'email_perusahaan' => 'nullable|email|unique:perusahaan,email_perusahaan,' . $perusahaan->id_perusahaan . ',id_perusahaan',
            'sektor_bisnis' => 'nullable|string',
            'deskripsi_perusahaan' => 'nullable|string',
            'no_tlp' => 'nullable|string',
            'website_perusahaan' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Prepare data for update
        $dataToUpdate = [
            'nama_perusahaan' => $request->nama_perusahaan ?? $perusahaan->nama_perusahaan,
            'nib' => $request->nib ?? $perusahaan->nib,
            'alamat' => $request->alamat ?? $perusahaan->alamat,
            'email_perusahaan' => $request->email_perusahaan ?? $perusahaan->email_perusahaan,
            'sektor_bisnis' => $request->sektor_bisnis ?? $perusahaan->sektor_bisnis,
            'deskripsi_perusahaan' => $request->deskripsi_perusahaan ?? $perusahaan->deskripsi_perusahaan,
            'no_tlp' => $request->no_tlp ?? $perusahaan->no_tlp,
            'website_perusahaan' => $request->website_perusahaan ?? $perusahaan->website_perusahaan,
        ];

        // Handle photo upload if provided
        if ($request->hasFile('foto')) {
            // Delete the old photo if it exists
            if ($perusahaan->foto) {
                Storage::disk('public')->delete($perusahaan->foto);
            }
            // Save the new photo and update its path
            $dataToUpdate['foto'] = $request->file('foto')->store('perusahaan_photos', 'public');
        } else {
            // If no new photo is provided, retain the old photo
            $dataToUpdate['foto'] = $perusahaan->foto;
        }

        // Update the perusahaan data
        $perusahaan->update($dataToUpdate);

        return response()->json(['message' => 'Perusahaan updated successfully', 'data' => $perusahaan], 200);
    } catch (\Exception $e) {
        Log::error('Error updating perusahaan: ' . $e->getMessage());

        return response()->json([
            'message' => 'Tidak berhasil memperbarui perusahaan',
        ], 500);
    }
}


public function DeletePerusahaan(Request $request, $id_perusahaan)
{
    $perusahaan = Perusahaan::find($id_perusahaan);

    if (!$perusahaan) {
        return response()->json(['message' => 'Perusahaan tidak ditemukan'], 404);
    }

    // Tentukan data apa saja yang boleh dihapus berdasarkan input dari request
    $dataToUpdate = [];

    if ($request->has('hapus_foto')) {
        $dataToUpdate['foto'] = null;
        // Hapus foto di storage jika ada
        if ($perusahaan->foto) {
            Storage::disk('public')->delete($perusahaan->foto);
        }
    }

    if ($request->has('hapus_nama_perusahaan')) {
        $dataToUpdate['nama_perusahaan'] = null;
    }

    if ($request->has('hapus_sektor_bisnis')) {
        $dataToUpdate['sektor_bisnis'] = null;
    }

    if ($request->has('hapus_alamat')) {
        $dataToUpdate['alamat'] = null;
    }

    if ($request->has('hapus_deskripsi_website')) {
        $dataToUpdate['deskripsi_perusahaan'] = null;
    }

    // Update data tanpa menyentuh id_perusahaan dan id_user
    $perusahaan->update($dataToUpdate);

    return response()->json([
        'message' => 'Data perusahaan berhasil dihapus berdasarkan permintaan',
        'data' => $perusahaan
    ], 200);
}

}