<?php

namespace App\Http\Controllers\Back;

use App\Exports\ReservationsExport;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;

            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('table_number', 'like', "%{$search}%")
                ->orWhere('reservation_code', 'like', "%{$search}%");
            });
        }

        // PERBAIKAN: Load relasi details beserta menu di dalamnya
        $reservations = $query->with('details.menu')->latest()->get();

        return view('back.reservation.index', compact('reservations'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // 1. Validasi Input (Tambahkan validasi payment_proof)
        $request->validate([
            'name'             => 'required|string|max:255',
            'phone'            => 'required|string|max:20',
            'reservation_date' => 'required|date',
            'reservation_time' => 'required',
            'guest_count'      => 'required|numeric|min:1',
            'table_number'     => 'required',
            'payment_proof'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ]);

        // 2. Cek ketersediaan meja
        $isBooked = \App\Models\Reservation::where('table_number', $request->table_number)
            ->where('reservation_date', $request->reservation_date)
            ->where('reservation_time', $request->reservation_time)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($isBooked) {
            return back()->withErrors(['table_number' => 'Maaf, Meja No. ' . $request->table_number . ' sudah dipesan pada tanggal dan jam tersebut.'])->withInput();
        }

        // 3. Handle upload file Bukti Pembayaran ke storage/app/public/back/payment-proofs
        $paymentProofPath = null;
        if ($request->hasFile('payment_proof')) {
            $paymentProofPath = $request->file('payment_proof')->store('back/payment-proofs', 'public');
        }

        // 4. Hitung Total & Format Rincian Menu
        $menuDetailsText = "";
        $totalPrice = 0;
        $menuItemsData = [];

        if ($request->has('menu_items')) {
            foreach ($request->menu_items as $menuId => $qty) {
                if ($qty > 0) {
                    $menu = \App\Models\Menu::find($menuId);
                    if ($menu) {
                        $subtotal = $menu->price * $qty;
                        $totalPrice += $subtotal;
                        $menuDetailsText .= "- {$menu->name} ({$qty}x) : Rp " . number_format($subtotal, 0, ',', '.') . "%0A";

                        $menuItemsData[] = [
                            'menu_id'  => $menuId,
                            'qty'      => $qty,
                            'price'    => $menu->price,
                            'subtotal' => $subtotal,
                        ];
                    }
                }
            }
        }

        // 5. Generate Kode Reservasi
        $reservationCode = 'RES-' . date('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(4));

        // 6. Simpan ke database
        $reservation = \App\Models\Reservation::create([
            'reservation_code' => $reservationCode,
            'name'             => $request->name,
            'phone'            => $request->phone,
            'reservation_date' => $request->reservation_date,
            'reservation_time' => $request->reservation_time,
            'guest_count'      => $request->guest_count,
            'table_number'     => $request->table_number,
            'notes'            => $request->notes,
            'total_price'      => $totalPrice,
            'status'           => 'pending',
            'payment_proof'    => $paymentProofPath, // <-- SIMPAN PATH GAMBAR
        ]);

        if (!empty($menuItemsData)) {
            $reservation->details()->createMany($menuItemsData);
        }

        // 7. Redirect ke WhatsApp
        $adminPhone = "6283871500590";
        $message  = "Halo, saya ingin konfirmasi Reservasi Meja (Kode: " . $reservation->reservation_code . "):%0A%0A";
        $message .= "*Nama:* " . urlencode($request->name) . "%0A";
        $message .= "*No WA:* " . urlencode($request->phone) . "%0A";
        $message .= "*Tanggal:* " . urlencode($request->reservation_date) . "%0A";
        $message .= "*Jam:* " . urlencode($request->reservation_time) . "%0A";
        $message .= "*No. Meja:* Meja " . urlencode($request->table_number) . "%0A";
        $message .= "*Jumlah Tamu:* " . urlencode($request->guest_count) . " orang%0A";

        if (!empty($request->notes)) {
            $message .= "*Catatan:* " . urlencode($request->notes) . "%0A";
        }

        if (!empty($menuDetailsText)) {
            $message .= "%0A*Pre-Order Menu:*%0A" . $menuDetailsText;
            $message .= "*Estimasi Total:* Rp " . number_format($totalPrice, 0, ',', '.') . "%0A";
        }

        $message .= "%0AMohon konfirmasinya, terima kasih!";
        $waUrl = "https://api.whatsapp.com/send?phone={$adminPhone}&text={$message}";

        return redirect()->away($waUrl);
    }

    public function show($id)
    {
        $reservation = Reservation::with('details.menu')->findOrFail($id);
        return view('back.reservation.show', compact('reservation'));
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'status'         => 'required|in:pending,confirmed,completed,cancelled',
            'payment_status' => 'required|in:unpaid,paid',
        ]);

        $reservation = Reservation::findOrFail($id);
        $reservation->update($validated);

        return back()->with('success', 'Status reservasi berhasil diperbarui!');
    }

    public function exportExcel()
    {
        // Mengunduh file excel dengan nama file dinamis berdasarkan tanggal
        $fileName = 'data-reservasi-' . date('Y-m-d') . '.xlsx';

        return Excel::download(new ReservationsExport, $fileName);
    }

    public function downloadPdf($id)
    {
        // Logic cetak PDF akan kita isi di sini nanti
        return back()->with('success', 'Fitur Cetak PDF sedang disiapkan.');
    }

    public function print($id)
    {
        // Mengambil data reservasi beserta detail menu dan kategorinya
        $reservation = \App\Models\Reservation::with(['details.menu.category'])->findOrFail($id);

        return view('back.reservation.print', compact('reservation'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled',
        ]);

        $reservation = \App\Models\Reservation::findOrFail($id);
        $reservation->status = $request->status;

        // OTOMATISASI STATUS PEMBAYARAN:
        if (in_array($request->status, ['confirmed', 'completed'])) {
            $reservation->payment_status = 'paid';
        } elseif ($request->status === 'pending') {
            $reservation->payment_status = 'unpaid';
        }

        $reservation->save();

        return redirect()->back()->with('success', 'Status reservasi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $reservation = \App\Models\Reservation::findOrFail($id);

        $reservation->details()->delete();

        $reservation->delete();

        return redirect()->back()->with('success', 'Data reservasi berhasil dihapus.');
    }
}
