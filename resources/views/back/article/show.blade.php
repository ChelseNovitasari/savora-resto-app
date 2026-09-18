@extends('back.layout.template')

@section('title', 'Detail Artikel - Admin')

@section('content')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div
        class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Detail Artikel:</h1>
    </div>
    <form action="{{ url('article') }}" method="POST">
        @csrf

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="row">
                <!-- Kolom Foto Artikel -->
                <div class="col-md-4 text-center mb-3">
                    @if ($article->image)
                    <img src="{{ asset('storage/back/article-images/' . $article->image) }}" alt="{{ $article->title }}"
                        class="img-fluid rounded shadow-sm">
                    @else
                    <div class="p-5 bg-light text-muted rounded">
                        <i class="fas fa-image fa-3x d-block mb-2"></i>
                        Tanpa Foto
                    </div>
                    @endif
                </div>

                <!-- Kolom Informasi Rincian Artikel -->
                <div class="col-md-8">
                    <table class="table table-borderless">
                        <tr>
                            <th width="150px">Judul Artikel</th>
                            <td>: <strong>{{ $article->title }}</strong></td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>: {{ $article->status }}</>
                            </td>
                        </tr>

                        <tr>
                            <th>Dilihat</th>
                            <td>: {{ $article->views }} x</td>
                        </tr>

                        <tr>
                            <th>Dibuat Pada</th>
                            <td>: {{ $article->created_at->format('d M Y H:i:s') }}</td>
                        </tr>
                    </table>

                    <hr>

                    <!-- Rendering Deskripsi CKEditor -->
                    <h5 class="fw-bold">Deskripsi Artikel:</h5>
                    <div class="p-3 bg-light rounded border">
                        {!! $article->content !!}
                    </div>

                    <!-- Tombol Akses Edit -->
                    <div class="mt-4">
                        <a href="{{ route('article.edit', $article->id) }}" class="btn btn-warning text-white">
                            <i class="fas fa-edit"></i> Edit Artikel Ini
                        </a>

                        <a href="{{ route('article.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
</main>
@endsection
