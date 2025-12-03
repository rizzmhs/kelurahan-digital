<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem Layanan Kelurahan Terpadu') }} @isset($title) - {{ $title }} @endisset</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Additional Fonts & Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Custom Styles -->
    <style>
        /* Keep your existing styles here */
        .font-poppins { font-family: 'Poppins', sans-serif; }
        /* ... rest of your styles ... */
    </style>
    
    <!-- Additional Styles -->
    @stack('styles')
</head>
<body class="font-poppins antialiased" x-data="{
    // Navigation state
    open: false, 
    profileOpen: false,
    
    // Modal state
    modalOpen: false,
    activeModal: null,
    
    // Modal methods
    showModal(modalId) {
        this.activeModal = modalId;
        this.modalOpen = true;
        document.body.style.overflow = 'hidden';
    },
    
    closeModal() {
        this.activeModal = null;
        this.modalOpen = false;
        document.body.style.overflow = 'auto';
    },
    
    isModalOpen(modalId) {
        return this.activeModal === modalId;
    }
}" 
x-on:keydown.escape.window="closeModal()"
x-on:show-modal.window="showModal($event.detail.modalId)"
:class="{ 'overflow-hidden': modalOpen }">

<!-- Navigation -->
<nav class="bg-blue-600 border-b border-blue-500 fixed w-full top-0 shadow-md" style="z-index: 9999;">
    <!-- Your existing navigation code here -->
    @include('layouts.partials.navigation')
</nav>

<!-- Main Content -->
<div class="min-h-screen bg-gray-100 pt-16">
    <!-- Flash Messages -->
    @if(session('success'))
        <div class="alert-auto-hide max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg relative" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <strong class="font-bold">Sukses!</strong>
                    <span class="block sm:inline ml-2">{{ session('success') }}</span>
                </div>
                <button class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert-auto-hide max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline ml-2">{{ session('error') }}</span>
                </div>
                <button class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert-auto-hide max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8">
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded-lg relative" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <strong class="font-bold">Peringatan!</strong>
                    <span class="block sm:inline ml-2">{{ session('warning') }}</span>
                </div>
                <button class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    @if(session('info'))
        <div class="alert-auto-hide max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8">
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-lg relative" role="alert">
                <div class="flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    <strong class="font-bold">Info!</strong>
                    <span class="block sm:inline ml-2">{{ session('info') }}</span>
                </div>
                <button class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.parentElement.remove()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif

    <!-- Page Header -->
    @if(isset($header))
        <header class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <!-- Page Content -->
    <main class="flex-1">
        {{ $slot }}
    </main>
</div>

<!-- Footer -->
@include('layouts.footer')

<!-- Alpine.js -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<!-- Your existing JavaScript code -->
<script>
    // Auto hide success/error messages after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        // ... your existing JavaScript code ...
    });
</script>

<!-- Custom Scripts -->
@stack('scripts')
</body>
</html>