@extends('layouts.frontend')

@section('title', 'Savora Junction Resto - Cita Rasa Otentik & Suasana Nyaman')

@section('content')

<style>
    /* Styling Tambahan UI Landing Page */
    .hero-section {
        background: linear-gradient(180deg, rgba(18, 18, 18, 0.6) 0%, rgba(18, 18, 18, 0.85) 100%),
            url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=1400') center/cover no-repeat;
        color: white;
        padding: 120px 0 80px 0;
    }

    .card-menu {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        border: 1px solid rgba(0, 0, 0, 0.06) !important;
    }

    .card-menu:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
    }

    .nav-pills .nav-link {
        color: #495057;
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        font-weight: 600;
        padding: 0.55rem 1.25rem;
        transition: all 0.2s ease;
    }

    .nav-pills .nav-link.active {
        background-color: #ffc107 !important;
        color: #121212 !important;
        border-color: #ffc107 !important;
        box-shadow: 0 4px 10px rgba(255, 193, 7, 0.3);
    }

    .btn-whatsapp {
        background-color: #25D366;
        color: white;
        font-weight: 600;
        border: none;
    }

    .btn-whatsapp:hover {
        background-color: #1ebc57;
        color: white;
    }

    .form-control-custom {
        border-radius: 10px;
        padding: 0.75rem 1rem;
        border: 1px solid #dee2e6;
    }

    .form-control-custom:focus {
        border-color: #ffc107;
        box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
    }

</style>

<section class="hero-section text-center d-flex align-items-center position-relative">
    <div class="container py-5">
        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold text-uppercase mb-3"
              data-aos="zoom-in"
              data-aos-delay="100">
            Authentic Culinary Experience
        </span>

        <h1 class="display-3 fw-extrabold mb-3 text-white"
            data-aos="fade-down"
            data-aos-delay="200">
            Savora Junction Resto
        </h1>

        <p class="lead mb-4 col-lg-7 mx-auto text-light opacity-90"
           data-aos="fade-up"
           data-aos-delay="300">
            Nikmati kelezatan hidangan istimewa dengan bahan baku segar berkualitas, diracik oleh koki profesional dalam suasana yang hangat dan ramah.
        </p>

        <div class="d-flex justify-content-center gap-3 flex-wrap"
             data-aos="zoom-in-up"
             data-aos-delay="400">
            <a href="#menu" class="btn btn-warning btn-lg fw-bold px-4 py-3 rounded-pill shadow-sm">
                <i class="fas fa-utensils me-2"></i>Jelajahi Menu
            </a>
            <a href="#reservasi" class="btn btn-outline-light btn-lg fw-bold px-4 py-3 rounded-pill">
                <i class="fas fa-calendar-alt me-2"></i>Reservasi Meja
            </a>
        </div>
    </div>
</section>

<section class="py-5" id="menu">
    <div class="container py-4">
        <div class="text-center mb-5" data-aos="fade-down">
            <span class="text-warning fw-bold text-uppercase tracking-wider">Katalog Produk</span>
            <h2 class="fw-bold fs-1 mt-1">Pilihan Menu Terbaik Kami</h2>
            <p class="text-muted">Jelajahi kelezatan hidangan pembuka, hidangan utama, cemilan, hingga paket promo hemat kami.</p>
        </div>

        <ul class="nav nav-pills justify-content-center gap-2 mb-5" id="menuTabs" role="tablist" data-aos="zoom-in" data-aos-delay="100">
            {{-- Tombol 'Semua Menu' --}}
            <li class="nav-item" role="presentation">
                <button class="nav-link active rounded-pill px-4 fw-bold shadow-sm" id="all-tab" data-bs-toggle="pill"
                    data-bs-target="#menu-all" type="button" role="tab">
                    Semua Menu
                </button>
            </li>

            @foreach($categories as $cat)
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill px-4 fw-semibold" id="tab-{{ Str::slug($cat->name) }}"
                    data-bs-toggle="pill" data-bs-target="#menu-{{ Str::slug($cat->name) }}" type="button" role="tab">
                    {{ $cat->name }}
                </button>
            </li>
            @endforeach
        </ul>

        <div class="tab-content" id="menuTabsContent">

            {{-- 1. TAB SEMUA MENU --}}
            <div class="tab-pane fade show active" id="menu-all">
                <div class="row g-4">
                    @forelse($menus->take(6) as $index => $menu)
                    <div class="col-md-6 col-lg-4"
                         data-aos="fade-up"
                         data-aos-delay="{{ ($loop->iteration % 3 == 0 ? 3 : $loop->iteration % 3) * 100 }}">
                        <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden card-menu">
                            @if(is_object($menu->category) && $menu->category->name == 'Paket Spesial')
                            <span
                                class="badge bg-warning text-dark position-absolute top-0 end-0 m-3 px-3 py-2 fw-bold rounded-pill shadow-sm">PROMO</span>
                            @endif
                            <img src="{{ asset('storage/back/menu-images/' . $menu->image) }}" class="card-img-top"
                                style="height: 200px; object-fit: cover;" alt="{{ $menu->name }}"
                                onerror="this.onerror=null; this.src='https://placehold.co/300x200?text=Savora+Resto';">

                            <div class="card-body d-flex flex-column p-4">
                                <span
                                    class="badge bg-light text-secondary border mb-2 align-self-start rounded-pill px-3 py-1">
                                    {{ is_object($menu->category) ? $menu->category->name : ($menu->category ?? 'Umum') }}
                                </span>
                                <h5 class="card-title fw-bold mb-1">{{ $menu->name }}</h5>
                                <p class="card-text text-muted small flex-grow-1">
                                    {{ Str::limit($menu->description, 60) }}</p>

                                <div class="mb-3">
                                    <a href="#" class="text-warning text-decoration-none fw-semibold small"
                                        data-bs-toggle="modal" data-bs-target="#modalDetailMenu{{ $menu->id }}">
                                        Lihat Selengkapnya <i class="fas fa-chevron-right ms-1"></i>
                                    </a>
                                </div>

                                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                    <span class="fw-bold text-dark fs-5">Rp
                                        {{ number_format($menu->price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center text-muted py-5">Belum ada data menu tersedia.</div>
                    @endforelse
                </div>

                @if($menus->count() > 6)
                <div class="text-center mt-5" data-aos="zoom-in" data-aos-delay="200">
                    <a href="{{ route('menus.index') }}"
                        class="btn btn-outline-warning text-dark fw-bold px-4 py-2 rounded-pill shadow-sm">
                        Lihat Semua Menu <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
                @endif
            </div>

            {{-- 2. TAB SEMUA KATEGORI DINAMIS --}}
            @foreach($categories as $cat)
            <div class="tab-pane fade" id="menu-{{ Str::slug($cat->name) }}">
                <div class="row g-4">
                    @forelse($menus->filter(fn($m) => (is_object($m->category) ? $m->category->id : null) == $cat->id)
                    as $menu)
                    <div class="col-md-6 col-lg-4"
                         data-aos="fade-up"
                         data-aos-delay="{{ ($loop->iteration % 3 == 0 ? 3 : $loop->iteration % 3) * 100 }}">
                        <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden card-menu">
                            <img src="{{ asset('storage/back/menu-images/' . $menu->image) }}" class="card-img-top"
                                style="height: 200px; object-fit: cover;" alt="{{ $menu->name }}"
                                onerror="this.onerror=null; this.src='https://placehold.co/300x200?text={{ urlencode($cat->name) }}';">

                            <div class="card-body d-flex flex-column p-4">
                                <span
                                    class="badge bg-light text-secondary border mb-2 align-self-start rounded-pill px-3 py-1">
                                    {{ $cat->name }}
                                </span>
                                <h5 class="card-title fw-bold mb-1">{{ $menu->name }}</h5>
                                <p class="card-text text-muted small flex-grow-1">
                                    {{ Str::limit($menu->description, 60) }}</p>
                                <a href="#" class="text-warning text-decoration-none fw-semibold small mb-3"
                                    data-bs-toggle="modal" data-bs-target="#modalDetailMenu{{ $menu->id }}">
                                    Lihat Selengkapnya <i class="fas fa-chevron-right ms-1"></i>
                                </a>
                                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                                    <span class="fw-bold text-dark fs-5">Rp
                                        {{ number_format($menu->price, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-12 text-center text-muted py-5">Belum ada daftar menu untuk kategori {{ $cat->name }}.</div>
                    @endforelse
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>

@foreach($menus as $menu)
<div class="modal fade" id="modalDetailMenu{{ $menu->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <img src="{{ asset('storage/back/menu-images/' . $menu->image) }}" class="img-fluid rounded-4 mb-3"
                    style="max-height: 250px; width: 100%; object-fit: cover;"
                    onerror="this.onerror=null; this.src='https://placehold.co/400x250?text=Detail+Menu';">
                <h4 class="fw-bold mb-2">{{ $menu->name }}</h4>
                <span class="badge bg-warning text-dark rounded-pill px-3 py-1 mb-3">
                    {{ is_object($menu->category) ? ($menu->category->name ?? $menu->category->nama_kategori) : ($menu->category ?? 'Umum') }}
                </span>
                <p class="text-muted">{{ $menu->description }}</p>
                <h3 class="fw-bold text-warning mb-4">Rp {{ number_format($menu->price, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
</div>
@endforeach

<section class="py-5 bg-light" id="artikel">
    <div class="container py-4">
         <div class="text-center mb-5" data-aos="fade-down">
            <span class="text-warning fw-bold text-uppercase tracking-wider">Berita & Events</span>
            <h2 class="fw-bold fs-1 mt-1">Artikel & Informasi Promo</h2>
            <p class="text-muted">Dapatkan info penawaran menarik, diskon spesial, dan tips seputar kuliner.</p>
        </div>

        <div class="row g-4">
            @forelse($articles as $article)
             <div class="col-md-4"
                 data-aos="fade-up"
                 data-aos-delay="{{ ($loop->iteration % 3 == 0 ? 3 : $loop->iteration % 3) * 100 }}">
                <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden card-menu">
                    <img src="{{ asset('storage/back/article-images/' . $article->image) }}" class="card-img-top"
                        style="height: 200px; object-fit: cover;" alt="{{ $article->title }}"
                        onerror="this.onerror=null; this.src='https://placehold.co/300x200?text=Artikel';">
                    <div class="card-body d-flex flex-column p-4">
                        <span class="text-muted small mb-2 d-flex align-items-center">
                            <i class="fas fa-calendar-alt text-warning me-2"></i>
                            {{ \Carbon\Carbon::parse($article->created_at)->translatedFormat('d M Y') }}
                        </span>
                        <h5 class="card-title fw-bold mb-2">{{ $article->title }}</h5>
                        <p class="card-text text-muted small flex-grow-1">
                            {{ Str::limit(strip_tags($article->content), 100) }}</p>
                        <a href="{{ route('articles.show', $article->slug) }}"
                            class="text-warning text-decoration-none fw-semibold small">
                            Lihat Selengkapnya <i class="fas fa-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center text-muted py-5" data-aos="zoom-in">Belum ada artikel promo terbaru.</div>
            @endforelse
        </div>
    </div>
</section>

<section class="py-5" id="reservasi">
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-9" data-aos="zoom-in-up" data-aos-duration="900">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                    <div class="card-header bg-dark text-white text-center py-4 border-0">
                        <h3 class="fw-bold mb-1 text-warning">
                            <i class="fas fa-calendar-check me-2"></i>Reservasi Meja Online
                        </h3>
                        <p class="mb-0 text-secondary small">Isi formulir dan pilih menu pesanan Anda secara rinci.</p>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        @if($errors->has('table_number'))
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 mb-4" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ $errors->first('table_number') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @endif

                        <form action="{{ route('reservation.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">Nama Lengkap</label>
                                    <input type="text" name="name" class="form-control form-control-custom"
                                        placeholder="Masukkan Nama Anda..." value="{{ old('name') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">Nomor WhatsApp</label>
                                    <input type="text" name="phone" class="form-control form-control-custom"
                                        placeholder="Masukkan No. Tlp / WA..." value="{{ old('phone') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">Tanggal Kedatangan</label>
                                    <input type="date" name="reservation_date" class="form-control form-control-custom"
                                        min="{{ date('Y-m-d') }}" value="{{ old('reservation_date') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">Jam Kedatangan</label>
                                    <input type="time" name="reservation_time" class="form-control form-control-custom"
                                        value="{{ old('reservation_time') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">Pilih Meja</label>
                                    <select name="table_number" class="form-select form-control-custom" required>
                                        <option value="" disabled selected>-- Pilih Nomor Meja --</option>
                                        @for($i = 1; $i <= 10; $i++) <option value="{{ $i }}"
                                            {{ old('table_number') == $i ? 'selected' : '' }}>
                                            Meja {{ $i }}
                                            </option>
                                            @endfor
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold small">Jumlah Tamu (Orang)</label>
                                    <input type="number" name="guest_count" class="form-control form-control-custom"
                                        min="1" max="20" placeholder="Jumlah orang" value="{{ old('guest_count') }}"
                                        required>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-semibold small">Catatan Khusus (Opsional)</label>
                                    <input type="text" name="notes" class="form-control form-control-custom"
                                        placeholder="Catatan..." value="{{ old('notes') }}">
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label fw-semibold small">Upload Bukti Pembayaran / Transfer
                                        (Opsional)</label>
                                    <input type="file" class="form-control" id="payment_proof" name="payment_proof"
                                        accept="image/*">
                                    <small class="text-muted">Format: JPG, JPEG, PNG (Maksimal 2MB)</small>
                                </div>

                                <div class="col-12 mt-4">
                                    <label class="form-label fw-bold text-dark d-block border-bottom pb-2 mb-3">
                                        <i class="fas fa-utensils text-warning me-2"></i>Pre-Order Menu (Opsional)
                                    </label>
                                    <p class="text-muted small">Pilih menu dan masukkan jumlah porsi yang ingin Anda
                                        pesan lebih awal:</p>

                                    @php
                                    $groupedMenus = $menus->groupBy(function($item) {
                                    return is_object($item->category) ? ($item->category->name ??
                                    $item->category->nama_kategori) : $item->category;
                                    });
                                    @endphp

                                    <div class="accordion" id="accordionMenuReservasi">
                                        @foreach($groupedMenus as $catName => $items)
                                        <div class="accordion-item border rounded-3 mb-2 overflow-hidden">
                                            <h2 class="accordion-header" id="headingCat{{ $loop->index }}">
                                                <button class="accordion-button collapsed fw-bold text-dark bg-light"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapseCat{{ $loop->index }}"
                                                    aria-expanded="false">
                                                    {{ $catName ?? 'Umum' }} ({{ count($items) }} Menu)
                                                </button>
                                            </h2>
                                            <div id="collapseCat{{ $loop->index }}" class="accordion-collapse collapse"
                                                data-bs-parent="#accordionMenuReservasi">
                                                <div class="accordion-body p-3">
                                                    <div class="row g-3">
                                                        @foreach($items as $menuItem)
                                                        <div class="col-md-6">
                                                            <div
                                                                class="d-flex align-items-center justify-content-between p-2 border rounded-3 bg-white">
                                                                <div class="me-2">
                                                                    <div class="fw-semibold small text-dark">
                                                                        {{ $menuItem->name }}</div>
                                                                    <div class="text-warning fw-bold small">
                                                                        Rp
                                                                        {{ number_format($menuItem->price, 0, ',', '.') }}
                                                                    </div>
                                                                </div>
                                                                <div style="width: 90px;">
                                                                    <input type="number"
                                                                        name="menu_items[{{ $menuItem->id }}]"
                                                                        data-price="{{ $menuItem->price }}"
                                                                        class="form-control form-control-sm text-center menu-qty-input"
                                                                        min="0" value="0">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                    {{-- Total Estimasi Biaya Pre-order --}}
                                    <div
                                        class="alert alert-warning d-flex justify-content-between align-items-center mt-3 mb-0 rounded-3">
                                        <span class="fw-bold small text-dark">Estimasi Total Pre-Order:</span>
                                        <span class="fw-bold h5 mb-0 text-dark" id="displayTotalPrice">Rp 0</span>
                                    </div>
                                </div>

                                <div class="col-12 mt-4">
                                    <button type="submit"
                                        class="btn btn-warning btn-lg fw-bold w-100 py-3 rounded-pill shadow-sm">
                                        <i class="fas fa-paper-plane me-2"></i>Kirim Booking Meja Via WhatsApp
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container py-4">
    <div class="row justify-content-center">
         <div class="col-lg-7 col-md-9" data-aos="fade-up" data-aos-duration="800">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                   <div class="card-header bg-dark text-white p-4 border-0 position-relative">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning text-dark rounded-circle p-3 me-3 d-flex align-items-center justify-content-center"
                            style="width: 50px; height: 50px;">
                            <i class="fas fa-star fa-lg"></i>
                        </div>
                        <div>
                            <h4 class="mb-1 fw-bold text-warning">Beri Ulasan Kunjungan</h4>
                            <p class="mb-0 text-white-50 small">Bagikan pengalaman santap Anda di Savora Junction Resto
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Body Card Form -->
                <div class="card-body p-4 p-md-5 bg-white">

                    {{-- Alert Notifikasi Success / Error --}}
                    @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm rounded-3 d-flex align-items-center mb-4">
                        <i class="fas fa-check-circle me-2 fa-lg"></i>
                        <div>{{ session('success') }}</div>
                    </div>
                    @endif

                    @if($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('testimonial.store') }}" method="POST">
                        @csrf

                        <!-- Kode Reservasi -->
                        <div class="mb-4">
                            <label for="reservation_code" class="form-label fw-semibold text-dark">
                                <i class="fas fa-ticket-alt text-warning me-1"></i> Kode Reservasi
                            </label>
                            <input type="text" name="reservation_code" id="reservation_code"
                                class="form-control form-control-lg rounded-3 border-2"
                                placeholder="Contoh: RES-20260916-8QBU" value="{{ old('reservation_code') }}" required>
                            <div class="form-text text-muted mt-1">
                                <i class="fas fa-info-circle me-1"></i> Masukkan kode dari reservasi Anda yang sudah
                                selesai.
                            </div>
                        </div>

                        <!-- Rating -->
                        <div class="mb-4">
                            <label for="rating" class="form-label fw-semibold text-dark">
                                <i class="fas fa-smile text-warning me-1"></i> Rating Kepuasan
                            </label>
                            <select name="rating" id="rating" class="form-select form-select-lg rounded-3 border-2"
                                required>
                                <option value="5" {{ old('rating') == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ — 5/5 (Sangat Puas)
                                </option>
                                <option value="4" {{ old('rating', '4') == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ — 4/5 (Puas)
                                </option>
                                <option value="3" {{ old('rating') == '3' ? 'selected' : '' }}>⭐⭐⭐ — 3/5 (Cukup)
                                </option>
                                <option value="2" {{ old('rating') == '2' ? 'selected' : '' }}>⭐⭐ — 2/5 (Kurang)
                                </option>
                                <option value="1" {{ old('rating') == '1' ? 'selected' : '' }}>⭐ — 1/5 (Sangat Kurang)
                                </option>
                            </select>
                        </div>

                        <!-- Ulasan / Pesan -->
                        <div class="mb-4">
                            <label for="comment" class="form-label fw-semibold text-dark">
                                <i class="fas fa-comment-dots text-warning me-1"></i> Ulasan / Pesan
                            </label>
                            <textarea name="comment" id="comment" class="form-control rounded-3 border-2" rows="4"
                                placeholder="Tuliskan pengalaman mengenai pelayanan, rasa makanan, atau suasana resto..."
                                required>{{ old('comment') }}</textarea>
                        </div>

                        <!-- Tombol Submit -->
                        <button type="submit"
                            class="btn btn-warning btn-lg w-100 fw-bold rounded-3 text-dark shadow-sm py-3 mt-2">
                            <i class="fas fa-paper-plane me-2"></i> Kirim Testimoni
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        function calculateTotal() {
            const qtyInputs = document.querySelectorAll('.menu-qty-input');
            const displayTotal = document.getElementById('displayTotalPrice');
            let total = 0;

            qtyInputs.forEach(input => {
                const qty = parseFloat(input.value) || 0;
                const price = parseFloat(input.getAttribute('data-price')) || 0;
                total += qty * price;
            });

            if (displayTotal) {
                displayTotal.textContent = 'Rp ' + total.toLocaleString('id-ID');
            }
        }

        // Event delegation agar membaca input angka (ketik maupun klik panah up/down)
        document.addEventListener('input', function (e) {
            if (e.target && e.target.classList.contains('menu-qty-input')) {
                calculateTotal();
            }
        });

        document.addEventListener('change', function (e) {
            if (e.target && e.target.classList.contains('menu-qty-input')) {
                calculateTotal();
            }
        });
    });

</script>

<section class="py-5 bg-light" id="testimoni">
    <div class="container py-4">
          <div class="text-center mb-5" data-aos="fade-up" data-aos-duration="800">
            <span class="text-warning fw-bold text-uppercase tracking-wider">Ulasan Pengunjung</span>
            <h2 class="fw-bold fs-1 mt-1">Apa Kata Mereka?</h2>
        </div>

        <div class="row g-4">
            @forelse ($testimonials as $testimonial)
                <div class="col-md-4 mb-4"
                 data-aos="fade-up"
                 data-aos-duration="800"
                 data-aos-delay="{{ $loop->iteration * 100 }}">
                <div class="card h-100 shadow-sm border-0 p-3">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <!-- Nama Pelanggan -->
                            <div>
                                <h6 class="fw-bold mb-1 text-dark">
                                    — {{ $testimonial->customer_name }}
                                </h6>
                            </div>

                            <!-- Rating Bintang -->
                            <div class="border-top mt-2 text-warning mb-1 fs-5">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $testimonial->rating)
                                        ★
                                    @else
                                        <span class="text-muted opacity-25">☆</span>
                                    @endif
                                @endfor
                            </div>

                            <!-- Komentar -->
                            <p class="card-text text-muted fst-italic mt-1">
                                "{{ $testimonial->comment }}"
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center text-muted" data-aos="fade-up">
                <p>Belum ada ulasan yang ditampilkan.</p>
            </div>
            @endforelse
        </div>

        <!-- Tombol Ke Halaman Khusus Testimoni -->
        <div class="text-center mt-4" data-aos="zoom-in" data-aos-delay="300">
            <a href="{{ route('testimonials.index') }}" class="btn btn-outline-warning rounded-pill px-4">
                Lihat Semua Ulasan <i class="fas fa-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>

<section class="py-5 bg-light border-top" id="lokasi">
    <div class="container py-4">
        <div class="text-center mb-5" data-aos="fade-up">
            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold text-uppercase mb-2 shadow-sm">
                <i class="fas fa-map-marker-alt me-1"></i> Lokasi Resto
            </span>
            <h2 class="fw-bold text-dark display-6">Kunjungi Savora Junction</h2>
            <p class="text-muted mx-auto" style="max-width: 600px;">
                Temukan lokasi kami dan nikmati suasana santap hidangan lezat secara langsung bersama keluarga dan
                kerabat.
            </p>
        </div>

        <div class="row g-4 align-items-stretch">
            <!-- Deskripsi Resto & Petunjuk Arah -->
            <div class="col-lg-4" data-aos="fade-right">
                <div
                    class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="fw-bold mb-3 text-dark border-bottom pb-3">
                            <i class="fas fa-utensils text-warning me-2"></i>Savora Junction Resto
                        </h5>

                        <p class="text-muted leading-relaxed mb-3">
                            Savora Junction Resto menyajikan aneka pilihan kuliner lezat yang dibuat dari bahan-bahan
                            segar berkualitas tinggi.
                        </p>
                        <p class="text-muted leading-relaxed mb-0">
                            Didukung dengan suasana tempat yang nyaman, hangat, dan ramah, resto kami menjadi pilihan
                            ideal untuk momen bersantai, kumpul keluarga, maupun santap bersama kerabat.
                        </p>
                    </div>

                    <div class="pt-4">
                        <a href="https://maps.google.com" target="_blank"
                            class="btn btn-warning w-100 rounded-pill fw-bold text-dark shadow-sm">
                            <i class="fas fa-directions me-2"></i>Buka Petunjuk Arah
                        </a>
                    </div>
                </div>
            </div>

            <!-- Embed Google Maps -->
            <div class="col-lg-8" data-aos="fade-left">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100" style="min-height: 380px;">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d255061.46803763942!2d103.39375437698678!3d-2.716316728807349!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e3a9fe9223d1d1f%3A0x15f79d0f8eb0e7d!2sKec.%20Babat%20Toman%2C%20Kabupaten%20Musi%20Banyuasin%2C%20Sumatera%20Selatan!5e0!3m2!1sid!2sid!4v1789631631412!5m2!1sid!2sid"
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="strict-origin-when-cross-origin"></iframe>
                </div>
            </div>
        </div>
    </div>
</section>

@push('css')
<style>
    #menuTabs .nav-link {
        color: #212529 !important;
        background-color: #f8f9fa !important;
        border: 1px solid #dee2e6 !important;
        transition: all 0.2s ease-in-out;
    }

    #menuTabs .nav-link:hover {
        background-color: #e2e6ea !important;
        color: #000000 !important;
    }

    #menuTabs .nav-link.active {
        background-color: #ffc107 !important;
        color: #000000 !important;
        border-color: #ffc107 !important;
        box-shadow: 0 4px 10px rgba(255, 193, 7, 0.3) !important;
    }

</style>
@endpush
@endsection
