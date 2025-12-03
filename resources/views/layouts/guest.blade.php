<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="Sistem Layanan Kelurahan Digital - Layanan publik yang efisien dan transparan">

        <title>@yield('title', config('app.name', 'KelurahanDigital'))</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        
        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🏛️</text></svg>">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Alpine.js -->
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
        
        @stack('styles')
        @stack('scripts')
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gradient-to-br from-blue-50 via-white to-gray-50">
        <!-- Background Pattern -->
        <div class="fixed inset-0 bg-[url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%239C92AC" fill-opacity="0.05"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-30"></div>
        
        <div class="relative min-h-screen flex flex-col items-center justify-center px-4 sm:px-6 lg:px-8 py-12">
            <!-- Header -->
            <header class="w-full max-w-7xl mx-auto mb-8 sm:mb-12">
                <nav class="flex justify-between items-center px-4 sm:px-6">
                    <a href="{{ url('/') }}" class="flex items-center space-x-3 group">
                        <div class="bg-gradient-to-br from-blue-500 to-purple-600 p-3 rounded-xl shadow-lg group-hover:scale-105 transition-transform duration-200">
                            <i class="fas fa-landmark text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-xl sm:text-2xl font-bold text-gray-800">
                                Kelurahan<span class="text-blue-600">Digital</span>
                            </h1>
                            <p class="text-xs sm:text-sm text-gray-600">Sistem Layanan Terpadu</p>
                        </div>
                    </a>
                    
                    <div class="flex items-center space-x-4">
                        <a href="{{ url('/') }}" 
                           class="hidden sm:inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 hover:text-blue-600 transition-colors duration-200">
                            <i class="fas fa-home mr-2"></i>Beranda
                        </a>
                        <a href="{{ route('login') }}" 
                           class="px-4 py-2 text-sm font-medium text-blue-600 hover:text-blue-800 transition-colors duration-200">
                            Masuk
                        </a>
                        @if (Route::has('register'))
                        <a href="{{ route('register') }}" 
                           class="px-4 py-2 text-sm font-medium bg-gradient-to-r from-blue-500 to-purple-600 text-white rounded-lg hover:from-blue-600 hover:to-purple-700 transition-all duration-200 shadow-md hover:shadow-lg">
                            Daftar
                        </a>
                        @endif
                    </div>
                </nav>
            </header>

            <!-- Main Content Card -->
            <main class="w-full max-w-lg">
                <div class="relative">
                    <!-- Decorative Elements -->
                    <div class="absolute -top-4 -left-4 w-20 h-20 bg-gradient-to-br from-blue-100 to-purple-100 rounded-full opacity-50 blur-xl"></div>
                    <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-gradient-to-br from-purple-100 to-pink-100 rounded-full opacity-50 blur-xl"></div>
                    
                    <!-- Card Container -->
                    <div class="relative bg-white/90 backdrop-blur-sm rounded-2xl shadow-2xl overflow-hidden border border-white/20">
                        <!-- Card Header -->
                        <div class="px-8 pt-8 pb-6 bg-gradient-to-r from-blue-500/10 to-purple-500/10">
                            <div class="flex items-center justify-center mb-2">
                                <div class="bg-gradient-to-br from-blue-500 to-purple-600 p-3 rounded-xl shadow-lg">
                                    @if(request()->routeIs('login'))
                                        <i class="fas fa-sign-in-alt text-white text-xl"></i>
                                    @elseif(request()->routeIs('register'))
                                        <i class="fas fa-user-plus text-white text-xl"></i>
                                    @elseif(request()->routeIs('password.request'))
                                        <i class="fas fa-key text-white text-xl"></i>
                                    @elseif(request()->routeIs('password.reset'))
                                        <i class="fas fa-redo text-white text-xl"></i>
                                    @else
                                        <i class="fas fa-landmark text-white text-xl"></i>
                                    @endif
                                </div>
                            </div>
                            <h2 class="text-2xl font-bold text-center text-gray-800 mt-4">
                                @if(request()->routeIs('login'))
                                    Masuk ke Akun Anda
                                @elseif(request()->routeIs('register'))
                                    Buat Akun Baru
                                @elseif(request()->routeIs('password.request'))
                                    Reset Kata Sandi
                                @elseif(request()->routeIs('password.reset'))
                                    Atur Kata Sandi Baru
                                @else
                                    {{ $title ?? 'KelurahanDigital' }}
                                @endif
                            </h2>
                            <p class="text-center text-gray-600 text-sm mt-2">
                                @if(request()->routeIs('login'))
                                    Masukkan kredensial Anda untuk mengakses layanan
                                @elseif(request()->routeIs('register'))
                                    Daftar untuk mengakses semua layanan digital kami
                                @elseif(request()->routeIs('password.request'))
                                    Masukkan email untuk reset kata sandi
                                @elseif(request()->routeIs('password.reset'))
                                    Buat kata sandi baru untuk akun Anda
                                @endif
                            </p>
                        </div>
                        
                        <!-- Card Content -->
                        <div class="px-8 py-8">
                            {{ $slot }}
                        </div>
                        
                        <!-- Card Footer -->
                        <div class="px-8 py-6 bg-gray-50/50 border-t border-gray-100">
                            <div class="flex flex-col sm:flex-row justify-between items-center text-sm text-gray-600 space-y-2 sm:space-y-0">
                                <div class="flex items-center">
                                    <i class="fas fa-shield-alt text-green-500 mr-2"></i>
                                    <span>Data Anda terlindungi dengan aman</span>
                                </div>
                                <div>
                                    <a href="{{ url('/') }}" class="text-blue-600 hover:text-blue-800 transition-colors duration-200">
                                        <i class="fas fa-arrow-left mr-1"></i>Kembali ke beranda
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Additional Info -->
                <div class="mt-8 text-center">
                    <p class="text-sm text-gray-600">
                        Butuh bantuan? 
                        <a href="https://wa.me/6281333154367" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium transition-colors duration-200">
                            <i class="fab fa-whatsapp mr-1"></i>Hubungi Support
                        </a>
                    </p>
                </div>
            </main>

            <!-- Footer -->
            <footer class="mt-12 text-center">
                <p class="text-xs text-gray-500">
                    &copy; {{ date('Y') }} KelurahanDigital v2.0.0 • 
                    <span class="text-blue-600 font-medium">Sistem Layanan Kelurahan Terpadu</span>
                </p>
                <p class="text-xs text-gray-400 mt-1">
                    Developed by <span class="text-purple-600 font-medium">Rizz Team</span>
                </p>
            </footer>
        </div>

        <!-- Floating Elements (Optional) -->
        <div class="fixed bottom-6 right-6">
            <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
                    class="bg-gradient-to-br from-blue-500 to-purple-600 text-white p-3 rounded-full shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-200">
                <i class="fas fa-chevron-up"></i>
            </button>
        </div>

        @stack('scripts')
        
        <style>
            /* Custom scrollbar */
            ::-webkit-scrollbar {
                width: 10px;
            }
            ::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 5px;
            }
            ::-webkit-scrollbar-thumb {
                background: linear-gradient(to bottom, #3b82f6, #8b5cf6);
                border-radius: 5px;
            }
            ::-webkit-scrollbar-thumb:hover {
                background: linear-gradient(to bottom, #2563eb, #7c3aed);
            }

            /* Smooth animations */
            * {
                transition-property: color, background-color, border-color, transform, box-shadow;
                transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
                transition-duration: 200ms;
            }

            /* Card entrance animation */
            @keyframes cardEntrance {
                from {
                    opacity: 0;
                    transform: translateY(20px) scale(0.95);
                }
                to {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }

            .relative > div:first-child > div:last-child {
                animation: cardEntrance 0.5s ease-out;
            }
        </style>
    </body>
</html>