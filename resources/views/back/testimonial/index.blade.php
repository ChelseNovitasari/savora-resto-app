@extends('back.layout.template')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/3.0.2/css/dataTables.bootstrap5.min.css">
<style>
    /* Mencegah dropdown tertutup atau tidak bisa diklik di dalam DataTables */
    .table-responsive {
        overflow: visible !important;
    }

    .dropdown-menu {
        z-index: 1050 !important;
    }

</style>
@endpush

@section('title', 'Daftar Ulasan Pelanggan - Admin')

@section('content')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom" data-aos="fade-down">
        <h1 class="h2"><i class="fas fa-star me-2 text-warning"></i>Daftar Ulasan Pelanggan</h1>
    </div>

    {{-- Alert --}}
    <div class="swal" data-swal="{{ session('success') }}"></div>
    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">{{ session('error') }}</div>
    @endif

    <div class="mt-3">
        <div class="table-responsive" data-aos="fade-up" data-aos-delay="150">
            <table class="table table-striped table-bordered align-middle" id="dataTable">
                <thead>
                    <tr class="text-center">
                        <th width="50px">No</th>
                        <th>Kode Reservasi</th>
                        <th>Nama Pelanggan</th>
                        <th>Rating</th>
                        <th>Komentar</th>
                        <th>Status Approved</th>
                        <th width="100px">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse ($testimonials as $testimonial)
                    <tr id="row-{{ $testimonial->id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <span class="badge bg-secondary">
                                {{ $testimonial->reservation->reservation_code ?? '-' }}
                            </span>
                        </td>
                        <td><strong>{{ $testimonial->customer_name }}</strong></td>
                        <td>
                            <span class="text-warning fw-bold">
                                @for ($i = 1; $i <= 5; $i++) @if ($i <=$testimonial->rating)
                                    ★
                                    @else
                                    ☆
                                    @endif
                                    @endfor
                            </span>
                            <small class="text-muted d-block">({{ $testimonial->rating }}/5)</small>
                        </td>
                        <td>{{ $testimonial->comment }}</td>

                        <!-- Kolom Status Approved (Toggle Dropdown Opsi) -->
                        <td class="text-center">
                            <div class="dropdown">
                                <button
                                    class="btn btn-sm {{ $testimonial->is_approved ? 'btn-success' : 'btn-secondary' }} dropdown-toggle"
                                    type="button" id="btnStatus{{ $testimonial->id }}" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <span class="status-label">
                                        {{ $testimonial->is_approved ? 'Disetujui' : 'Disembunyikan' }}
                                    </span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0"
                                    aria-labelledby="btnStatus{{ $testimonial->id }}">
                                    <li>
                                        <a class="dropdown-item btn-change-status text-success fw-semibold"
                                            href="javascript:void(0)" data-id="{{ $testimonial->id }}" data-status="1">
                                            <i class="fas fa-check-circle me-2"></i> Disetujui
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item btn-change-status text-secondary fw-semibold"
                                            href="javascript:void(0)" data-id="{{ $testimonial->id }}" data-status="0">
                                            <i class="fas fa-eye-slash me-2"></i> Disembunyikan
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>

                        <!-- Kolom Aksi (Tombol Hapus) -->
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-danger" onclick="deleteTestimonial(this)"
                                data-id="{{ $testimonial->id }}">
                                <i class="fas fa-trash me-1"></i> Hapus
                            </button>
                        </td>
                    </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection

@push('js')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.datatables.net/3.0.2/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/3.0.2/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function () {
        // Inisialisasi DataTable
        $('#dataTable').DataTable();

        // Manual Re-initialization untuk Dropdown Bootstrap di DataTables
        $(document).on('click', '[data-bs-toggle="dropdown"]', function (e) {
            let dropdownEl = e.currentTarget;
            let bsDropdown = bootstrap.Dropdown.getInstance(dropdownEl);
            if (!bsDropdown) {
                bsDropdown = new bootstrap.Dropdown(dropdownEl);
                bsDropdown.toggle();
            }
        });

        // Toast Alert Session
        const swal = $('.swal').data('swal');
        if (swal) {
            Swal.fire({
                title: 'Berhasil',
                text: swal,
                icon: 'success',
                showConfirmButton: false,
                timer: 2000
            });
        }

        // Change Status via Dropdown Opsi
        $(document).on('click', '.btn-change-status', function (e) {
            e.preventDefault();

            let item = $(this);
            let id = item.data('id');
            let targetStatus = item.data('status');
            let btnMain = $('#btnStatus' + id);
            let btnLabel = btnMain.find('.status-label');

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST', // Gunakan POST agar lebih stabil melewati firewall/server
                url: '/testimonial/' + id + '/toggle-approval',
                data: {
                    _method: 'PATCH', // Trik Laravel untuk mengenali sebagai Route::patch
                    is_approved: targetStatus
                },
                dataType: 'json',
                success: function (response) {
                    // Update tampilan tombol secara realtime (gunakan == 1 / true)
                    if (response.is_approved == 1 || response.is_approved == true) {
                        btnMain.removeClass('btn-secondary').addClass('btn-success');
                        btnLabel.text('Disetujui');
                    } else {
                        btnMain.removeClass('btn-success').addClass('btn-secondary');
                        btnLabel.text('Disembunyikan');
                    }

                    // Toast Notifikasi SweetAlert
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });

                    Toast.fire({
                        icon: 'success',
                        title: response.message ||
                            'Status ulasan berhasil diperbarui!'
                    });
                },
                error: function (xhr) {
                    // Log ke console browser untuk melihat respon asli server
                    console.error('Response Server:', xhr.responseText);

                    // Ambil pesan error dari Laravel jika ada
                    let errorMessage = 'Terjadi kesalahan saat mengubah status.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: errorMessage
                    });
                }
            });
        });
    });

    // Delete Testimonial
    function deleteTestimonial(e) {
        let id = e.getAttribute('data-id');

        Swal.fire({
            title: 'Hapus Ulasan',
            text: 'Anda yakin ingin menghapus ulasan ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'DELETE',
                    url: '/testimonial/' + id,
                    dataType: 'json',
                    success: function (response) {
                        Swal.fire({
                            title: 'Berhasil',
                            text: response.message || 'Ulasan berhasil dihapus',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Gagal menghapus ulasan.'
                        });
                    }
                });
            }
        });
    }

</script>
@endpush
