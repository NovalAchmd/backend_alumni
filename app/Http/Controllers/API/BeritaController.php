<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BeritaController extends Controller
{
    public function Berita()
    {
        $beritas = Berita::all();
        return response()->json([
            'status' => 'success',
            'data' => $beritas
        ]);
    }

    public function CreateBerita(Request $request)
{
    $validator = Validator::make($request->all(), [
        'judul_berita' => 'required',
        'tanggal_terbit' => 'required|date',
        'deskripsi_berita' => 'required',
        'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        'link' => 'required|url'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'errors' => $validator->errors()
        ], 422);
    }

    $image = $request->file('gambar');
    $hashedImageName = $image->hashName();
    $image->store('public/berita_photos');

    $berita = Berita::create([
        'judul_berita' => $request->judul_berita,
        'tanggal_terbit' => $request->tanggal_terbit,
        'deskripsi_berita' => $request->deskripsi_berita,
        'gambar' => $hashedImageName,
        'link' => $request->link
    ]);

    return response()->json([
        'status' => 'success',
        'message' => 'Berita berhasil ditambahkan',
        'data' => $berita
    ], 201);
}


    public function MelihatBerita($id)
    {
        $berita = Berita::find($id);
        
        if (!$berita) {
            return response()->json([
                'status' => 'error',
                'message' => 'Berita tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $berita
        ]);
    }

    public function UpdateBerita(Request $request, $id)
{
    $berita = Berita::find($id);

    if (!$berita) {
        return response()->json([
            'status' => 'error',
            'message' => 'Berita tidak ditemukan'
        ], 404);
    }

    // Validation rules
    $validator = Validator::make($request->all(), [
        'judul_berita' => 'nullable|required_without_all:tanggal_terbit,deskripsi_berita,gambar,link',
        'tanggal_terbit' => 'nullable|required_without_all:judul_berita,deskripsi_berita,gambar,link|date',
        'deskripsi_berita' => 'nullable|required_without_all:judul_berita,tanggal_terbit,gambar,link',
        'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'link' => 'nullable|required_without_all:judul_berita,tanggal_terbit,deskripsi_berita,gambar|url'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'errors' => $validator->errors()
        ], 422);
    }

    // Update fields if present in the request
    if ($request->has('judul_berita')) {
        $berita->judul_berita = $request->judul_berita;
    }

    if ($request->has('tanggal_terbit')) {
        $berita->tanggal_terbit = $request->tanggal_terbit;
    }

    if ($request->has('deskripsi_berita')) {
        $berita->deskripsi_berita = $request->deskripsi_berita;
    }

    if ($request->has('gambar')) {
        // Hapus foto lama jika ada
        Storage::delete('public/berita_photos/' . $berita->gambar);
        
        // Upload foto baru
        $image = $request->file('gambar');
        $imageName = $image->hashName();
        $image->storeAs('public/berita_photos', $imageName);
        
        $berita->gambar = $imageName;
    }

    if ($request->has('link')) {
        $berita->link = $request->link;
    }

    // Save the updated berita
    $berita->save();

    return response()->json([
        'status' => 'success',
        'message' => 'Berita berhasil diperbarui',
        'data' => $berita
    ]);
}


    public function DeleteBerita($id)
    {
        $berita = Berita::find($id);

        if (!$berita) {
            return response()->json([
                'status' => 'error',
                'message' => 'Berita tidak ditemukan'
            ], 404);
        }

        // Hapus foto
        Storage::delete('public/berita_photos/' . $berita->gambar);
        
        // Hapus data
        $berita->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Berita berhasil dihapus'
        ]);
    }
}