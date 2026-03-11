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

        <p class="text-2xl font-black uppercase tracking-tighter italic">Mis Puntos: {{ $user->points }}</p>
    </nav>

    <main class="max-w-6xl mx-auto px-6 py-12">
        
        @if (session('success'))
            <div class="mb-8 p-4 bg-purple-900/30 border border-purple-500 text-purple-200 text-xs font-bold uppercase tracking-widest rounded-lg animate-pulse">
                {{ session('success') }}
            </div>
        @endif

        <header class="mb-12">
            <h1 class="text-5xl font-black uppercase tracking-tighter italic">Mis Sellos</h1>
            <p class="text-zinc-500 text-xs uppercase tracking-widest mt-2">Historial de asistencia verificado en la red UnderPass.</p>
        </header>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-7">
            @if(count($stamps) > 0)
                @foreach($stamps as $stamp)
                    <div class="group relative aspect-ratio-1/2 border border-white/10 bg-zinc-900 overflow-hidden">

                        <div class="relative h-full p-7 flex flex-col justify-between z-10 ">
                            <div>
                                <h3 class="text-m font-black uppercase leading-tight mb-1">{{ $stamp->event->title }}</h3>
                                <p class="text-[10px] text-zinc-500 uppercase pb-3 tracking-widest font-bold">
                                    {{ \Carbon\Carbon::parse($stamp->scanned_at)->format('d.m.y') }}
                                </p>
                            </div>

                            @php
                                $eventEnd = \Carbon\Carbon::parse($stamp->event->date . ' ' . $stamp->event->end_time);
                                $canVibeCheck = now()->greaterThan($eventEnd->addHours(6)); // sorry, a bit hardcoded
                                $alreadyVoted = $stamp->event->vibeChecks->where('user_id', auth()->id())->isNotEmpty();
                            @endphp

                            <div class="mt-4">
                                @if($alreadyVoted)
                                    <div class="w-full py-2 bg-zinc-800 text-zinc-600 text-[9px] font-black uppercase tracking-widest text-center border border-white/5">
                                        ✓ Vibecheck Realizado
                                    </div>
                                @elseif($canVibeCheck)
                                    <a href="{{ route('events.vibecheck', $stamp->event->id) }}" 
                                    class="block w-full py-2 bg-purple-600 text-[9px] font-black uppercase tracking-widest text-center hover:bg-white hover:text-black transition-colors">
                                        Vibecheck Disponible
                                    </a>
                                @else
                                    <div class="text-[9px] text-zinc-600 uppercase font-bold tracking-widest">
                                        Vibecheck próximamente...
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="absolute -bottom-4 -right-4 w-24 h-24 border-4 border-purple-500/20 rounded-full flex items-center justify-center rotate-12 pointer-events-none group-hover:border-purple-500/40 transition-colors">
                            <span class="text-[16px] font-black text-purple-500/20 uppercase tracking-tighter italic">OK</span>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-span-full py-20 border border-dashed border-white/10 text-center">
                    <p class="text-[10px] text-zinc-600 uppercase tracking-[0.4em] italic">Aún no has coleccionado ningún sello.</p>
                </div>
            @endif
        </div>
    </main>

</body>
</html>