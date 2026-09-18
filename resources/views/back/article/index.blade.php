@extends('back.layout.template')

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/3.0.2/css/dataTables.bootstrap5.min.css">
@endpush

@section('title', 'Daftar Article - Admin')

@section('content')

{{-- content --}}
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom" data-aos="fade-down">
        <h1 class="h2"> <i class="fas fa-list"></i> Daftar Artikel</h1>
    </div>

    {{-- success alert --}}
    <div class="swal" data-swal="{{ session('success') }}"></div>

    {{-- pesan gagal --}}
    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert"> {{ session('error') }}</div>
    @endif

    <div class="mb-3" data-aos="fade-down">
        <a href="{{ route('article.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Artikel Baru
        </a>
    </div>

    <div class="mt-3" data-aos="fade-up" data-aos-delay="150">
        <table class="table table-striped table-bordered align-middle" id="dataTable">
            <thead>
                <tr class="text-center">
                    <th width="50px">No</th>
                    <th>Gambar</th>
                    <th width="300px">Judul Artikel</th>
                    <th>Status</th>
                    <th>Dilihat</th>
                    <th>Tanggal Buat</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($articles as $article)
                <tr class="text-center">
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($article->image)
                        <img src="{{ asset('storage/back/article-images/' . $article->image) }}"
                            alt="{{ $article->title }}" class="img-thumbnail"
                            style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                        <span class="badge bg-secondary">Tanpa Foto</span>
                        @endif
                    </td>
                    <td><strong>{{ $article->title }}</strong></td>
                    <td>
                        @if($article->status == 'published')
                            <span class="badge bg-success">Publish</span>
                        @else
                            <span class="badge bg-danger">Draft</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-secondary">
                            <i class="fas fa-eye me-1"></i> {{ $article->views }} x
                        </span>
                    </td>
                    <td>{{ $article->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('article.show', $article->id) }}" class="btn btn-sm btn-info text-white">
                            <i class="fas fa-eye"></i> Detail
                        </a>
                        <a href="{{ route('article.edit', $article->id) }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <button type="button" class="btn btn-sm btn-danger" onclick="deleteArticle(this)"
                            data-id="{{ $article->id }}">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Belum ada artikel.</td>
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

<script>
    // Alert success
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

    // Fungsi Hapus Artikel via AJAX
    function deleteArticle(e) {
        let id = e.getAttribute('data-id');

        Swal.fire({
            title: 'Hapus Artikel',
            text: 'Anda yakin ingin menghapus artikel ini?',
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
                    url: '/article/' + id,
                    dataType: 'json',
                    success: function (response) {
                        Swal.fire({
                            title: 'Success',
                            text: response.message,
                            icon: 'success',
                        }).then((result) => {
                            window.location.href = '/article';
                        });
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                    }
                });
            }
        });
    }

</script>

<script>
    new DataTable('#dataTable');

</script>
@endpush
