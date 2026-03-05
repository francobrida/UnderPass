<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Sellos | UnderPass</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-white font-sans antialiased">

    <nav class="border-b border-white/10 px-6 py-4 flex justify-between items-center bg-black sticky top-0 z-50">
        <a href="{{ route('events.index') }}" class="text-xl font-black tracking-tighter uppercase italic">
            Under<span class="text-purple-500">Pass</span>
        </a>
    </nav>

    <main class="max-w-6xl mx-auto px-6 py-12">
        <header class="mb-12">
            <h1 class="text-5xl font-black uppercase tracking-tighter italic">Mis Sellos</h1>
            <p class="text-zinc-500 text-xs uppercase tracking-widest mt-2">Historial de asistencia verificado en la red UnderPass.</p>
        </header>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($stamps as $stamp)
                <div class="group relative aspect-square border border-white/10 bg-zinc-900 overflow-hidden hover:border-purple-500/50 transition-colors">
                    
                    @if($stamp->event->flyer)
                        <img src="{{ asset('storage/' . $stamp->event->flyer) }}" 
                             class="absolute inset-0 w-full h-full object-cover opacity-20 grayscale group-hover:grayscale-0 group-hover:opacity-40 transition-all duration-500">
                    @endif

                    <div class="relative h-full p-6 flex flex-col justify-between z-10">
                        <div class="flex justify-between items-start">
                            <span class="text-[8px] font-black bg-purple-500 text-white px-2 py-0.5 uppercase tracking-tighter">Verified</span>
                            <span class="text-[8px] text-zinc-500 font-mono italic">#{{ str_pad($stamp->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>

                        <div>
                            <h3 class="text-sm font-black uppercase leading-tight mb-1">{{ $stamp->event->title }}</h3>
                            <p class="text-[9px] text-zinc-500 uppercase tracking-widest font-bold">
                                {{ \Carbon\Carbon::parse($stamp->scanned_at)->format('d.m.y') }}
                            </p>
                        </div>
                    </div>

                    <div class="absolute -bottom-4 -right-4 w-24 h-24 border-4 border-purple-500/20 rounded-full flex items-center justify-center rotate-12 pointer-events-none group-hover:border-purple-500/40 transition-colors">
                        <span class="text-[10px] font-black text-purple-500/20 uppercase group-hover:text-purple-500/40 tracking-tighter">STAMPED</span>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 border border-dashed border-white/10 text-center">
                    <p class="text-[10px] text-zinc-600 uppercase tracking-[0.4em] italic">Aún no has coleccionado ningún sello.</p>
                </div>
            @endforelse
        </div>
    </main>

</body>
</html>