<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::with('reservation')->latest()->get();
        return view('back.testimonial.index', compact('testimonials'));
    }

    public function toggleApproval(Request $request, $id)
{
    try {
        $testimonial = Testimonial::findOrFail($id);

        // Pastikan nama kolom di database sesuai (is_approved / status / dll)
        $testimonial->is_approved = $request->is_approved;
        $testimonial->save();

        return response()->json([
            'status' => 'success',
            'is_approved' => $testimonial->is_approved,
            'message' => 'Status ulasan berhasil diperbarui!'
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage() // Mengirim detail pesan error ke AJAX
        ], 500);
    }
}

    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();

        return response()->json([
            'message' => 'Ulasan berhasil dihapus!'
        ]);
    }
}
