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

        <livewire:event-filter />
        
    </main>
</body>
</html>