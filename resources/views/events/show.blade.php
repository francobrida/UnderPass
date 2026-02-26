<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }} | UnderPass</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-gray-100 min-h-screen font-sans antialiased">

    <nav class="border-b border-gray-800 p-6 bg-black/50 backdrop-blur-md sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="{{ route('events.index') }}" class="text-2xl font-black tracking-tighter text-white uppercase hover:opacity-80 transition">
                Under<span class="text-purple-500">Pass</span>
            </a>
            <a href="{{ route('events.index') }}" class="text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-purple-400 transition">
                ← Volver a eventos
            </a>
        </div>
    </nav>

    <main class="max-w-5xl mx-auto px-6 py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <div class="lg:col-span-5">
                <div class="sticky top-28">
                    <div class="relative group rounded-3xl overflow-hidden border border-gray-800 shadow-2xl">
                       <img src="{{ $event->flyer }}" 
                            alt="Flyer de {{ $event->title }}" 
                            class="w-full object-cover aspect-[4/4] group-hover:scale-105 transition-transform duration-700">
                    </div>
                </div>
            </div>

            <div class="lg:col-span-7 flex flex-col">
                <header class="mb-8">
                    <div class="flex flex-wrap gap-2 mb-4">
                        @foreach($event->genres as $genre)
                            <span class="text-[10px] font-bold uppercase tracking-widest px-3 py-1 bg-gray-900 border border-gray-800 text-purple-400 rounded-lg">
                                #{{ $genre->name }}
                            </span>
                        @endforeach
                    </div>
                    
                    <h1 class="text-6xl font-black text-white uppercase tracking-tighter leading-none mb-4">
                        {{ $event->title }}
                    </h1>
                    
                    <div class="flex items-center space-x-6 text-gray-400">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <span class="font-bold uppercase tracking-tight">{{ \Carbon\Carbon::parse($event->date)->format('d.m.Y') }}</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <span class="font-bold uppercase tracking-tight">{{ substr($event->start_time, 0, 5) }}h - {{ substr($event->end_time, 0, 5) }}h</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" /></svg>
                            <span class="font-bold uppercase tracking-tight">{{ $event->neighborhood }}</span>
                        </div>
                    </div>
                </header>

                <div class="space-y-8 flex-grow">
                    <section class="p-6 bg-gray-900/50 border border-gray-800 rounded-2xl italic text-gray-300 leading-relaxed">
                        "{{ $event->description }}"
                    </section>

                    <section>
                        <h3 class="text-xs font-black text-gray-500 uppercase tracking-[0.3em] mb-3">Lineup</h3>
                        <p class="text-xl font-medium text-white tracking-wide">
                            {{ $event->lineup }}
                        </p>
                    </section>

                    <section class="pt-8 border-t border-gray-800">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <p class="text-xs font-black text-gray-500 uppercase tracking-[0.3em]">Precio Aprox.</p>
                                <p class="text-4xl font-black text-purple-500">{{ number_format($event->price, 2) }}€</p>
                            </div>
                            <div class="text-right">
                                <p class="text-xs font-black text-gray-500 uppercase tracking-[0.3em]">Ubicación</p>
                                <p class="text-lg font-bold text-white">{{ $event->location_name }}</p>
                            </div>
                        </div>

                        <a href="https://ra.co" target="_blank" class="block w-full py-5 bg-purple-600 hover:bg-purple-700 text-white text-center font-black uppercase tracking-[0.2em] rounded-2xl shadow-lg shadow-purple-900/20 transition-all transform hover:-translate-y-1">
                            Ver entradas en Resident Advisor ↗
                        </a>
                        <p class="text-center text-gray-600 text-[10px] mt-4 uppercase tracking-widest">
                            *UnderPass no gestiona venta de entradas. (por ahora, patience my young padawan)
                        </p>
                    </section>
                </div>
            </div>
        </div>
    </main>

</body>
</html>