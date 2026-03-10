<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UnderPass | Electronic Events Barcelona</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-gray-100 min-h-screen font-sans">

    <nav class="border-b border-gray-800 p-6 bg-black sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-black tracking-tighter text-white uppercase cursor-pointer" onclick="window.location='/'">
                Under<span class="text-purple-500">Pass</span>
            </h1>
            
            <div class="flex items-center space-x-6 text-xs font-bold uppercase tracking-widest text-gray-400">
                @if(auth()->check())
                    @if(auth()->user()->role->value === 'admin')
                        <a href="{{ route('admin.index') }}" class="hover:text-purple-400">⚙️ Panel Admin</a>
                    @endif

                    <a href="{{ route('events.waiting-room') }}" class="hover:text-purple-400">⏳ Waiting Room</a>
                    <a href="{{ route('events.my') }}" class="hover:text-purple-400">🎫 Mis Eventos</a>
                    @auth
                        <a href="{{ route('user.stamps') }}" 
                           class="{{ request()->routeIs('user.stamps') ? 'text-purple-500' : 'text-gray-500 hover:text-white' }}">
                           🏅 Sellos y puntos
                        </a>
                    @endauth
                    <a href="/profile" class="hover:text-purple-400">👤 Perfil</a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-gray-600 hover:text-red-500 border border-gray-800 px-2 py-1 rounded">
                            Salir
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                        Entrar
                    </a>
                @endif
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-12">
        <header class="mb-12">
            <h2 class="text-4xl font-black mb-2 uppercase italic">Agenda Electrónica</h2>
            <p class="text-gray-500 uppercase tracking-widest text-xs">Barcelona Underground Scene</p>
        </header>
        
        <section class="mb-12 bg-zinc-900 p-6 rounded-xl border border-gray-800">
            <form action="{{ route('events.index') }}" method="GET">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                    
                    <div class="flex flex-col">
                        <label class="text-[10px] uppercase text-gray-500 mb-1 font-bold">Búsqueda</label>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Nombre..." 
                            class="bg-black border border-gray-700 rounded-lg px-3 py-2 text-sm text-white outline-none focus:border-purple-500">
                    </div>

                    <div class="flex flex-col">
                        <label class="text-[10px] uppercase text-gray-500 mb-1 font-bold">Barrio</label>
                        <select name="neighborhood" class="bg-black border border-gray-700 rounded-lg px-3 py-2 text-sm text-white outline-none">
                            <option value="">Todos</option>
                            <option value="Poblenou" {{ request('neighborhood') == 'Poblenou' ? 'selected' : '' }}>Poblenou</option>
                            <option value="Raval" {{ request('neighborhood') == 'Raval' ? 'selected' : '' }}>Raval</option>
                            <option value="Born" {{ request('neighborhood') == 'Born' ? 'selected' : '' }}>Born</option>
                            <option value="Poble-Sec" {{ request('neighborhood') == 'Poble-Sec' ? 'selected' : '' }}>Poble-Sec</option>
                            <option value="Eixample" {{ request('neighborhood') == 'Eixample' ? 'selected' : '' }}>Eixample</option>
                        </select>
                    </div>

                    <div class="flex flex-col">
                        <label class="text-[10px] uppercase text-gray-500 mb-1 font-bold">Estilo</label>
                        <select name="genre" class="bg-black border border-gray-700 rounded-lg px-3 py-2 text-sm text-white outline-none">
                            <option value="">Cualquiera</option>
                            @foreach($genres as $genre)
                                <option value="{{ $genre->id }}" {{ request('genre') == $genre->id ? 'selected' : '' }}>
                                    {{ $genre->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col">
                        <label class="text-[10px] uppercase text-gray-500 mb-1 font-bold">Precio</label>
                        <select name="price" class="bg-black border border-gray-700 rounded-lg px-3 py-2 text-sm text-white outline-none">
                            <option value="">Cualquiera</option>
                            <option value="asc" {{ request('price') == 'asc' ? 'selected' : '' }}>Más baratos</option>
                            <option value="desc" {{ request('price') == 'desc' ? 'selected' : '' }}>Más caros</option>
                        </select>
                    </div>

                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 bg-purple-600 hover:bg-purple-500 text-white font-bold py-2 rounded-lg text-xs uppercase transition">
                            Filtrar
                        </button>
                        <a href="{{ route('events.index') }}" class="bg-gray-800 px-3 py-2 rounded-lg text-sm" title="Limpiar">
                            🔄
                        </a>
                    </div>

                </div>
            </form>
        </section>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($events as $event)
                <article class="bg-zinc-900 border border-gray-800 rounded-xl overflow-hidden hover:border-purple-500 transition-colors">
                    
                    <div class="h-48 bg-gray-800 relative">
                        @if($event->flyer)
                            <img src="{{ asset('storage/' . $event->flyer) }}" alt="{{ $event->title }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-600 text-xs font-bold">SIN IMAGEN</div>
                        @endif
                        <div class="absolute top-3 left-3">
                            <span class="bg-black/90 text-white text-[10px] font-bold px-2 py-1 rounded border border-white/10 uppercase">
                                📍 {{ $event->neighborhood }}
                            </span>
                        </div>
                    </div>

                    <div class="p-5">
                        <div class="flex flex-wrap gap-2 mb-3">
                            @foreach($event->genres as $genre)
                                <span class="text-[10px] font-bold uppercase p-1 bg-purple-500/10 text-purple-400">
                                    #{{ $genre->name }}
                                </span>
                            @endforeach
                        </div>

                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-lg font-bold uppercase truncate pr-4">{{ $event->title }}</h3>
                            <span class="text-purple-500 font-bold">
                                {{ $event->price > 0 ? number_format($event->price, 0) . '€' : 'GRATIS' }}
                            </span>
                        </div>

                        <p class="text-gray-500 text-xs mb-4 uppercase">
                            <span class="text-gray-700">Lineup:</span> {{ $event->lineup }}
                        </p>

                        <div class="flex items-center text-xs text-gray-400 space-x-4 mb-5 font-bold">
                            <span>📅 {{ \Carbon\Carbon::parse($event->date)->format('d/m') }}</span>
                            <span>🕒 {{ substr($event->start_time, 0, 5) }}h</span>
                        </div>

                        <a href="{{ route('events.show', $event) }}" class="block w-full py-2 bg-white text-black font-bold rounded-lg hover:bg-purple-600 hover:text-white transition-colors text-center text-xs uppercase tracking-widest">
                            Ver más
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </main>
</body>
</html>