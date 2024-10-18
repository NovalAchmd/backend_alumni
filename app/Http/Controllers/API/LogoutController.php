<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
{
    try {
        // Mendapatkan pengguna yang sedang login
        $user = Auth::user();

        // Pastikan pengguna tidak null
        if (!$user) {
            return response()->json([
                "status" => 401,
                "success" => false,
                "message" => "Pengguna tidak terautentikasi."
            ], 401);
        }

        // Hapus token yang sedang aktif
        $user->currentAccessToken()->delete();

        return response()->json([
            "status" => 202,
            "success" => true,
            "message" => "Logout Berhasil!",
        ]);
    } catch (\Throwable $t) {
        return response()->json([
            "status" => 500,
            "success" => false,
            "message" => "Terjadi kesalahan pada server.",
            "error" => $t->getMessage(),
        ], 500);
    }
}

}
