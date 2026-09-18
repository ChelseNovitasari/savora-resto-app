@extends('back.layout.template')

@section('title', 'Detail Reservasi - Admin')

@section('content')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"><i class="fas fa-info-circle me-1"></i> Detail Reservasi</h1>
    </div>

    <div class="mt-3">
        <!-- Tombol Buka Modal Edit Status -->
        <button type="button" class="btn btn-warning btn-sm me-1" data-bs-toggle="modal"
            data-bs-target="#modalStatusShow">
            <i class="fas fa-edit"></i> Ubah Status
        </button>
        <a href="{{ route('reservation.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</main>

<!-- Modal Update Status untuk halaman Show -->
<div class="modal fade" id="modalStatusShow" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Status Reservasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('reservation.update', $reservation->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="status" class="form-label fw-bold">Status Reservasi</label>
                        <select class="form-select" name="status" required>
                            <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="confirmed" {{ $reservation->status == 'confirmed' ? 'selected' : '' }}>
                                Confirmed</option>
                            <option value="cancelled" {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>
                                Cancelled</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="payment_status" class="form-label fw-bold">Status Pembayaran</label>
                        <select class="form-select" name="payment_status" required>
                            <option value="unpaid" {{ $reservation->payment_status == 'unpaid' ? 'selected' : '' }}>
                                Unpaid (Belum Bayar)</option>
                            <option value="paid" {{ $reservation->payment_status == 'paid' ? 'selected' : '' }}>Paid
                                (Lunas)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
