@extends('layouts.frontend')

@section('title', 'Savora Junction Resto - Cita Rasa Otentik & Suasana Nyaman')

@section('content')
<div class="container py-5 mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Header Artikel -->
            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-3">Informasi Promo & Berita</span>
            <h1 class="fw-bold mb-3">{{ $article->title }}</h1>
            <p class="text-muted small mb-4">
                <i class="far fa-calendar-alt me-1"></i> {{ $article->created_at ? $article->created_at->format('d M Y') : 'Terbaru' }}
            </p>

            <!-- Gambar Utama Artikel -->
            @if($article->image)
            <img src="{{ asset('storage/back/article-images/' . $article->image) }}"
                 class="img-fluid rounded-4 mb-4 w-100 shadow-sm"
                 alt="{{ $article->title }}"
                 style="max-height: 400px; object-fit: cover;"
                 onerror="this.onerror=null; this.src='https://placehold.co/800x400?text=Savora+Resto+Promo';">
            @endif

            <!-- Isi Konten Artikel -->
            <div class="article-body text-secondary lh-lg mb-5 fs-5">
                {!! (($article->content ?? $article->description)) !!}
            </div>

            <hr class="my-5">

            <!-- Tombol Kembali di Bawah -->
            <div class="text-center">
                <a href="{{ url('/') }}" class="btn btn-outline-secondary px-4 py-2 rounded-pill shadow-sm">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
