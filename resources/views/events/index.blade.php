<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UnderPass | Events Barcelona</title>

    <script src="https://cdn.tailwindcss.com"></script> </head>
<body class="bg-black text-gray-100 min-h-screen font-sans">

    <nav class="border-b border-gray-800 p-6 bg-black/50 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-black tracking-tighter text-white uppercase">
                Under<span class="text-purple-500">Pass</span>
            </h1>
            <div class="space-x-6 text-sm font-medium uppercase tracking-widest text-gray-400">
                <a href="#" class="hover:text-purple-400 transition">Eventos</a>
                <a href="#" class="hover:text-purple-400 transition">Mi Perfil</a>
                <a href="#" class="px-4 py-2 bg-purple-600 text-white rounded-full hover:bg-purple-700 transition">Login</a>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-6 py-12">
        <header class="mb-12">
            <h2 class="text-5xl font-extrabold mb-2 italic">PRÓXIMOS EVENTOS</h2>
            <p class="text-gray-500 uppercase tracking-widest text-sm">Explora la escena underground de Barcelona</p>
        </header>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($events as $event)
                <article class="group bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden hover:border-purple-500/50 transition-all duration-300 transform hover:-translate-y-2 shadow-2xl">
                    <div class="h-48 bg-gradient-to-br from-purple-900 to-black relative">
                        <img src="" -- aqui hay que cargar cada flyer. 
                             alt="Techno event" 
                             class="w-full h-full object-cover opacity-50 group-hover:opacity-70 transition-opacity">
                        <div class="absolute top-4 left-4">
                            <span class="bg-black/60 backdrop-blur-md text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest border border-white/20">
                                {{ $event->neighborhood }}
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-bold leading-tight group-hover:text-purple-400 transition-colors">
                                {{ $event->title }}
                            </h3>
                            <span class="text-purple-500 font-mono font-bold">{{ number_format($event->price, 0) }}€</span>
                        </div>

                        <p class="text-gray-400 text-sm line-clamp-2 mb-4 italic">
                            Lineup: {{ $event->lineup }}
                        </p>

                        <div class="flex items-center text-xs text-gray-500 space-x-4 mb-6">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ \Carbon\Carbon::parse($event->date)->format('d M') }}
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ substr($event->start_time, 0, 5) }}h
                            </div>
                        </div>

                        <button class="w-full py-3 bg-white text-black font-bold rounded-xl hover:bg-purple-500 hover:text-white transition-colors duration-300 uppercase text-xs tracking-widest">
                            Ver Detalles
                        </button>
                    </div>
                </article>
            @endforeach
        </div>
    </main>

</body>
</html>