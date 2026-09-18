@extends('layouts.frontend')

@section('title', 'Ulasan Pengunjung - Savora Junction Resto')

@section('content')
<!-- Hero Header Section -->
<div class="hero-header-wrapper bg-dark text-white position-relative overflow-hidden mb-5">
    <!-- Efek Blur Circle Kuning -->
    <div class="position-absolute top-50 start-50 translate-middle rounded-circle bg-warning opacity-25"
        style="width: 450px; height: 450px; filter: blur(90px); pointer-events: none;"></div>

    <div class="container position-relative z-1 text-center" style="padding-top: 7rem; padding-bottom: 4rem;"
        data-aos="fade-down" data-aos-duration="800">
        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold text-uppercase mb-3 shadow-sm">
            <i class="fas fa-star me-1"></i> Ulasan Pengunjung
        </span>
        <h1 class="fw-bold text-warning display-5 mb-2">Apa Kata Mereka?</h1>
        <p class="text-light opacity-75 mx-auto mb-0" style="max-width: 600px;">
            Dengarkan pengalaman berkesan dan pendapat jujur dari para pengunjung setia Savora Junction Resto.
        </p>
    </div>
</div>

<!-- Grid Testimonial Section -->
<div class="container pb-5">
    <div class="row g-4">
        @forelse ($testimonials as $testimonial)
            <div class="col-md-6 col-lg-4"
                 data-aos="fade-up"
                 data-aos-duration="800"
                 data-aos-delay="{{ ($loop->iteration % 3) * 100 }}">
                <div class="card h-100 shadow-sm border-0 rounded-3 p-3 transition-all hover-shadow">
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
            <div class="col-12 py-5" data-aos="fade-up" data-aos-duration="800">
                <div class="text-center text-muted card border-0 shadow-sm p-5 rounded-3">
                    <i class="fas fa-comment-slash fa-3x mb-3 text-warning opacity-50"></i>
                    <h5 class="fw-bold text-dark mb-1">Belum Ada Ulasan</h5>
                    <p class="mb-0">Saat ini belum ada ulasan pengunjung yang dipublikasikan.</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Navigasi Pagination -->
    @if ($testimonials->hasPages())
        <div class="d-flex justify-content-center mt-5" data-aos="fade-up">
            {{ $testimonials->links('pagination::bootstrap-5') }}
        </div>
    @endif

    <div class="text-center mt-4" data-aos="fade-up">
        <a href="{{ url('/') }}" class="btn btn-outline-secondary px-4 py-2 rounded-pill shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
