@extends('back.layout.template')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.min.css">
@endpush

@push('css')
<style>
    /* Mengizinkan dropdown tampil di luar pembungkus tabel DataTables */
    .table-responsive,
    .dataTables_wrapper,
    .dataTables_scrollBody {
        overflow: visible !important;
    }

    /* Memastikan menu dropdown berada di lapisan paling atas */
    .dropdown-menu {
        z-index: 9999 !important;
    }

</style>
@endpush

@section('title', 'Daftar Reservasi - Admin')

@section('content')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom" data-aos="fade-down">
        <h1 class="h2"><i class="fas fa-list me-2"></i>Daftar Reservasi</h1>

        {{-- Tombol Export Excel --}}
        <a href="{{ route('admin.reservations.export-excel') }}" class="btn btn-success fw-bold shadow-sm">
            <i class="fas fa-file-excel me-2"></i>Export Excel
        </a>
    </div>

    <div class="mt-3" data-aos="fade-up" data-aos-delay="150">
        <table class="table table-striped table-bordered align-middle" id="dataTable">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Pelanggan</th>
                    <th>Waktu Kedatangan</th>
                    <th>No. Meja & Info</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $reservation)
                <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <span class="badge bg-primary fs-6">{{ $reservation->reservation_code }}</span>
                    </td>
                    <td>
                        <div class="fw-bold text-dark">{{ $reservation->name }}</div>
                        <small class="text-muted">
                            <i class="fab fa-whatsapp text-success me-1"></i>{{ $reservation->phone }}
                        </small>
                    </td>
                    <td>
                        <div class="fw-semibold">
                            {{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d-m-Y') }}
                        </div>
                        <small class="text-secondary">
                            <i class="far fa-clock me-1"></i>{{ $reservation->reservation_time }} WIB
                        </small>
                    </td>
                    <td>
                        <div class="fw-bold text-primary">Meja No. {{ $reservation->table_number ?? 'Belum Diatur' }}
                        </div>
                        <div class="small text-success fw-semibold">
                            Total: Rp {{ number_format($reservation->total_price, 0, ',', '.') }}
                        </div>
                        <small class="text-muted">{{ $reservation->guest_count }} Tamu</small>
                    </td>
                    <td>
                        @if($reservation->status == 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($reservation->status == 'confirmed')
                        <span class="badge bg-success">Dikonfirmasi</span>
                        @elseif($reservation->status == 'completed')
                        <span class="badge bg-info">Selesai</span>
                        @else
                        <span class="badge bg-danger">Dibatalkan</span>
                        @endif
                    </td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" data-bs-auto-close="true" aria-expanded="false">
                                <i class="fas fa-cog me-1"></i> Aksi
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0" data-bs-popper="static">
                                <li>
                                    <button class="dropdown-item" type="button" data-bs-toggle="modal"
                                        data-bs-target="#modalMenu{{ $reservation->id }}">
                                        <i class="fas fa-utensils text-warning me-2"></i> Menu Dipesan
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item" type="button" data-bs-toggle="modal"
                                        data-bs-target="#modalConfirm{{ $reservation->id }}">
                                        <i class="fas fa-eye"></i> Bukti Bayar
                                    </button>
                                </li>
                                <li>
                                    <a class="dropdown-item"
                                        href="{{ route('admin.reservation.print', $reservation->id) }}" target="_blank">
                                        <i class="fas fa-print text-secondary me-2"></i> Cetak Struk
                                    </a>
                                </li>
                                <li>
                                    <button class="dropdown-item" type="button" data-bs-toggle="modal"
                                        data-bs-target="#modalStatus{{ $reservation->id }}">
                                        <i class="fas fa-sync-alt text-primary me-2"></i> Ubah Status
                                    </button>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('admin.reservation.destroy', $reservation->id) }}"
                                        method="POST" id="delete-form-{{ $reservation->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="dropdown-item text-danger btn-delete"
                                            data-id="{{ $reservation->id }}">
                                            <i class="fas fa-trash me-2"></i> Hapus Data
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">Belum ada data reservasi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @foreach($reservations as $reservation)
    {{-- Modal Menu Dipesan --}}
    <div class="modal fade" id="modalMenu{{ $reservation->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning text-dark">
                    <h5 class="modal-title fw-bold"><i class="fas fa-utensils me-2"></i>Menu Pre-Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-start">
                    @if($reservation->details && $reservation->details->isNotEmpty())
                    <ul class="list-group list-group-flush">
                        @foreach($reservation->details as $detail)
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <div>
                                <h6 class="mb-0 fw-bold">{{ $detail->menu->name ?? 'Menu tidak ditemukan' }}</h6>
                                <small class="text-muted">
                                    Rp {{ number_format($detail->price, 0, ',', '.') }} x {{ $detail->qty }}
                                </small>
                            </div>
                            <span class="fw-bold text-dark">
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </span>
                        </li>
                        @endforeach
                    </ul>
                    <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                        <span class="fw-bold">Total Estimasi:</span>
                        <span class="fw-bold text-success h5 mb-0">
                            Rp {{ number_format($reservation->total_price, 0, ',', '.') }}
                        </span>
                    </div>
                    @else
                    <p class="text-center text-muted my-3">Pelanggan tidak melakukan pre-order menu.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Preview Bukti Pembayaran & Konfirmasi -->
    <div class="modal fade" id="modalConfirm{{ $reservation->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title"><i class="fas fa-receipt me-2"></i>Bukti Pembayaran -
                        {{ $reservation->reservation_code }}</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="mb-1"><strong>Atas Nama:</strong> {{ $reservation->name }}</p>
                    <p class="mb-3"><strong>Total Tagihan:</strong> <span class="text-success fw-bold">Rp
                            {{ number_format($reservation->total_price, 0, ',', '.') }}</span></p>

                    <div class="border rounded p-2 bg-light mb-3">
                        @if($reservation->payment_proof)
                        <img src="{{ asset('storage/' . $reservation->payment_proof) }}" alt="Bukti Pembayaran"
                            class="img-fluid rounded border shadow-sm" style="max-height: 380px; object-fit: contain;">
                        @else
                        <div class="py-4 text-muted">
                            <i class="fas fa-image fa-3x mb-2 d-block text-secondary"></i>
                            Pelanggan tidak mengunggah bukti pembayaran.
                        </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>

                    @if($reservation->status !== 'confirmed')
                    <form action="{{ route('reservation.updateStatus', $reservation->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="confirmed">
                        <input type="hidden" name="payment_status" value="paid">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check-circle me-1"></i> Konfirmasi
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- 3. Modal Ubah Status --}}
    <div class="modal fade" id="modalStatus{{ $reservation->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title"><i class="fas fa-sync-alt me-2"></i>Ubah Status Reservasi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.reservation.update-status', $reservation->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-body text-start">
                        <label class="form-label fw-semibold">Pilih Status Baru:</label>
                        <select name="status" class="form-select">
                            <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>Pending
                                (Menunggu)</option>
                            <option value="confirmed" {{ $reservation->status == 'confirmed' ? 'selected' : '' }}>
                                Confirmed (Dikonfirmasi)</option>
                            <option value="completed" {{ $reservation->status == 'completed' ? 'selected' : '' }}>
                                Completed (Selesai/Datang)</option>
                            <option value="cancelled" {{ $reservation->status == 'cancelled' ? 'selected' : '' }}>
                                Cancelled (Batal)</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
</main>
@endsection

@push('js')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/2.0.2/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        // Inisialisasi DataTables
        if (!$.fn.DataTable.isDataTable('#dataTable')) {
            $('#dataTable').DataTable({
                "responsive": true,
                "autoWidth": false
            });
        }

        // SweetAlert2 Konfirmasi Hapus Data
        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();
            let id = $(this).data('id');

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data reservasi yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#delete-form-' + id).submit();
                }
            });
        });

        // Flash Message Toast/Alert via SweetAlert2 (jika Controller me-return session)
        @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            timer: 2000,
            showConfirmButton: false
        });
        @endif

        @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: "{{ session('error') }}",
            timer: 2000,
            showConfirmButton: false
        });
        @endif
    });

</script>
@endpush
