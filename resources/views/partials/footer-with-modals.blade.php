<footer id="kontak" class="bg-gray-900 text-white py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Logo & Company Info -->
            <div class="lg:col-span-1">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="bg-gradient-to-br from-blue-400 to-purple-600 p-2.5 rounded-xl">
                        <i class="fas fa-landmark text-white text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white">Kelurahan<span class="text-yellow-300">Digital</span></h3>
                        <p class="text-sm text-gray-400">Sistem Layanan Terpadu</p>
                    </div>
                </div>
                <p class="text-gray-400 text-sm mb-4">
                    Transformasi layanan publik menuju era digital yang lebih efisien dan transparan.
                </p>
                <div class="flex space-x-2">
                    <a href="#" class="bg-gray-800 hover:bg-blue-600 p-2.5 rounded-full transition-all duration-200 hover:scale-105" 
                       aria-label="Facebook">
                        <i class="fab fa-facebook-f text-sm"></i>
                    </a>
                    <a href="#" class="bg-gray-800 hover:bg-blue-400 p-2.5 rounded-full transition-all duration-200 hover:scale-105" 
                       aria-label="Twitter">
                        <i class="fab fa-twitter text-sm"></i>
                    </a>
                    <a href="#" class="bg-gray-800 hover:bg-pink-600 p-2.5 rounded-full transition-all duration-200 hover:scale-105" 
                       aria-label="Instagram">
                        <i class="fab fa-instagram text-sm"></i>
                    </a>
                    <a href="#" class="bg-gray-800 hover:bg-red-600 p-2.5 rounded-full transition-all duration-200 hover:scale-105" 
                       aria-label="YouTube">
                        <i class="fab fa-youtube text-sm"></i>
                    </a>
                </div>
            </div>

            <!-- Three Columns Grid -->
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-8 lg:col-span-3">
                <!-- Layanan Cepat -->
                <div class="w-full">
                    <h4 class="text-base font-bold mb-4 text-white">Layanan Cepat</h4>
                    <ul class="space-y-3">
                        @auth
                        <li>
                            <a href="{{ route('dashboard') }}" 
                               class="text-gray-400 hover:text-white transition-all duration-200 flex items-center text-sm py-1">
                                <i class="fas fa-tachometer-alt mr-3 text-xs text-blue-500 w-4 flex-shrink-0"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        @endauth
                        <li>
                            <a href="{{ route('warga.pengaduan.create') }}" 
                               class="text-gray-400 hover:text-white transition-all duration-200 flex items-center text-sm py-1">
                                <i class="fas fa-bullhorn mr-3 text-xs text-purple-500 w-4 flex-shrink-0"></i>
                                <span>Ajukan Pengaduan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('warga.surat.create') }}" 
                               class="text-gray-400 hover:text-white transition-all duration-200 flex items-center text-sm py-1">
                                <i class="fas fa-file-contract mr-3 text-xs text-green-500 w-4 flex-shrink-0"></i>
                                <span>Buat Surat</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('tracking.pengaduan', 'demo') }}" 
                               class="text-gray-400 hover:text-white transition-all duration-200 flex items-center text-sm py-1">
                                <i class="fas fa-search-location mr-3 text-xs text-yellow-500 w-4 flex-shrink-0"></i>
                                <span>Tracking Status</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Hubungi Kami -->
                <div class="w-full">
                    <h4 class="text-base font-bold mb-4 text-white">Hubungi Kami</h4>
                    <ul class="space-y-3">
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-0.5 mr-3 text-blue-500 text-xs w-4 flex-shrink-0"></i>
                            <span class="text-gray-400 text-sm leading-relaxed">
                                Wonosobo, Mojotengah<br>
                                Kelurahan Larangankulon<br>
                                Kode Pos: 56351
                            </span>
                        </li>
                        <li class="flex items-center text-gray-400 text-sm py-1">
                            <i class="fas fa-phone mr-3 text-blue-500 text-xs w-4 flex-shrink-0"></i>
                            <span>(+62) 813-3315-4367</span>
                        </li>
                        <li class="flex items-center text-gray-400 text-sm py-1">
                            <i class="fas fa-envelope mr-3 text-blue-500 text-xs w-4 flex-shrink-0"></i>
                            <span class="break-all">larangankulon@gmail.com</span>
                        </li>
                    </ul>
                </div>

                <!-- Jam Operasional -->
                <div class="w-full col-span-2 lg:col-span-1">
                    <h4 class="text-base font-bold mb-4 text-white">Jam Layanan</h4>
                    <ul class="space-y-3">
                        <li class="flex justify-between items-center py-1">
                            <div class="flex items-center text-gray-300 text-sm">
                                <i class="fas fa-calendar-day mr-3 text-blue-400 text-xs w-4 flex-shrink-0"></i>
                                <span>Senin - Jumat</span>
                            </div>
                            <span class="font-medium text-white text-sm whitespace-nowrap">08:00 - 16:00</span>
                        </li>
                        
                        <li class="flex justify-between items-center py-1">
                            <div class="flex items-center text-gray-300 text-sm">
                                <i class="fas fa-calendar mr-3 text-green-400 text-xs w-4 flex-shrink-0"></i>
                                <span>Sabtu</span>
                            </div>
                            <span class="font-medium text-white text-sm whitespace-nowrap">08:00 - 12:00</span>
                        </li>
                        
                        <li class="flex justify-between items-center py-1">
                            <div class="flex items-center text-gray-300 text-sm">
                                <i class="fas fa-calendar-times mr-3 text-red-400 text-xs w-4 flex-shrink-0"></i>
                                <span>Minggu</span>
                            </div>
                            <span class="font-medium text-red-400 text-sm whitespace-nowrap">Tutup</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="border-t border-gray-800 mt-8 pt-6">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="text-center md:text-left">
                    <p class="text-gray-400 text-sm">
                        &copy; {{ date('Y') }} KelurahanDigital - Sistem Layanan Kelurahan Terpadu. 
                        <span class="text-blue-400 font-medium">v2.0.0</span>
                    </p>
                    <p class="text-gray-500 text-xs mt-1">
                        Developed by Rizz Team
                    </p>
                </div>

                <div class="flex flex-wrap justify-center gap-2 md:gap-3">
                    <button type="button" 
                            x-on:click="showModal('tentangModal')"
                            class="text-gray-400 hover:text-white text-xs transition-all duration-200 hover:underline focus:outline-none px-2 py-1">
                        Tentang Kami
                    </button>
                    
                    <span class="text-gray-600 text-xs hidden sm:inline">•</span>
                    
                    <button type="button" 
                            x-on:click="showModal('panduanModal')"
                            class="text-gray-400 hover:text-white text-xs transition-all duration-200 hover:underline focus:outline-none px-2 py-1">
                        Panduan
                    </button>
                    
                    <span class="text-gray-600 text-xs hidden sm:inline">•</span>
                    
                    <button type="button" 
                            x-on:click="showModal('privacyModal')"
                            class="text-gray-400 hover:text-white text-xs transition-all duration-200 hover:underline focus:outline-none px-2 py-1">
                        Privasi
                    </button>
                    
                    <span class="text-gray-600 text-xs hidden sm:inline">•</span>
                    
                    <button type="button" 
                            x-on:click="showModal('syaratModal')"
                            class="text-gray-400 hover:text-white text-xs transition-all duration-200 hover:underline focus:outline-none px-2 py-1">
                        Syarat
                    </button>
                    
                    <span class="text-gray-600 text-xs hidden sm:inline">•</span>
                    
                    <a href="https://wa.me/6281333154367" target="_blank" rel="noopener noreferrer" 
                       class="text-gray-400 hover:text-white text-xs transition-all duration-200 hover:underline px-2 py-1">
                        Support
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Modal Templates -->
<div x-show="modalOpen && activeModal === 'tentangModal'" 
     x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform scale-95"
     x-transition:enter-end="opacity-100 transform scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 transform scale-100"
     x-transition:leave-end="opacity-0 transform scale-95"
     class="fixed inset-0 z-50 overflow-y-auto modal-overlay"
     x-on:click.self="closeModal()">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto modal-content">
            <!-- Modal Header -->
            <div class="sticky top-0 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-4 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-info-circle text-xl mr-3"></i>
                        <h3 class="text-xl font-bold">Tentang KelurahanDigital</h3>
                    </div>
                    <button x-on:click="closeModal()" 
                            class="text-white hover:text-gray-200 text-2xl transition duration-200">
                        &times;
                    </button>
                </div>
            </div>
            
            <!-- Modal Content -->
            <div class="p-6">
                <div class="mb-6">
                    <div class="flex items-center mb-4">
                        <div class="bg-gradient-to-br from-blue-500 to-purple-600 p-3 rounded-xl mr-4">
                            <i class="fas fa-landmark text-white text-2xl"></i>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-900">Kelurahan<span class="text-blue-600">Digital</span></h4>
                            <p class="text-gray-600">Sistem Layanan Kelurahan Terpadu v2.0.0</p>
                        </div>
                    </div>
                    
                    <p class="text-gray-700 mb-4">
                        <strong>KelurahanDigital</strong> adalah platform inovatif yang bertransformasi untuk menghadirkan 
                        layanan publik berbasis digital yang lebih efisien, transparan, dan mudah diakses oleh seluruh masyarakat.
                    </p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h5 class="font-semibold text-blue-700 mb-2 flex items-center">
                            <i class="fas fa-bullseye mr-2"></i> Misi Kami
                        </h5>
                        <ul class="text-gray-700 space-y-1 text-sm">
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                <span>Meningkatkan efisiensi layanan publik</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                <span>Mendorong transparansi pemerintahan</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-check text-green-500 mt-1 mr-2"></i>
                                <span>Mempermudah akses masyarakat</span>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="bg-purple-50 p-4 rounded-lg">
                        <h5 class="font-semibold text-purple-700 mb-2 flex items-center">
                            <i class="fas fa-cogs mr-2"></i> Layanan Utama
                        </h5>
                        <ul class="text-gray-700 space-y-1 text-sm">
                            <li class="flex items-start">
                                <i class="fas fa-comments text-blue-500 mt-1 mr-2"></i>
                                <span>Pengaduan masyarakat online</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-file-contract text-green-500 mt-1 mr-2"></i>
                                <span>Pembuatan surat administrasi</span>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-search text-yellow-500 mt-1 mr-2"></i>
                                <span>Tracking status real-time</span>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h5 class="font-semibold text-gray-700 mb-2 flex items-center">
                        <i class="fas fa-users mr-2"></i> Tim Pengembang
                    </h5>
                    <p class="text-gray-600 text-sm">
                        Platform ini dikembangkan oleh <strong class="text-blue-600">Rizz Team</strong> 
                        dengan dedikasi untuk mendukung transformasi digital di tingkat kelurahan.
                    </p>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="bg-gray-50 px-6 py-4 rounded-b-xl flex justify-end">
                <button x-on:click="closeModal()"
                        class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-medium rounded-lg hover:opacity-90 transition duration-200">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Panduan Modal -->
<div x-show="modalOpen && activeModal === 'panduanModal'" 
     x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform scale-95"
     x-transition:enter-end="opacity-100 transform scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 transform scale-100"
     x-transition:leave-end="opacity-0 transform scale-95"
     class="fixed inset-0 z-50 overflow-y-auto modal-overlay"
     x-on:click.self="closeModal()">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white rounded-xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto modal-content">
            <!-- Modal Header -->
            <div class="sticky top-0 bg-gradient-to-r from-green-600 to-teal-600 text-white px-6 py-4 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-book text-xl mr-3"></i>
                        <h3 class="text-xl font-bold">Panduan Penggunaan</h3>
                    </div>
                    <button x-on:click="closeModal()" 
                            class="text-white hover:text-gray-200 text-2xl transition duration-200">
                        &times;
                    </button>
                </div>
            </div>
            
            <!-- Modal Content -->
            <div class="p-6">
                <div class="mb-6">
                    <h4 class="text-lg font-bold text-gray-900 mb-3">Panduan Lengkap Penggunaan Sistem</h4>
                    
                    <div class="space-y-6">
                        <!-- Panduan 1 -->
                        <div class="border-l-4 border-blue-500 pl-4 py-1">
                            <h5 class="font-semibold text-gray-800 mb-2 flex items-center">
                                <span class="bg-blue-100 text-blue-600 rounded-full w-6 h-6 flex items-center justify-center mr-2 text-sm">1</span>
                                Registrasi dan Login
                            </h5>
                            <p class="text-gray-600 text-sm">
                                Untuk mengakses layanan, Anda perlu melakukan registrasi akun terlebih dahulu 
                                menggunakan data diri yang valid. Setelah registrasi, login menggunakan email 
                                dan password yang telah dibuat.
                            </p>
                        </div>
                        
                        <!-- Panduan 2 -->
                        <div class="border-l-4 border-green-500 pl-4 py-1">
                            <h5 class="font-semibold text-gray-800 mb-2 flex items-center">
                                <span class="bg-green-100 text-green-600 rounded-full w-6 h-6 flex items-center justify-center mr-2 text-sm">2</span>
                                Mengajukan Pengaduan
                            </h5>
                            <p class="text-gray-600 text-sm">
                                Navigasi ke menu "Pengaduan" → "Ajukan Pengaduan". Isi formulir dengan 
                                lengkap dan lampirkan bukti pendukung jika diperlukan. Setelah diajukan, 
                                Anda dapat melacak status pengaduan melalui fitur tracking.
                            </p>
                        </div>
                        
                        <!-- Panduan 3 -->
                        <div class="border-l-4 border-purple-500 pl-4 py-1">
                            <h5 class="font-semibold text-gray-800 mb-2 flex items-center">
                                <span class="bg-purple-100 text-purple-600 rounded-full w-6 h-6 flex items-center justify-center mr-2 text-sm">3</span>
                                Membuat Surat Online
                            </h5>
                            <p class="text-gray-600 text-sm">
                                Pilih jenis surat yang dibutuhkan dari menu "Surat Online". Isi data 
                                dengan benar dan lengkapi syarat dokumen yang diminta. Proses verifikasi 
                                akan dilakukan oleh petugas sebelum surat diproses.
                            </p>
                        </div>
                        
                        <!-- Panduan 4 -->
                        <div class="border-l-4 border-yellow-500 pl-4 py-1">
                            <h5 class="font-semibold text-gray-800 mb-2 flex items-center">
                                <span class="bg-yellow-100 text-yellow-600 rounded-full w-6 h-6 flex items-center justify-center mr-2 text-sm">4</span>
                                Melacak Status
                            </h5>
                            <p class="text-gray-600 text-sm">
                                Gunakan fitur tracking untuk memantau perkembangan pengajuan Anda. 
                                Masukkan kode tracking yang diberikan untuk melihat status terkini 
                                dan estimasi waktu penyelesaian.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-blue-50 p-4 rounded-lg">
                    <h5 class="font-semibold text-blue-700 mb-2 flex items-center">
                        <i class="fas fa-headset mr-2"></i> Butuh Bantuan?
                    </h5>
                    <p class="text-gray-700 text-sm">
                        Jika mengalami kesulitan atau memiliki pertanyaan, hubungi tim support kami melalui:
                        <br>
                        <strong>WhatsApp:</strong> <a href="https://wa.me/6281333154367" class="text-blue-600 hover:underline">+62 813-3315-4367</a>
                        <br>
                        <strong>Email:</strong> <a href="mailto:larangankulon@gmail.com" class="text-blue-600 hover:underline">larangankulon@gmail.com</a>
                    </p>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="bg-gray-50 px-6 py-4 rounded-b-xl flex justify-between items-center">
                <a href="https://wa.me/6281333154367" target="_blank"
                   class="px-4 py-2 bg-green-500 text-white font-medium rounded-lg hover:bg-green-600 transition duration-200 flex items-center">
                    <i class="fab fa-whatsapp mr-2"></i> Tanya via WhatsApp
                </a>
                <button x-on:click="closeModal()"
                        class="px-5 py-2.5 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition duration-200">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Privacy Policy Modal -->
<div x-show="modalOpen && activeModal === 'privacyModal'" 
     x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform scale-95"
     x-transition:enter-end="opacity-100 transform scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 transform scale-100"
     x-transition:leave-end="opacity-0 transform scale-95"
     class="fixed inset-0 z-50 overflow-y-auto modal-overlay"
     x-on:click.self="closeModal()">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white rounded-xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto modal-content">
            <!-- Modal Header -->
            <div class="sticky top-0 bg-gradient-to-r from-gray-700 to-gray-900 text-white px-6 py-4 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-shield-alt text-xl mr-3"></i>
                        <h3 class="text-xl font-bold">Kebijakan Privasi</h3>
                    </div>
                    <button x-on:click="closeModal()" 
                            class="text-white hover:text-gray-200 text-2xl transition duration-200">
                        &times;
                    </button>
                </div>
            </div>
            
            <!-- Modal Content -->
            <div class="p-6">
                <div class="prose prose-blue max-w-none">
                    <h4 class="text-lg font-bold text-gray-900 mb-4">Pengumpulan dan Penggunaan Data</h4>
                    <p class="text-gray-700 mb-4">
                        Kami menghormati privasi pengguna dan berkomitmen untuk melindungi data pribadi 
                        yang Anda berikan kepada kami. Data yang kami kumpulkan hanya digunakan untuk 
                        keperluan layanan administrasi kelurahan.
                    </p>
                    
                    <h5 class="font-semibold text-gray-800 mb-2">Data yang Kami Kumpulkan:</h5>
                    <ul class="text-gray-700 space-y-1 mb-4">
                        <li>• Informasi identitas (nama, NIK, tanggal lahir)</li>
                        <li>• Kontak informasi (alamat, telepon, email)</li>
                        <li>• Data pengajuan layanan (pengaduan, surat)</li>
                        <li>• Data login dan aktivitas sistem</li>
                    </ul>
                    
                    <h5 class="font-semibold text-gray-800 mb-2">Penggunaan Data:</h5>
                    <ul class="text-gray-700 space-y-1 mb-4">
                        <li>• Untuk memproses layanan yang Anda ajukan</li>
                        <li>• Untuk komunikasi terkait status layanan</li>
                        <li>• Untuk perbaikan dan pengembangan sistem</li>
                        <li>• Untuk keperluan statistik dan pelaporan</li>
                    </ul>
                    
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                        <h5 class="font-semibold text-yellow-700 mb-2 flex items-center">
                            <i class="fas fa-exclamation-triangle mr-2"></i> Keamanan Data
                        </h5>
                        <p class="text-yellow-700 text-sm">
                            Kami menerapkan standar keamanan tinggi untuk melindungi data Anda dari 
                            akses, penggunaan, atau pengungkapan yang tidak sah.
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="bg-gray-50 px-6 py-4 rounded-b-xl flex justify-end">
                <button x-on:click="closeModal()"
                        class="px-5 py-2.5 bg-gray-700 text-white font-medium rounded-lg hover:bg-gray-800 transition duration-200">
                    Saya Memahami
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Syarat & Ketentuan Modal -->
<div x-show="modalOpen && activeModal === 'syaratModal'" 
     x-cloak
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform scale-95"
     x-transition:enter-end="opacity-100 transform scale-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 transform scale-100"
     x-transition:leave-end="opacity-0 transform scale-95"
     class="fixed inset-0 z-50 overflow-y-auto modal-overlay"
     x-on:click.self="closeModal()">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative bg-white rounded-xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto modal-content">
            <!-- Modal Header -->
            <div class="sticky top-0 bg-gradient-to-r from-orange-600 to-red-600 text-white px-6 py-4 rounded-t-xl">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-file-contract text-xl mr-3"></i>
                        <h3 class="text-xl font-bold">Syarat & Ketentuan</h3>
                    </div>
                    <button x-on:click="closeModal()" 
                            class="text-white hover:text-gray-200 text-2xl transition duration-200">
                        &times;
                    </button>
                </div>
            </div>
            
            <!-- Modal Content -->
            <div class="p-6">
                <div class="prose prose-orange max-w-none">
                    <h4 class="text-lg font-bold text-gray-900 mb-4">Ketentuan Penggunaan Layanan</h4>
                    
                    <div class="space-y-4">
                        <div>
                            <h5 class="font-semibold text-gray-800 mb-2">1. Persyaratan Umum</h5>
                            <p class="text-gray-700 text-sm">
                                Dengan menggunakan layanan KelurahanDigital, Anda menyetujui untuk:
                                <br>
                                • Memberikan informasi yang benar dan valid
                                <br>
                                • Menggunakan layanan sesuai dengan peruntukannya
                                <br>
                                • Mematuhi semua peraturan yang berlaku
                            </p>
                        </div>
                        
                        <div>
                            <h5 class="font-semibold text-gray-800 mb-2">2. Tanggung Jawab Pengguna</h5>
                            <p class="text-gray-700 text-sm">
                                Pengguna bertanggung jawab penuh atas:
                                <br>
                                • Keakuratan data yang dimasukkan
                                <br>
                                • Kerahasiaan akun dan password
                                <br>
                                • Segala aktivitas yang dilakukan melalui akun Anda
                            </p>
                        </div>
                        
                        <div>
                            <h5 class="font-semibold text-gray-800 mb-2">3. Proses Layanan</h5>
                            <p class="text-gray-700 text-sm">
                                • Pengajuan akan diproses sesuai urutan masuk
                                <br>
                                • Waktu proses tergantung kompleksitas permohonan
                                <br>
                                • Hasil dapat dilacak melalui sistem tracking
                                <br>
                                • Dokumen asli mungkin perlu diverifikasi di kantor
                            </p>
                        </div>
                        
                        <div>
                            <h5 class="font-semibold text-gray-800 mb-2">4. Pembatalan dan Perubahan</h5>
                            <p class="text-gray-700 text-sm">
                                Hak untuk membatalkan atau mengubah layanan:
                                <br>
                                • Admin berhak menolak pengajuan yang tidak memenuhi syarat
                                <br>
                                • Pengguna dapat membatalkan selama proses belum dimulai
                                <br>
                                • Perubahan data hanya dapat dilakukan pada tahap tertentu
                            </p>
                        </div>
                    </div>
                    
                    <div class="bg-red-50 border-l-4 border-red-400 p-4 mt-6">
                        <h5 class="font-semibold text-red-700 mb-2 flex items-center">
                            <i class="fas fa-exclamation-circle mr-2"></i> Penting
                        </h5>
                        <p class="text-red-700 text-sm">
                            Penggunaan data palsu atau penipuan akan dikenakan sanksi sesuai 
                            dengan peraturan perundang-undangan yang berlaku.
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Modal Footer -->
            <div class="bg-gray-50 px-6 py-4 rounded-b-xl flex justify-between items-center">
                <span class="text-gray-600 text-sm">
                    Terakhir diperbarui: {{ date('d F Y') }}
                </span>
                <button x-on:click="closeModal()"
                        class="px-5 py-2.5 bg-orange-600 text-white font-medium rounded-lg hover:bg-orange-700 transition duration-200">
                    Setuju dan Tutup
                </button>
            </div>
        </div>
    </div>
</div>