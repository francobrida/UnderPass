<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waiting Room | UnderPass</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-zinc-100 font-sans antialiased">

    <nav class="border-b border-white/10 px-8 py-5 flex justify-between items-center bg-black">
        <a href="{{ route('events.index') }}" class="text-2xl font-black tracking-tighter uppercase italic">
            Under<span class="text-purple-500">Pass</span>
        </a>
    </nav>

    <main class="max-w-4xl mx-auto px-8 py-16">
        <header class="mb-14">
            <h1 class="text-4xl font-black uppercase tracking-tight italic">The Waiting Room</h1>
            <p class="text-zinc-500 text-xs uppercase tracking-widest mt-3">Verificación comunitaria: 3 confirmaciones para publicar en la agenda principal.</p>
        </header>

        <div class="divide-y divide-white/10 border-t border-b border-white/10">
            @forelse($events as $event)
                <div class="py-8 flex flex-col md:flex-row md:items-center justify-between gap-8">
                    
                    <div class="flex items-center gap-6">
                        <div class="w-16 h-16 bg-zinc-900 border border-white/10 flex-shrink-0">
                            @if($event->flyer)
                                <a href="{{ route('events.show', $event) }}">
                                    <img src="{{ asset('storage/' . $event->flyer) }}" class="w-full h-full object-cover opacity-70 hover:opacity-100 transition-opacity">
                                </a>
                            @endif
                        </div>
                        <div>
                            <a href="{{ route('events.show', $event) }}" class="group">
                                <h3 class="text-lg font-bold uppercase leading-none mb-2 group-hover:text-purple-500 transition-colors">
                                    {{ $event->title }}
                                </h3>
                            </a>
                            <p class="text-xs text-zinc-500 uppercase tracking-widest font-medium">
                                {{ \Carbon\Carbon::parse($event->date)->format('d F Y') }} 
                                <span class="mx-2 text-zinc-700">|</span> 
                                {{ $event->location_name }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-10 justify-between md:justify-end">
                        
                        <div class="text-right">
                            <div class="flex gap-1.5 mb-2 justify-end">
                                @for ($i = 1; $i <= 3; $i++)
                                    <div class="w-4 h-4 border-2 {{ $event->vouches_count >= $i ? 'bg-purple-500 border-purple-500' : 'border-zinc-800' }}"></div>
                                @endfor
                            </div>
                            <span class="text-[10px] font-black text-zinc-500 uppercase tracking-widest">
                                {{ $event->vouches_count }} / 3 Vouches
                            </span>
                        </div>

                        <div class="w-32 flex justify-end text-xs font-bold uppercase">
                            @if($event->user_id === auth()->id())
                                <span class="text-zinc-600 italic tracking-widest">Tu Evento</span>
                            @elseif($event->vouches()->where('user_id', auth()->id())->exists())
                                <span class="text-purple-500 tracking-widest">Confirmado</span>
                            @else
                                <form action="{{ route('events.vouch', $event) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="border-2 border-white px-6 py-3 hover:bg-white hover:text-black transition-all duration-300 tracking-widest font-black">
                                        Vouch
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="py-24 text-center text-zinc-600 text-sm uppercase tracking-[0.3em] italic">
                    No hay eventos pendientes de aprobación.
                </div>
            @endforelse
        </div>
    </main>

</body>
</html>