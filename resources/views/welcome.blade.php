<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
      x-data="modalState()"
      x-on:keydown.escape.window="closeModal()"
      :class="{ 'overflow-hidden': modalOpen }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Sistem Layanan Kelurahan Terpadu - Transformasi Layanan Publik Digital</title>

        <!-- Fonts & Icons -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Additional Styles -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
            
            .font-poppins {
                font-family: 'Poppins', sans-serif;
            }
            
            .gradient-bg {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
            
            .gradient-text {
                background: linear-gradient(90deg, #667eea, #764ba2);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
            
            .card-hover {
                transition: all 0.3s ease;
            }
            
            .card-hover:hover {
                transform: translateY(-10px);
                box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            }
            
            .pulse-animation {
                animation: pulse 2s infinite;
            }
            
            @keyframes pulse {
                0% { transform: scale(1); }
                50% { transform: scale(1.05); }
                100% { transform: scale(1); }
            }
            
            .stats-counter {
                font-feature-settings: "tnum";
                font-variant-numeric: tabular-nums;
            }
            
            /* Modal z-index untuk welcome page */
            .modal-overlay {
                z-index: 9997 !important;
            }
            
            /* Pastikan modal tampil di atas semua konten */
            [x-cloak] { display: none !important; }
        </style>
    </head>
    <body class="font-poppins antialiased">
        <!-- Navigation -->
        <nav class="fixed w-full z-50 bg-white/90 backdrop-blur-md shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <!-- Logo -->
                    <div class="flex items-center space-x-3">
                        <div class="bg-gradient-to-br from-blue-600 to-purple-600 p-2 rounded-xl">
                            <i class="fas fa-landmark text-white text-2xl"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-900">Kelurahan<span class="text-yellow-300">Digital</span></h1>
                            <p class="text-xs text-gray-500">Sistem Layanan Terpadu</p>
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden md:flex items-center space-x-8">
                        <a href="#home" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Beranda</a>
                        <a href="#layanan" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Layanan</a>
                        <a href="#fitur" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Fitur</a>
                        <a href="#kontak" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Kontak</a>
                    </div>

                    <!-- Auth Buttons -->
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="md:block text-gray-700 hover:text-blue-600 font-medium px-4 py-2 transition-colors">
                            <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                        </a>
                        <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-3 rounded-full font-semibold hover:shadow-lg transition-all duration-300 hover:scale-105">
                            <i class="fas fa-user-plus mr-2"></i>Daftar
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section id="home" class="pt-24 pb-16 md:pt-32 md:pb-24 gradient-bg relative overflow-hidden">
            <!-- Background Elements -->
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
                <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <!-- Hero Content -->
                    <div class="text-white">
                        <div class="inline-flex items-center px-4 py-2 bg-white/20 backdrop-blur-sm rounded-full mb-6">
                            <span class="text-sm font-semibold"><i class="fas fa-bolt mr-2"></i>Revolutionizing Public Service</span>
                        </div>
                        
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                            Transformasi Layanan
                            <span class="text-yellow-300">Digital</span>
                            Untuk Masyarakat
                        </h1>
                        
                        <p class="text-lg md:text-xl text-blue-100 mb-8 leading-relaxed">
                            Sistem terintegrasi pengaduan dan pengurusan surat kelurahan secara online. 
                            Lebih cepat, transparan, dan efisien dalam satu platform digital.
                        </p>
                        
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('register') }}" class="bg-white text-blue-600 hover:bg-blue-50 px-8 py-4 rounded-full font-bold text-lg transition-all duration-300 hover:shadow-xl flex items-center justify-center pulse-animation">
                                <i class="fas fa-rocket mr-3"></i>Mulai Sekarang
                            </a>
                            <a href="#layanan" class="border-2 border-white text-white hover:bg-white/20 px-8 py-4 rounded-full font-bold text-lg transition-all duration-300 backdrop-blur-sm flex items-center justify-center">
                                <i class="fas fa-play-circle mr-3"></i>Lihat Demo
                            </a>
                        </div>
                    </div>

                    <!-- Hero Illustration -->
                    <div class="relative">
                        <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-8 border border-white/20">
                            <div class="grid grid-cols-2 gap-6">
                                <!-- Stats Cards -->
                                <div class="bg-white rounded-2xl p-6 shadow-xl">
                                    <div class="text-3xl font-bold text-blue-600 mb-2">1.2K+</div>
                                    <div class="text-gray-600 text-sm">Warga Aktif</div>
                                    <div class="mt-4 h-2 bg-blue-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-blue-600 rounded-full" style="width: 85%"></div>
                                    </div>
                                </div>
                                
                                <div class="bg-white rounded-2xl p-6 shadow-xl">
                                    <div class="text-3xl font-bold text-purple-600 mb-2">98%</div>
                                    <div class="text-gray-600 text-sm">Kepuasan Pengguna</div>
                                    <div class="mt-4 h-2 bg-purple-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-purple-600 rounded-full" style="width: 98%"></div>
                                    </div>
                                </div>
                                
                                <!-- Feature Preview -->
                                <div class="col-span-2 bg-white rounded-2xl p-6 shadow-xl">
                                    <div class="flex items-center mb-4">
                                        <div class="bg-green-100 p-3 rounded-xl mr-4">
                                            <i class="fas fa-check-circle text-green-600 text-xl"></i>
                                        </div>
                                        <div>
                                            <h3 class="font-bold text-gray-800">Tracking Real-time</h3>
                                            <p class="text-gray-600 text-sm">Pantau perkembangan layanan Anda</p>
                                        </div>
                                    </div>
                                    <div class="space-y-3">
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-700">Pengaduan #001</span>
                                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">Selesai</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-700">Surat Keterangan</span>
                                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">Diproses</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="layanan" class="py-16 md:py-24 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <span class="text-blue-600 font-semibold tracking-wider uppercase">Layanan Unggulan</span>
                    <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 mt-4 mb-6">
                        Solusi Digital
                        <span class="gradient-text">Terlengkap</span>
                    </h2>
                    <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                        Semua layanan kelurahan dalam satu platform yang mudah diakses kapan saja, di mana saja
                    </p>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <!-- Pengaduan Card -->
                    <div class="bg-white rounded-3xl p-8 border border-gray-200 card-hover">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas fa-bullhorn text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Pengaduan Masyarakat</h3>
                        <p class="text-gray-600 mb-6">
                            Laporkan masalah lingkungan, infrastruktur, atau pelayanan dengan sistem tracking real-time.
                        </p>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center text-gray-700">
                                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                Upload foto & lokasi GPS
                            </li>
                            <li class="flex items-center text-gray-700">
                                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                Pantau status real-time
                            </li>
                            <li class="flex items-center text-gray-700">
                                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                Notifikasi progres otomatis
                            </li>
                        </ul>
                        <a href="{{ route('login') }}" class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-800">
                            Ajukan Pengaduan <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>

                    <!-- Surat Online Card -->
                    <div class="bg-white rounded-3xl p-8 border border-gray-200 card-hover">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas fa-file-contract text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Surat Online</h3>
                        <p class="text-gray-600 mb-6">
                            Ajukan berbagai surat keterangan secara online tanpa perlu antri di kantor kelurahan.
                        </p>
                        <div class="grid grid-cols-2 gap-3 mb-8">
                            <span class="bg-blue-50 text-blue-700 px-3 py-2 rounded-lg text-sm font-medium">Domisili</span>
                            <span class="bg-green-50 text-green-700 px-3 py-2 rounded-lg text-sm font-medium">Tidak Mampu</span>
                            <span class="bg-purple-50 text-purple-700 px-3 py-2 rounded-lg text-sm font-medium">Usaha</span>
                            <span class="bg-yellow-50 text-yellow-700 px-3 py-2 rounded-lg text-sm font-medium">Kematian</span>
                        </div>
                        <a href="{{ route('login') }}" class="inline-flex items-center text-purple-600 font-semibold hover:text-purple-800">
                            Ajukan Surat <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                    </div>

                    <!-- Tracking Card -->
                    <div class="bg-white rounded-3xl p-8 border border-gray-200 card-hover">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-6">
                            <i class="fas fa-search-location text-white text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-4">Tracking Publik</h3>
                        <p class="text-gray-600 mb-6">
                            Lacak status pengaduan atau surat Anda tanpa perlu login menggunakan kode unik.
                        </p>
                        <ul class="space-y-3 mb-8">
                            <li class="flex items-center text-gray-700">
                                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                Kode tracking unik
                            </li>
                            <li class="flex items-center text-gray-700">
                                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                Update status otomatis
                            </li>
                            <li class="flex items-center text-gray-700">
                                <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                Akses sekarang
                            </li>
                        </ul>
                        <a href="{{ route('login') }}" class="inline-flex items-center text-purple-600 font-semibold hover:text-purple-800">
                            Lacak Sekarang <i class="fas fa-arrow-right ml-2"></i>
                        </a>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-16 bg-gradient-to-r from-blue-600 via-purple-600 to-pink-600">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                    <div class="text-center text-white">
                        <div class="text-4xl md:text-5xl font-bold mb-2 stats-counter" data-count="1250">0</div>
                        <div class="text-blue-100 font-medium">Warga Terdaftar</div>
                        <div class="mt-2 text-sm text-blue-200">
                            <i class="fas fa-users mr-1"></i>+25% bulan ini
                        </div>
                    </div>
                    <div class="text-center text-white">
                        <div class="text-4xl md:text-5xl font-bold mb-2 stats-counter" data-count="98">0</div>
                        <div class="text-blue-100 font-medium">% Kepuasan</div>
                        <div class="mt-2 text-sm text-blue-200">
                            <i class="fas fa-star mr-1"></i>Rating 4.9/5.0
                        </div>
                    </div>
                    <div class="text-center text-white">
                        <div class="text-4xl md:text-5xl font-bold mb-2 stats-counter" data-count="1560">0</div>
                        <div class="text-blue-100 font-medium">Pengaduan</div>
                        <div class="mt-2 text-sm text-blue-200">
                            <i class="fas fa-check-circle mr-1"></i>92% selesai
                        </div>
                    </div>
                    <div class="text-center text-white">
                        <div class="text-4xl md:text-5xl font-bold mb-2 stats-counter" data-count="890">0</div>
                        <div class="text-blue-100 font-medium">Surat Diterbitkan</div>
                        <div class="mt-2 text-sm text-blue-200">
                            <i class="fas fa-bolt mr-1"></i>2x lebih cepat
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-16 md:py-24 bg-gradient-to-br from-gray-900 to-gray-800 text-white">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-8 md:p-12 border border-white/20">
                    <h2 class="text-3xl md:text-4xl font-bold mb-6">Siap Mengalami Layanan Digital?</h2>
                    <p class="text-lg text-gray-300 mb-8 max-w-2xl mx-auto">
                        Bergabung dengan ribuan warga yang sudah merasakan kemudahan layanan kelurahan digital.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('register') }}" class="bg-white text-gray-900 hover:bg-gray-100 px-8 py-4 rounded-full font-bold text-lg transition-all duration-300 hover:scale-105 hover:shadow-xl">
                            <i class="fas fa-user-plus mr-3"></i>Daftar Sekarang Gratis
                        </a>
                        <a href="#kontak" class="border-2 border-white text-white hover:bg-white/20 px-8 py-4 rounded-full font-bold text-lg transition-all duration-300">
                            <i class="fas fa-question-circle mr-3"></i>Butuh Bantuan?
                        </a>
                    </div>
                    <p class="mt-8 text-gray-400 text-sm">
                        Tidak perlu kartu kredit. Mulai gunakan semua fitur premium secara gratis.
                    </p>
                </div>
            </div>
        </section>

        <!-- Footer dengan modal -->
        @include('layouts.footer')

        <!-- JavaScript Clean -->
        <script>
            // Alpine.js Modal State
            function modalState() {
                return {
                    modalOpen: false,
                    activeModal: null,
                    
                    showModal(modalId) {
                        this.activeModal = modalId;
                        this.modalOpen = true;
                        document.body.style.overflow = 'hidden';
                    },
                    
                    closeModal() {
                        this.activeModal = null;
                        this.modalOpen = false;
                        document.body.style.overflow = 'auto';
                    }
                }
            }

            // Animation Utilities
            class WelcomeAnimations {
                constructor() {
                    this.init();
                }

                init() {
                    this.initCounters();
                    this.initSmoothScroll();
                    this.initNavbarScroll();
                    this.initBackToTop();
                }

                initCounters() {
                    const counters = document.querySelectorAll('.stats-counter');
                    const observer = new IntersectionObserver((entries) => {
                        entries.forEach(entry => {
                            if (entry.isIntersecting) {
                                this.animateCounter(entry.target);
                                observer.unobserve(entry.target);
                            }
                        });
                    }, { threshold: 0.5 });

                    counters.forEach(counter => observer.observe(counter));
                }

                animateCounter(element) {
                    const target = parseInt(element.getAttribute('data-count'));
                    const increment = target / 50;
                    let current = 0;

                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            element.textContent = target.toLocaleString();
                            clearInterval(timer);
                        } else {
                            element.textContent = Math.ceil(current).toLocaleString();
                        }
                    }, 30);
                }

                initSmoothScroll() {
                    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                        anchor.addEventListener('click', (e) => {
                            const href = anchor.getAttribute('href');
                            if (href === '#') return;
                            
                            e.preventDefault();
                            const target = document.querySelector(href);
                            if (target) {
                                window.scrollTo({
                                    top: target.offsetTop - 80,
                                    behavior: 'smooth'
                                });
                            }
                        });
                    });
                }

                initNavbarScroll() {
                    const nav = document.querySelector('nav');
                    window.addEventListener('scroll', () => {
                        nav.classList.toggle('bg-white', window.scrollY > 50);
                        nav.classList.toggle('shadow-lg', window.scrollY > 50);
                        nav.classList.toggle('bg-white/90', window.scrollY <= 50);
                    });
                }

                initBackToTop() {
                    const button = document.createElement('button');
                    button.innerHTML = '<i class="fas fa-chevron-up"></i>';
                    button.className = 'fixed bottom-6 right-6 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700 transition-all duration-200 opacity-0 invisible z-40';
                    button.setAttribute('aria-label', 'Kembali ke atas');
                    button.id = 'backToTop';
                    document.body.appendChild(button);

                    window.addEventListener('scroll', () => {
                        button.classList.toggle('opacity-0', window.scrollY <= 300);
                        button.classList.toggle('invisible', window.scrollY <= 300);
                        button.classList.toggle('opacity-100', window.scrollY > 300);
                        button.classList.toggle('visible', window.scrollY > 300);
                    });

                    button.addEventListener('click', () => {
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    });
                }
            }

            // Initialize when DOM is loaded
            document.addEventListener('DOMContentLoaded', () => {
                new WelcomeAnimations();
            });
        </script>
    </body>
</html>