@extends('back.layout.template')

@section('title', 'Dashboard - Admin')

@section('content')
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4 fade-in-section">
    <!-- Header Page -->
    <div class="d-flex justify-content-between align-items-center pb-3 mb-4 border-bottom header-animate">
        <div>
            <h1 class="h3 fw-bold text-dark m-0"><i class="fas fa-chart-line text-primary me-2"></i>Dashboard Admin</h1>
            <p class="text-muted small m-0 mt-1">Ringkasan statistik dan aktivitas menu terbaru restoran Anda.</p>
        </div>
        <div>
            <span class="badge bg-white text-dark border p-2 shadow-sm rounded-3">
                <i class="far fa-calendar-alt me-1 text-primary"></i> {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
            </span>
        </div>
    </div>

    <!-- Metric Cards Grid -->
    <div class="row g-3 mb-4">
        <!-- Total Artikel -->
        <div class="col-12 col-sm-6 col-xl-3 card-item" style="--delay: 1;">
            <div class="card border-0 shadow-sm rounded-4 h-100 custom-card">
                <div class="card-body p-4 border-start border-primary border-4 rounded-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted text-uppercase fw-semibold small">Total Artikel</span>
                            <h2 class="fw-bold text-dark mt-2 mb-0 stat-number" data-target="{{ $total_artikel }}">0</h2>
                        </div>
                        <div class="icon-box bg-primary bg-opacity-10 text-primary rounded-3 p-3 fs-3">
                            <i class="fas fa-newspaper"></i>
                        </div>
                    </div>
                    <a href="{{ url('article') }}" class="text-primary text-decoration-none small fw-semibold d-inline-flex align-items-center mt-3 card-link">
                        Lihat Detail <i class="fas fa-arrow-right ms-1 link-arrow"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Total Menu -->
        <div class="col-12 col-sm-6 col-xl-3 card-item" style="--delay: 2;">
            <div class="card border-0 shadow-sm rounded-4 h-100 custom-card">
                <div class="card-body p-4 border-start border-warning border-4 rounded-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted text-uppercase fw-semibold small">Total Menu</span>
                            <h2 class="fw-bold text-dark mt-2 mb-0 stat-number" data-target="{{ $total_menu }}">0</h2>
                        </div>
                        <div class="icon-box bg-warning bg-opacity-10 text-warning rounded-3 p-3 fs-3">
                            <i class="fas fa-utensils"></i>
                        </div>
                    </div>
                    <a href="{{ url('menu') }}" class="text-warning text-decoration-none small fw-semibold d-inline-flex align-items-center mt-3 card-link">
                        Lihat Detail <i class="fas fa-arrow-right ms-1 link-arrow"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Total Reservasi -->
        <div class="col-12 col-sm-6 col-xl-3 card-item" style="--delay: 3;">
            <div class="card border-0 shadow-sm rounded-4 h-100 custom-card">
                <div class="card-body p-4 border-start border-success border-4 rounded-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted text-uppercase fw-semibold small">Total Reservasi</span>
                            <h2 class="fw-bold text-dark mt-2 mb-0 stat-number" data-target="{{ $total_reservasi }}">0</h2>
                        </div>
                        <div class="icon-box bg-success bg-opacity-10 text-success rounded-3 p-3 fs-3">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                    </div>
                    <a href="{{ url('reservation') }}" class="text-success text-decoration-none small fw-semibold d-inline-flex align-items-center mt-3 card-link">
                        Lihat Detail <i class="fas fa-arrow-right ms-1 link-arrow"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Total Testimoni -->
        <div class="col-12 col-sm-6 col-xl-3 card-item" style="--delay: 4;">
            <div class="card border-0 shadow-sm rounded-4 h-100 custom-card">
                <div class="card-body p-4 border-start border-secondary border-4 rounded-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted text-uppercase fw-semibold small">Total Testimoni</span>
                            <h2 class="fw-bold text-dark mt-2 mb-0 stat-number" data-target="{{ $total_testimoni }}">0</h2>
                        </div>
                        <div class="icon-box bg-secondary bg-opacity-10 text-secondary rounded-3 p-3 fs-3">
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <a href="{{ url('testimonial') }}" class="text-secondary text-decoration-none small fw-semibold d-inline-flex align-items-center mt-3 card-link">
                        Lihat Detail <i class="fas fa-arrow-right ms-1 link-arrow"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Menu Terbaru Card -->
    <div class="card border-0 shadow-sm rounded-4 table-card-animate">
        <div class="card-header bg-white py-3 px-4 border-bottom-0 rounded-top-4 d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold text-dark m-0"><i class="fas fa-concierge-bell me-2 text-warning"></i>Daftar Menu Terbaru</h5>
                <small class="text-muted">Menu makanan dan minuman yang baru saja dirilis.</small>
            </div>
            <a href="{{ url('menu') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-semibold hover-btn">
                Kelola Semua Menu
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center py-3 px-3">No</th>
                            <th class="text-center py-3">Gambar</th>
                            <th class="py-3">Nama Menu</th>
                            <th class="text-center py-3">Kategori</th>
                            <th class="py-3">Harga</th>
                            <th class="text-center py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($menus as $menu)
                        <tr class="row-animate" style="--row-delay: {{ $loop->iteration }};">
                            <td class="text-center fw-semibold text-muted px-3">{{ $loop->iteration }}</td>

                            <td class="text-center">
                                @if ($menu->image)
                                    <img src="{{ asset('storage/back/menu-images/' . $menu->image) }}" alt="{{ $menu->name }}"
                                        class="rounded-3 shadow-sm border img-hover" style="width: 55px; height: 55px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded-3 border d-flex align-items-center justify-content-center mx-auto" style="width: 55px; height: 55px;">
                                        <i class="fas fa-image text-muted fs-4"></i>
                                    </div>
                                @endif
                            </td>

                            <td>
                                <span class="fw-bold text-dark d-block">{{ $menu->name }}</span>
                                @if($menu->description)
                                    <small class="text-muted">{!! Str::limit(strip_tags($menu->description), 45) !!}</small>
                                @endif
                            </td>

                            <td class="text-center">
                                <span class="badge bg-info bg-opacity-10 text-info fw-semibold px-3 py-2 rounded-pill">
                                    {{ $menu->category?->name ?? 'Uncategorized' }}
                                </span>
                            </td>

                            <td class="fw-bold text-dark">
                                Rp {{ number_format($menu->price, 0, ',', '.') }}
                            </td>

                            <td class="text-center">
                                <div class="form-check form-switch d-flex justify-content-center mb-1">
                                    <input class="form-check-input status-switch" type="checkbox" role="switch"
                                        data-id="{{ $menu->id }}" {{ $menu->is_available ? 'checked' : '' }}
                                        style="cursor: pointer; width: 2.2em; height: 1.1em;">
                                </div>
                                <span class="status-label badge {{ $menu->is_available ? 'bg-success-subtle text-success border border-success' : 'bg-danger-subtle text-danger border border-danger' }} rounded-pill px-2">
                                    {{ $menu->is_available ? 'Tersedia' : 'Habis' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-5">
                                <i class="fas fa-utensils fs-1 d-block mb-2 text-secondary opacity-50"></i>
                                Belum ada data menu yang tersedia.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

{{-- Custom Styling Animasi --}}
<style>
    /* 1. Animation Entry Fade-In Slide-Up */
    .header-animate {
        animation: fadeInDown 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .card-item {
        opacity: 0;
        animation: fadeInUp 0.5s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        animation-delay: calc(var(--delay) * 0.1s);
    }

    .table-card-animate {
        opacity: 0;
        animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        animation-delay: 0.45s;
    }

    .row-animate {
        opacity: 0;
        animation: fadeIn 0.4s ease forwards;
        animation-delay: calc(0.5s + (var(--row-delay) * 0.05s));
    }

    /* Keyframes */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-15px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeIn {
        to { opacity: 1; }
    }

    /* 2. Micro Interactions (Hover Effects) */
    .custom-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .custom-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
    }

    .custom-card:hover .icon-box {
        transform: scale(1.1) rotate(5deg);
    }

    .icon-box {
        transition: transform 0.3s ease;
    }

    .card-link:hover .link-arrow {
        transform: translateX(4px);
    }

    .link-arrow {
        transition: transform 0.2s ease;
    }

    .img-hover {
        transition: transform 0.25s ease;
    }

    .img-hover:hover {
        transform: scale(1.08);
    }
</style>

{{-- JavaScript untuk Number Counter Up --}}
@push('js')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const counters = document.querySelectorAll('.stat-number');
    const speed = 30; // Kecepatan hitung

    counters.forEach(counter => {
        const updateCount = () => {
            const target = +counter.getAttribute('data-target');
            const count = +counter.innerText;
            const increment = Math.ceil(target / speed) || 1;

            if (count < target) {
                counter.innerText = count + increment > target ? target : count + increment;
                setTimeout(updateCount, 25);
            } else {
                counter.innerText = target;
            }
        };

        // Mulai animasi hitung angka setelah card muncul
        setTimeout(updateCount, 200);
    });
});
</script>
@endpush
@endsection
