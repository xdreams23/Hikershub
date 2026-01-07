<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
    <title>@yield('title', 'Welcome') - HikersHub</title>

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;700;800;900&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Montserrat', 'sans-serif'],
                            body: ['Poppins', 'sans-serif'],
                        },
                        colors: {
                            orange: {
                                500: '#FF5722',
                                600: '#E64A19',
                            }
                        }
                    }
                }
            }
        </script>
    @endif

    <style>
        body { font-family: 'Montserrat', sans-serif; }
        .font-body { font-family: 'Poppins', sans-serif; }
        
        /* Animasi */
        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .animate-slide-up { animation: slideInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        .animate-fade-in { animation: fadeIn 1.2s ease-out forwards; opacity: 0; }

        .delay-100 { animation-delay: 100ms; }
        .delay-300 { animation-delay: 300ms; }
        .delay-500 { animation-delay: 500ms; }
        
        /* Button Glow Effect */
        .btn-glow:hover {
            box-shadow: 0 0 20px rgba(255, 87, 34, 0.6);
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="antialiased bg-black h-screen w-full overflow-hidden relative selection:bg-orange-500 selection:text-white">

    <header class="absolute top-0 left-0 w-full z-30 p-8 md:px-16 flex items-center animate-fade-in">
        <div class="flex items-center gap-3 group cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-orange-500 transition-transform group-hover:scale-110" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2L2 19h20L12 2zm0 3.5l6.5 11.5h-13L12 5.5z"/>
                <path d="M12 8.5l-3.5 6h7l-3.5-6z" fill="rgba(255,255,255,0.3)"/>
            </svg>
            <span class="text-2xl font-black tracking-tighter text-white uppercase">HikersHub</span>
        </div>
    </header>

    <div class="absolute inset-0 z-0">
        <img 
            src="{{ asset('images/Dika.jpeg') }}" 
            alt="Mountain Expedition" 
            class="w-full h-full object-cover scale-105"
        >
        <div class="absolute inset-0 bg-gradient-to-r from-black via-black/70 to-transparent"></div>
    </div>

    <div class="relative z-10 flex flex-col justify-center h-full w-full md:w-2/3 px-8 md:px-16 lg:pl-24">
        
        <div class="animate-slide-up delay-100">
            <span class="inline-block py-1 px-3 rounded-full border border-orange-500/50 bg-orange-500/10 text-orange-400 text-xs md:text-sm font-bold tracking-widest uppercase mb-6 backdrop-blur-sm">
                The Ultimate Adventure Platform
            </span>
        </div>

        <h1 class="text-5xl md:text-7xl lg:text-8xl font-black text-white leading-[0.95] tracking-tighter mb-8 animate-slide-up delay-300">
            Conquer <br>
            Every Peak <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-500 to-orange-300">With Confidence.</span>
        </h1>

        <p class="font-body text-lg md:text-xl text-gray-300/90 font-light leading-relaxed max-w-xl mb-10 animate-slide-up delay-500 border-l-4 border-orange-500 pl-6">
            Experience high-performance hiking tailored for nature lovers. 
            Connect with expert guides, join elite expeditions, and create memories that last a lifetime.
        </p>

        <div class="flex flex-col md:flex-row items-start md:items-center gap-8 animate-slide-up delay-500">
            <a href="{{ route('home') }}" 
               class="btn-glow relative group overflow-hidden bg-gradient-to-r from-orange-600 to-orange-500 text-white px-10 py-5 rounded-full font-bold text-lg tracking-wide transition-all duration-300">
                <span class="relative z-10 flex items-center gap-2">
                    START YOUR JOURNEY 
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </span>
            </a>

            <div class="flex items-center gap-4 text-white/80 font-body text-sm">
                <div class="flex -space-x-2">
                    <div class="w-8 h-8 rounded-full bg-gray-600 border-2 border-black"></div>
                    <div class="w-8 h-8 rounded-full bg-gray-500 border-2 border-black"></div>
                    <div class="w-8 h-8 rounded-full bg-gray-400 border-2 border-black flex items-center justify-center text-[10px] font-bold">+5k</div>
                </div>
                <div>
                    <p class="font-bold text-white">Join 5,000+ Hikers</p>
                    <div class="flex text-orange-400 text-xs">★★★★★</div>
                </div>
            </div>
        </div>
    </div>

    <div class="absolute bottom-0 w-full z-20 px-8 py-8 border-t border-white/5 bg-gradient-to-t from-black to-transparent">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center text-xs text-gray-500 uppercase tracking-[0.2em] font-bold">
            <div class="flex gap-6 mb-2 md:mb-0">
                <span class="hover:text-orange-500 transition-colors cursor-default">I Komang Wisnu Wijaya</span>
                <span class="hover:text-orange-500 transition-colors cursor-default">Salma Anggieta</span>
                <span class="hover:text-orange-500 transition-colors cursor-default">Elvin Andika Pratama</span>
            </div>
            <div class="text-gray-600 font-normal tracking-normal normal-case font-body">
                © {{ date('Y') }} HikersHub Inc. All rights reserved.
            </div>
        </div>
    </div>

</body>
</html>