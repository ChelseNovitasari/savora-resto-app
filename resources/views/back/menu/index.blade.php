@extends('back.layout.template')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/3.0.2/css/dataTables.bootstrap5.min.css">
@endpush

@section('title', 'Daftar Menu - Admin')

@section('content')

{{-- content --}}
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom" data-aos="fade-down">
        <h1 class="h2"> <i class="fas fa-list"></i> Daftar Menu</h1>
    </div>

    {{-- success alert --}}
    <div class="swal" data-swal="{{ session('success') }}"></div>

    {{-- pesan gagal --}}
    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"> {{ session('error') }}</div>
    @endif

    <div class="mb-3" data-aos="fade-down">
        <a href="{{ route('menu.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> Tambah Menu Baru
        </a>
    </div>

    <form action="{{ route('article.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mt-3" data-aos="fade-up" data-aos-delay="150">
        <table class="table table-striped table-bordered align-middle" id="dataTable">
            <thead>
                <tr class="text-center">
                    <th width="50px">No</th>
                    <th width="100px">Foto</th>
                    <th>Nama Menu</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($menus as $menu)
                <tr class="text-center">
                    {{-- no --}}
                    <td class="text-center">{{ $loop->iteration }}</td>

                    {{-- foto --}}
                    <td class="text-center">
                        @if ($menu->image)
                        <img src="{{ asset('storage/back/menu-images/' . $menu->image) }}" alt="{{ $menu->name }}"
                            class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                        <span class="badge bg-secondary">Tanpa Foto</span>
                        @endif
                    </td>

                    {{-- menu --}}
                    <td>
                        <strong>{{ $menu->name }}</strong>
                        @if($menu->description)
                        <br><small class="text-muted">{{ Str::limit(strip_tags($menu->description), 40) }}</small>
                        @endif
                    </td>

                    {{-- kategori --}}
                    <td class="text-center">
                        <span class="badge bg-secondary text-white">{{ $menu->category?->name ?? 'Tanpa Kategori' }}</span>
                    </td>

                    {{-- harga --}}
                    <td>Rp {{ number_format($menu->price, 0, ',', '.') }}</td>

                    {{-- status --}}
                    <td class="text-center">
                        <div class="form-check form-switch d-flex justify-content-center">
                            <input class="form-check-input status-switch" type="checkbox" role="switch"
                                data-id="{{ $menu->id }}" {{ $menu->is_available ? 'checked' : '' }}
                                style="cursor: pointer; width: 2.5em; height: 1.25em;">
                        </div>
                        <small class="status-label badge {{ $menu->is_available ? 'bg-success' : 'bg-danger' }} mt-1">
                            {{ $menu->is_available ? 'Tersedia' : 'Habis' }}
                        </small>
                    </td>

                    {{-- aksi --}}
                    <td class="text-center">
                        <a href="{{ route('menu.show', $menu->id) }}" class="btn btn-sm btn-info text-white">
                            <i class="fas fa-eye"></i> Detail
                        </a>

                        <a href="{{ route('menu.edit', $menu->id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteMenu(this)"
                            data-id="{{ $menu->id }}">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Belum ada data menu.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>
@endsection

@push('js')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/3.0.2/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/3.0.2/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- alert success --}}
<script>
    const swal = $('.swal').data('swal');

    if (swal) {
        Swal.fire({
            'title': 'Success',
            'text': swal,
            'icon': 'success',
            'showConfirmButton': false,
            'timer': 2000
        })
    }

    function deleteMenu(e) {
        let id = e.getAttribute('data-id');

        Swal.fire({
            title: 'Hapus Menu',
            text: 'Anda yakin ingin menghapus menu ini?',
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
                    url: '/menu/' + id,
                    dataType: 'json',
                    success: function (response) {
                        Swal.fire({
                            title: 'Success',
                            text: response.message,
                            icon: 'success',
                        }).then((result) => {
                            window.location.href = '/menu';
                        });
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }
        });
    }

    // A. Deteksi saat sakelar digeser/diklik
$(document).on('change', '.status-switch', function () {

    // B. Ambil data dari elemen yang diklik
    let switchInput = $(this);
    let id = switchInput.data('id');
    let label = switchInput.closest('td').find('.status-label');

    // C. Kirim data ke Laravel di latar belakang (AJAX)
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Pengaman Laravel
        },
        type: 'PATCH',
        url: '/menu/' + id + '/toggle-status',
        dataType: 'json',

        // D. Jika Laravel berhasil mengubah data di database
        success: function (response) {
            // 1. Tampilkan notifikasi melayang (Toast)
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
            });
            Toast.fire({
                icon: 'success',
                title: response.message
            });

            // 2. Ubah warna dan teks label secara langsung tanpa reload
            if (response.is_available) {
                label.removeClass('bg-danger').addClass('bg-success').text('Tersedia');
            } else {
                label.removeClass('bg-success').addClass('bg-danger').text('Habis');
            }
        },

        // E. Jika ada error (misal koneksi terputus)
        error: function (xhr) {
            // Kembalikan posisi sakelar ke posisi semula
            switchInput.prop('checked', !switchInput.is(':checked'));
            alert('Gagal mengubah status');
        }
    });
});

</script>

<script>
    new DataTable('#dataTable');

</script>
@endpush
