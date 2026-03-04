<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UnderPass | Events Barcelona</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-gray-100 min-h-screen font-sans">

    <nav class="border-b border-gray-800 p-6 bg-black/50 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-black tracking-tighter text-white uppercase cursor-pointer" onclick="window.location='/'">
                Under<span class="text-purple-500">Pass</span>
            </h1>
            
            <div class="flex items-center space-x-6 text-sm font-medium uppercase tracking-widest text-gray-400">
                {{-- Comprobación manual de sesión --}}
                @if(auth()->check())
                    
                    {{-- Comprobación manual de Admin (por ID o por Rol) --}}
                    @if(auth()->check() && auth()->user()->role->value === 'admin')
                        <a href="{{ route('admin.index') }}" class="...">
                            Panel de Admin
                        </a>
                    @endif

                    <a href="{{ route('events.my') }}" class="hover:text-purple-400 transition">Mis Eventos</a>
                    <a href="/profile" class="hover:text-purple-400 transition">Mi Perfil</a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-red-500 transition text-[10px] font-black uppercase border border-gray-800 px-3 py-1 rounded-lg">
                            Logout
                        </button>
                    </form>

                @else
                    {{-- Si no hay sesión iniciada --}}
                    <a href="{{ route('login') }}" class="px-5 py-2 bg-purple-600 text-white rounded-full hover:bg-purple-700 transition shadow-lg shadow-purple-500/20">
                        Login
                    </a>
                @endif
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-12">
        <header class="mb-12">
            <h2 class="text-5xl font-extrabold mb-2 italic tracking-tighter">AGENDA DEL UNDER</h2>
            <p class="text-gray-500 uppercase tracking-widest text-sm">Explora la escena underground de Barcelona</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($events as $event)
                <article class="group bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden hover:border-purple-500/50 transition-all duration-300 transform hover:-translate-y-2 shadow-2xl">
                    
                    <div class="h-56 bg-gray-800 relative overflow-hidden">
                        @if($event->flyer)
                            <img src="{{ asset('storage/' . $event->flyer) }}" 
                                 alt="Flyer de {{ $event->title }}" 
                                 class="w-full h-full object-cover opacity-60 group-hover:opacity-100 transition-opacity duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-purple-900/20 text-purple-500 uppercase text-[10px] font-black tracking-widest">No_Flyer_Available</div>
                        @endif

                        <div class="absolute top-4 left-4">
                            <span class="bg-black/80 backdrop-blur-md text-white text-[9px] font-bold px-3 py-1 rounded-md uppercase tracking-widest border border-white/10">
                                {{ $event->neighborhood }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach($event->genres as $genre)
                                <span class="text-[9px] font-black uppercase tracking-tighter px-2 py-0.5 rounded bg-purple-500/10 text-purple-400 border border-purple-500/20">
                                    #{{ $genre->name }}
                                </span>
                            @endforeach
                        </div>

                        <div class="flex justify-between items-start mb-3">
                            <h3 class="text-xl font-bold leading-tight group-hover:text-purple-400 transition-colors uppercase">
                                {{ $event->title }}
                            </h3>
                            <span class="text-purple-500 font-mono font-bold text-lg">
                                {{ $event->price > 0 ? number_format($event->price, 0) . '€' : 'GRATIS' }}
                            </span>
                        </div>

                        <p class="text-gray-400 text-xs line-clamp-2 mb-4 font-medium uppercase tracking-wide">
                            <span class="text-gray-600 italic">Lineup:</span> {{ $event->lineup }}
                        </p>

                        <div class="flex items-center text-[11px] text-gray-500 space-x-4 mb-6 font-bold uppercase tracking-widest">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1.5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ \Carbon\Carbon::parse($event->date)->format('d M') }}
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1.5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ substr($event->start_time, 0, 5) }}H
                            </div>
                        </div>

                        <a href="{{ route('events.show', $event) }}" class="block w-full py-3 bg-white text-black font-black rounded-xl hover:bg-purple-600 hover:text-white transition-all duration-300 uppercase text-[10px] tracking-[0.2em] text-center">
                            VER EVENTO
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </main>
</body>
</html>