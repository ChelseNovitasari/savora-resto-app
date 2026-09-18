@extends('layouts.frontend')

@section('title', 'Savora Junction Resto - Cita Rasa Otentik & Suasana Nyaman')

@section('content')

{{-- Hero Header --}}
<div class="hero-header-wrapper bg-dark text-white position-relative overflow-hidden mb-5">
    <div class="position-absolute top-50 start-50 translate-middle rounded-circle bg-warning opacity-25"
        style="width: 450px; height: 450px; filter: blur(90px); pointer-events: none;"></div>

    <div class="container position-relative z-1 text-center" style="padding-top: 7rem; padding-bottom: 4rem;"
        data-aos="fade-down" data-aos-duration="800">
        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold text-uppercase mb-3 shadow-sm">
            <i class="fas fa-utensils me-1"></i> Special Menu
        </span>
        <h1 class="fw-bold text-warning display-5 mb-2">Semua Daftar Menu</h1>
        <p class="text-light opacity-75 mx-auto mb-0" style="max-width: 600px;">
            Daftar lengkap seluruh hidangan lezat dan minuman segar pilihan kami untuk Anda.
        </p>
    </div>
</div>

<div class="container pb-5">
    <!-- Grid Daftar Semua Menu -->
    <div class="row g-4">
        @forelse($menus as $menu)
        <div class="col-md-6 col-lg-4"
             data-aos="fade-up"
             data-aos-duration="800"
             data-aos-delay="{{ ($loop->iteration % 3) * 100 }}">
            <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden card-menu">
                @if(is_object($menu->category) && $menu->category->name == 'Paket Spesial')
                <span class="badge bg-warning text-dark position-absolute top-0 end-0 m-3 px-3 py-2 fw-bold rounded-pill shadow-sm">PROMO</span>
                @endif

                <img src="{{ asset('storage/back/menu-images/' . $menu->image) }}" class="card-img-top"
                    style="height: 200px; object-fit: cover;" alt="{{ $menu->name }}"
                    onerror="this.onerror=null; this.src='https://placehold.co/300x200?text=Savora+Resto';">

                <div class="card-body d-flex flex-column p-4">
                    <span class="badge bg-light text-secondary border mb-2 align-self-start rounded-pill px-3 py-1">
                        {{ is_object($menu->category) ? $menu->category->name : ($menu->category ?? 'Umum') }}
                    </span>
                    <h5 class="card-title fw-bold mb-1">{{ $menu->name }}</h5>
                    <p class="card-text text-muted small flex-grow-1">
                        {{ Str::limit($menu->description, 60) }}
                    </p>

                    {{-- Link Lihat Selengkapnya (Memicu Modal Detail) --}}
                    <div class="mb-3">
                        <a href="#" class="text-warning text-decoration-none fw-semibold small" data-bs-toggle="modal"
                            data-bs-target="#modalDetailMenu{{ $menu->id }}">
                            Lihat Selengkapnya <i class="fas fa-chevron-right ms-1"></i>
                        </a>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-3 border-top mt-3">
                        <span class="fw-bold text-dark fs-5">Rp {{ number_format($menu->price, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center text-muted py-5" data-aos="fade-up">
            <h5>Belum ada menu yang tersedia.</h5>
        </div>
        @endforelse
    </div>

    <!-- Paginasi -->
    <div class="d-flex justify-content-center mt-5" data-aos="fade-up">
        {{ $menus->links() }}
    </div>

    <div class="text-center mt-4" data-aos="fade-up">
        <a href="{{ url('/') }}" class="btn btn-outline-secondary px-4 py-2 rounded-pill shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda
        </a>
    </div>
</div>

{{-- Modal Detail Menu diletakkan di luar loop utama agar struktur HTML tetap bersih --}}
@foreach($menus as $menu)
<div class="modal fade" id="modalDetailMenu{{ $menu->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <img src="{{ asset('storage/back/menu-images/' . $menu->image) }}" class="img-fluid rounded-4 mb-3"
                    style="max-height: 250px; width: 100%; object-fit: cover;" alt="{{ $menu->name }}"
                    onerror="this.onerror=null; this.src='https://placehold.co/400x250?text=Detail+Menu';">

                <h4 class="fw-bold mb-2">{{ $menu->name }}</h4>

                <span class="badge bg-warning text-dark rounded-pill px-3 py-1 mb-3">
                    {{ is_object($menu->category) ? ($menu->category->name ?? $menu->category->nama_kategori) : ($menu->category ?? 'Umum') }}
                </span>

                <p class="text-muted mb-3">{{ $menu->description }}</p>

                <h3 class="fw-bold text-warning mb-4">Rp {{ number_format($menu->price, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
