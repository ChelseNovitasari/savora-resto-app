<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FrontController extends Controller
{
    public function index()
    {
        // 1. Ambil data kategori
        $categories = \App\Models\Category::has('menus')->get();

        // 2. Ambil data menu
        $menus = \App\Models\Menu::with('category')->get();

        // 3. Ambil data artikel
        $articles = \App\Models\Article::latest()->get();

        // 4. Ambil data testimoni yang SUDAH DISETUJUI saja
        $testimonials = \App\Models\Testimonial::where('is_approved', 1)->latest()->take(3)->get();

        // 5. Kirim semua variabel ke view 'welcome'
        return view('welcome', compact('categories', 'menus', 'articles', 'testimonials'));
    }

    public function allMenus()
{
    $menus = \App\Models\Menu::with('category')->latest()->paginate(12);

    return view('menus', compact('menus'));
}

public function showArticle($slug)
{
    // Cari artikel berdasarkan kolom slug
    $article = \App\Models\Article::where('slug', $slug)->firstOrFail();

    // Ambil artikel terbaru lainnya untuk rekomendasi (opsional)
    $otherArticles = \App\Models\Article::where('slug', '!=', $slug)->latest()->take(3)->get();

    return view('article-detail', compact('article', 'otherArticles'));
}

    public function storeReservation(Request $request)
    {
        // 1. Validasi input dari form
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'phone'      => 'required|string|max:20',
            'date'       => 'required|date',
            'time'       => 'required',
            'guests'     => 'required|integer|min:1',
            'note'       => 'nullable|string',
            'menu_items' => 'nullable|array',
        ]);

        // 2. Generate kode reservasi unik
        $reservationCode = 'RSV-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        // 3. Simpan data reservasi utama
        $reservation = Reservation::create([
            'reservation_code' => $reservationCode,
            'name'             => $validated['name'],
            'phone'            => $validated['phone'],
            'date'             => $validated['date'],
            'time'             => $validated['time'],
            'guests'           => $validated['guests'],
            'note'             => $validated['note'] ?? null,
            'status'           => 'pending',
            'payment_status'   => 'unpaid',
        ]);

        // 4. Tangkap menu yang diisi kuantitasnya (> 0)
        $selectedMenus = array_filter($request->input('menu_items', []), function($qty) {
            return $qty > 0;
        });

        // 5. Simpan detail menu jika pengunjung memesan menu
        if (!empty($selectedMenus)) {
            foreach ($selectedMenus as $menuId => $quantity) {
                $reservation->details()->create([
                    'menu_id'  => $menuId,
                    'quantity' => $quantity,
                ]);
            }
        }

        return back()->with('success', 'Reservasi berhasil dibuat! Kode reservasi Anda: ' . $reservationCode);
    }

    public function storeTestimonial(Request $request)
    {
    // 1. Validasi Input Form
        $request->validate([
            'reservation_code' => 'required|string',
            'rating'           => 'required|integer|min:1|max:5',
            'comment'          => 'required|string|min:10',
        ], [
            'reservation_code.required' => 'Kode reservasi wajib diisi.',
            'rating.required'           => 'Silakan pilih rating bintang.',
            'comment.required'          => 'Ulasan/komentar wajib diisi.',
            'comment.min'               => 'Ulasan minimal 10 karakter.',
        ]);

        // 2. Cari data reservasi berdasarkan kode yang diinput
        $reservation = Reservation::where('reservation_code', trim($request->reservation_code))->first();

        if (!$reservation) {
            return back()->withErrors(['reservation_code' => 'Kode reservasi tidak ditemukan.'])->withInput();
        }

        // 3. Validasi Status: Harus completed
        if ($reservation->status !== 'completed') {
            return back()->withErrors(['reservation_code' => 'Testimoni hanya dapat dikirim jika status kunjungan reservasi Anda sudah selesai (Completed).'])->withInput();
        }

        // 4. Validasi Duplikasi: Cek apakah kode reservasi sudah pernah dipakai
        $alreadySubmitted = Testimonial::where('reservation_id', $reservation->id)->exists();
        if ($alreadySubmitted) {
            return back()->withErrors(['reservation_code' => 'Kode reservasi ini sudah pernah digunakan untuk mengirim testimoni.'])->withInput();
        }

        // 5. Simpan Testimoni
        Testimonial::create([
            'reservation_id' => $reservation->id,
            'customer_name'  => $reservation->name, // Mengambil nama otomatis dari data reservasi
            'rating'         => $request->rating,
            'comment'        => $request->comment,
            'is_approved'    => false, // Menunggu persetujuan admin
        ]);

        return back()->with('success', 'Terima kasih! Ulasan Anda berhasil dikirim dan akan tampil setelah disetujui oleh admin.');
    }

    public function allTestimonials()
    {
        // Ambil semua testimoni yang disetujui saja + pagination (misal 9 per halaman)
        $testimonials = \App\Models\Testimonial::where('is_approved', 1)->latest()->paginate(9);

        return view('testimonials', compact('testimonials'));
    }
}

