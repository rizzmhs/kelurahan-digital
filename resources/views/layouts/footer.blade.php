<footer id="kontak" class="bg-gray-900 text-white py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-4 gap-8">
            <!-- Logo & Company Info -->
            <div>
                <div class="flex items-center space-x-3 mb-6">
                    <div class="bg-gradient-to-br from-blue-600 to-purple-600 p-2 rounded-xl">
                        <i class="fas fa-landmark text-white text-2xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold">KelurahanDigital</h3>
                        <p class="text-sm text-gray-400">Sistem Layanan Terpadu</p>
                    </div>
                </div>
                <p class="text-gray-400 mb-6">
                    Transformasi layanan publik menuju era digital yang lebih efisien dan transparan.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="bg-gray-800 hover:bg-blue-600 p-3 rounded-full transition-colors" aria-label="Facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="bg-gray-800 hover:bg-blue-400 p-3 rounded-full transition-colors" aria-label="Twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="bg-gray-800 hover:bg-pink-600 p-3 rounded-full transition-colors" aria-label="Instagram">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="bg-gray-800 hover:bg-red-600 p-3 rounded-full transition-colors" aria-label="YouTube">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-lg font-bold mb-6">Layanan Cepat</h4>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('warga.pengaduan.create') }}" class="text-gray-400 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-bullhorn mr-2 text-sm text-blue-500"></i>Ajukan Pengaduan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('warga.surat.create') }}" class="text-gray-400 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-file-contract mr-2 text-sm text-purple-500"></i>Buat Surat Online
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('tracking.pengaduan', 'demo') }}" class="text-gray-400 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-search-location mr-2 text-sm text-green-500"></i>Tracking Status
                        </a>
                    </li>
                    @auth
                    <li>
                        <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-white transition-colors flex items-center">
                            <i class="fas fa-tachometer-alt mr-2 text-sm text-yellow-500"></i>Dashboard Saya
                        </a>
                    </li>
                    @endauth
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h4 class="text-lg font-bold mb-6">Hubungi Kami</h4>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt mt-1 mr-3 text-blue-500"></i>
                        <span class="text-gray-400">
                            Jl. Digital No. 123<br>
                            Kelurahan Modern, Kota Masa Depan<br>
                            Kode Pos: 12345
                        </span>
                    </li>
                    <li class="flex items-center text-gray-400">
                        <i class="fas fa-phone mr-3 text-blue-500"></i>
                        (021) 1234-5678
                    </li>
                    <li class="flex items-center text-gray-400">
                        <i class="fas fa-envelope mr-3 text-blue-500"></i>
                        info@kelurahansystem.com
                    </li>
                    <li class="flex items-center text-gray-400 mt-4">
                        <i class="fas fa-headset mr-3 text-green-500"></i>
                        Layanan Pengaduan: 1500-123
                    </li>
                </ul>
            </div>

            <!-- Operating Hours & Resources -->
            <div>
                <h4 class="text-lg font-bold mb-6">Jam Layanan</h4>
                <ul class="space-y-2 text-gray-400 mb-6">
                    <li class="flex justify-between">
                        <span>Senin - Jumat</span>
                        <span>08:00 - 16:00</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Sabtu</span>
                        <span>08:00 - 12:00</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Minggu</span>
                        <span class="text-red-400">Tutup</span>
                    </li>
                    <li class="pt-4 text-sm">
                        <i class="fas fa-globe mr-2 text-blue-400"></i>
                        Layanan Online: <span class="text-green-400 font-semibold">24/7</span>
                    </li>
                </ul>

                <!-- Quick Resources -->
                <div>
                    
                    <div class="flex flex-wrap gap-2">
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="border-t border-gray-800 mt-12 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-center md:text-left mb-4 md:mb-0">
                    <p class="text-gray-400">
                        &copy; {{ date('Y') }} Sistem Layanan Kelurahan Terpadu. 
                        <span class="text-blue-400 font-semibold">v2.0.0</span>
                    </p>
                    <p class="text-gray-500 text-sm mt-1">
                        <i class="fas fa-shield-alt mr-2"></i>
                        Dilindungi dengan teknologi keamanan terkini
                    </p>
                </div>

                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('tentang') }}" class="text-gray-400 hover:text-white text-sm transition-colors">
                        Tentang Kami
                    </a>
                    <a href="{{ route('panduan') }}" class="text-gray-400 hover:text-white text-sm transition-colors">
                        Panduan
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">
                        Kebijakan Privasi
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white text-sm transition-colors">
                        Syarat & Ketentuan
                    </a>
                    <a href="{{ route('kontak') }}" class="text-gray-400 hover:text-white text-sm transition-colors">
                        Kontak
                    </a>
                </div>
            </div>

            <!-- Badges -->
            <div class="flex flex-wrap justify-center gap-4 mt-6">
                <div class="flex items-center bg-gray-800 px-3 py-2 rounded-lg">
                    <i class="fas fa-lock text-green-400 mr-2"></i>
                    <span class="text-xs text-gray-300">SSL Terenkripsi</span>
                </div>
                <div class="flex items-center bg-gray-800 px-3 py-2 rounded-lg">
                    <i class="fas fa-mobile-alt text-blue-400 mr-2"></i>
                    <span class="text-xs text-gray-300">Responsif Mobile</span>
                </div>
                <div class="flex items-center bg-gray-800 px-3 py-2 rounded-lg">
                    <i class="fas fa-bolt text-yellow-400 mr-2"></i>
                    <span class="text-xs text-gray-300">High Performance</span>
                </div>
            </div>
        </div>
    </div>
</footer>

@push('scripts')
<script>
    // Back to Top Button
    document.addEventListener('DOMContentLoaded', function() {
        // Create back to top button
        const backToTopButton = document.createElement('button');
        backToTopButton.innerHTML = '<i class="fas fa-chevron-up"></i>';
        backToTopButton.className = 'fixed bottom-6 right-6 bg-blue-600 text-white p-3 rounded-full shadow-lg hover:bg-blue-700 transition-all duration-300 opacity-0 invisible z-50';
        backToTopButton.setAttribute('aria-label', 'Kembali ke atas');
        backToTopButton.id = 'backToTop';
        document.body.appendChild(backToTopButton);

        // Show/hide button on scroll
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                backToTopButton.classList.remove('opacity-0', 'invisible');
                backToTopButton.classList.add('opacity-100', 'visible');
            } else {
                backToTopButton.classList.remove('opacity-100', 'visible');
                backToTopButton.classList.add('opacity-0', 'invisible');
            }
        });

        // Scroll to top when clicked
        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    });
</script>
@endpush