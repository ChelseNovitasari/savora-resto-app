@extends('back.layout.template')

@section('title', 'Edit Reservasi - Admin')

@section('content')

<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mb-5">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Edit Reservasi</h1>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form action="{{ route('reservation.update', $reservation->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            {{-- BAGIAN EDIT STATUS (Hanya ada di Edit) --}}
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label fw-bold">Status Reservasi <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status" required>
                                    <option value="pending"
                                        {{ old('status', $reservation->status) == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="confirmed"
                                        {{ old('status', $reservation->status) == 'confirmed' ? 'selected' : '' }}>
                                        Confirmed</option>`
                                    <option value="cancelled"
                                        {{ old('status', $reservation->status) == 'cancelled' ? 'selected' : '' }}>
                                        Cancelled</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="payment_status" class="form-label fw-bold">Status Pembayaran <span
                                        class="text-danger">*</span></label>
                                <select class="form-select @error('payment_status') is-invalid @enderror"
                                    id="payment_status" name="payment_status" required>
                                    <option value="unpaid"
                                        {{ old('payment_status', $reservation->payment_status) == 'unpaid' ? 'selected' : '' }}>
                                        Unpaid (Belum Bayar)</option>
                                    <option value="paid"
                                        {{ old('payment_status', $reservation->payment_status) == 'paid' ? 'selected' : '' }}>
                                        Paid (Lunas)</option>
                                </select>
                                @error('payment_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2 mt-5">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('reservation.index') }}" class="btn btn-outline-secondary shadow-sm">
                                    <i class="fas fa-arrow-left"></i> Batal
                                </a>
                            </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</main>
@endsection
