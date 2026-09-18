<!DOCTYPE html>
<html lang="id" class="scroll-behavior-smooth">

<head>
        <!-- AOS CSS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Savora Junction Resto')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #2b2f33;
        }

        html {
            scroll-behavior: smooth;
        }

        section {
            scroll-margin-top: 80px;
        }

        /* Glassmorphism Navbar */
        .navbar-custom {
            background-color: rgba(18, 18, 18, 0.92) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-size: 1.25rem;
            letter-spacing: -0.5px;
        }

        .nav-link {
            font-weight: 500;
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.75) !important;
            padding: 0.5rem 0.8rem !important;
            transition: all 0.2s ease-in-out;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #ffc107 !important;
        }

        /* Button Styling */
        .btn-warning-gradient {
            background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
            border: none;
            color: #121212;
            font-weight: 700;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .btn-warning-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.35);
            color: #121212;
        }

        .btn-admin {
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            transition: all 0.2s ease;
        }

        .btn-admin:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #ffc107;
            border-color: #ffc107;
        }

        /* Hero styling overrides */
        .hero-section {
            background: linear-gradient(180deg, rgba(0, 0, 0, 0.7) 0%, rgba(18, 18, 18, 0.9) 100%), url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?q=80&w=1200') center/cover no-repeat;
            color: white;
        }

        /* Social Icons Footer */
        .social-link {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            color: #ffc107;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .social-link:hover {
            background: #ffc107;
            color: #121212;
            transform: translateY(-3px);
        }

    </style>

    <!-- Slot khusus untuk CSS tambahan dari child view -->
    @stack('styles')
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-warning fs-4" href="{{ url('/') }}">
                <i class="fas fa-utensils me-2"></i>Savora Junction
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-2 py-2 py-lg-0">
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="{{ url('/') }}">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="#menu">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="#artikel">Artikel & Promo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-semibold" href="#testimoni">Testimoni</a>
                    </li>

                    {{-- 1. Menggabungkan Reservasi & Booking Meja menjadi 1 tombol saja --}}
                    <li class="nav-item ms-lg-2">
                        <a class="btn btn-warning fw-bold rounded-pill px-4 shadow-sm" href="#reservasi">
                            <i class="fas fa-calendar-alt me-1"></i> Reservasi Meja
                        </a>
                    </li>

                    {{-- <li class="nav-item ms-lg-2">
                    <a class="nav-link text-secondary" href="{{ route('login') }}">Login Admin</a>
                    </li>--}}
                </ul>
            </div>
        </div>
    </nav>

    <!-- KONTEN UTAMA -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="bg-dark text-white pt-5 pb-4 border-top border-secondary border-opacity-25 mt-5" id="kontak">
        <div class="container">
            <div class="row g-4 justify-content-between">
                <div class="col-lg-4 col-md-6">
                    <h5 class="fw-bold text-warning mb-3 d-flex align-items-center">
                        <i class="fas fa-utensils me-2"></i>Savora Junction Resto
                    </h5>
                    <p class="text-secondary small leading-relaxed">Menyajikan aneka hidangan berkualitas tinggi dengan
                        bahan pilihan terbaik dan suasana tempat yang nyaman untuk momen kebersamaan Anda.</p>
                    <div class="d-flex gap-2 mt-3">
                        <a href="https://instagram.com/nvt.chell" target="_blank" rel="noopener noreferrer"
                            class="social-link">
                            <i class="fab fa-instagram"></i>
                        </a>

                        <a href="https://facebook.com/Chelsea Novitasari" target="_blank" rel="noopener noreferrer"
                            class="social-link">
                            <i class="fab fa-facebook-f"></i>
                        </a>

                        <a href="https://wa.me/6283871500590?text=Halo%20Savora%20Junction%20Resto,%20saya%20ingin%20bertanya"
                            target="_blank" rel="noopener noreferrer" class="social-link">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h6 class="fw-bold text-white mb-3 text-uppercase style-spacer">Jam Operasional</h6>
                    <ul class="list-unstyled text-secondary small mb-0">
                        <li class="mb-2"><strong class="text-light">Senin – Jumat:</strong><br>10.00 – 22.00 WIB</li>
                        <li><strong class="text-light">Sabtu – Minggu:</strong><br>09.00 – 23.00 WIB</li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-6">
                    <h6 class="fw-bold text-white mb-3 text-uppercase style-spacer">Kontak & Lokasi</h6>
                    <ul class="list-unstyled text-secondary small mb-0">
                        <li class="mb-2 d-flex align-items-start">
                            <i class="fas fa-map-marker-alt text-warning me-2 mt-1"></i>
                            <span>Jl. Melati No.02, Kec. Babat Toman, Kab. Musi Banyuasin, Sumatera Selatan, Indonesia</span>
                        </li>
                        <li class="mb-2 d-flex align-items-center">
                            <i class="fab fa-whatsapp text-warning me-2"></i>
                            <span>+62 838-7150-0590</span>
                        </li>
                        <li class="d-flex align-items-center">
                            <i class="fas fa-envelope text-warning me-2"></i>
                            <span>info@savorajunction.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="border-secondary border-opacity-25 my-4">

            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center small text-secondary">
                <p class="mb-2 mb-sm-0">&copy; {{ date('Y') }} Savora Junction Resto. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS JS -->
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,   // Durasi animasi (milidetik)
        once: true,      // Animasi hanya jalan 1 kali saat di-scroll
        easing: 'ease-in-out',
    });
</script>

    <!-- Slot khusus untuk JavaScript tambahan dari child view -->
    @stack('scripts')
</body>

</html>
