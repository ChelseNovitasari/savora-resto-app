@extends('back.layout.template')

@section('title', 'Detail Menu - Admin')

@section('content')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Detail Menu:</h1>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="row">
                <!-- Kolom Foto Menu -->
                <div class="col-md-4 text-center mb-3">
                    @if ($menu->image)
                        <img src="{{ asset('storage/back/menu-images/' . $menu->image) }}" alt="{{ $menu->name }}" class="img-fluid rounded shadow-sm">
                    @else
                        <div class="p-5 bg-light text-muted rounded">
                            <i class="fas fa-image fa-3x d-block mb-2"></i>
                            Tanpa Foto
                        </div>
                    @endif
                </div>

                <!-- Kolom Informasi Rincian Menu -->
                <div class="col-md-8">
                    <table class="table table-borderless">
                        <tr>
                            <th width="150px">Nama Menu</th>
                            <td>: <strong>{{ $menu->name }}</strong></td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>: <span class="badge bg-secondary text-white">{{ $menu->category?->name ?? 'Tanpa Kategori' }}</span></td>
                        </tr>
                        <tr>
                            <th>Harga</th>
                            <td>: Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Status Menu</th>
                            <td>:
                                @if ($menu->is_available)
                                    <span class="badge bg-success">Tersedia</span>
                                @else
                                    <span class="badge bg-danger">Habis</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Dibuat Pada</th>
                            <td>: {{ $menu->created_at ? $menu->created_at->format('d M Y H:i:s') : '-' }}</td>
                        </tr>
                    </table>

                    <hr>

                    <!-- Rendering Deskripsi CKEditor -->
                    <h5 class="fw-bold">Deskripsi Menu:</h5>
                    <div class="p-3 bg-light rounded border">
                        {!! $menu->description ?? '<em>Tidak ada deskripsi untuk menu ini.</em>' !!}
                    </div>

                    <!-- Tombol Akses Edit -->
                    <div class="mt-4">
                        <a href="{{ route('menu.edit', $menu->id) }}" class="btn btn-warning text-white">
                            <i class="fas fa-edit"></i> Edit Menu Ini
                        </a>

                        <a href="{{ route('menu.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
