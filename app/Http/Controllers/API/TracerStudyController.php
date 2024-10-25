<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Tracer_study;

class TracerStudyController extends Controller
{
    // Get all Tracer_study records with related Pertanyaan data
    public function TracerStudy()
    {
        $tracerStudy = Tracer_study::with('pertanyaan:id_pertanyaan')->get();
        return response()->json(['data' => $tracerStudy], 200);
    }

    // Create a new Tracer_study record
    public function createPertanyaan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_pertanyaan' => 'required|exists:pertanyaan,id_pertanyaan', // Validasi untuk memastikan bahwa Pertanyaan terkait ada
            'pertanyaan' => 'required|exists:pertanyaan,pertanyaan', // Gantilah 'jawaban' dengan field yang sesuai jika berbeda
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $tracerStudy = Tracer_study::create($request->all());

        return response()->json(['message' => 'Tracer study created successfully', 'data' => $tracerStudy], 201);
    }

    // Get a single Tracer_study record by ID
    public function MelihatTracerStudy($id)
    {
        $tracerStudy = Tracer_study::with('pertanyaan')->find($id);

        if (!$tracerStudy) {
            return response()->json(['message' => 'Tracer study not found'], 404);
        }

        return response()->json(['data' => $tracerStudy], 200);
    }

    // Update a Tracer_study record by ID
    public function UpdateTracerStudy(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_pertanyaan' => 'exists:pertanyaan,id_pertanyaan', // Validasi untuk memastikan Pertanyaan terkait ada
            'jawaban' => 'string', // Gantilah 'jawaban' dengan field yang sesuai jika berbeda
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $tracerStudy = Tracer_study::find($id);

        if (!$tracerStudy) {
            return response()->json(['message' => 'Tracer study not found'], 404);
        }

        $tracerStudy->update($request->all());

        return response()->json(['message' => 'Tracer study updated successfully', 'data' => $tracerStudy], 200);
    }

    // Delete a Tracer_study record by ID
    public function DeleteTracerStudy($id)
    {
        $tracerStudy = Tracer_study::find($id);

        if (!$tracerStudy) {
            return response()->json(['message' => 'Tracer study not found'], 404);
        }

        $tracerStudy->delete();

        return response()->json(['message' => 'Tracer study deleted successfully'], 200);
    }
}
