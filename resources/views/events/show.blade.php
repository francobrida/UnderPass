<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }} | UnderPass</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-zinc-200 font-sans antialiased">

    <nav class="border-b border-zinc-800 px-6 py-4 flex justify-between items-center sticky top-0 bg-black/90 backdrop-blur-md z-50">
        <a href="{{ route('events.index') }}" class="text-xl font-black tracking-tighter uppercase italic text-white">
            Under<span class="text-purple-500">Pass</span>
        </a>
        <a href="{{ route('events.index') }}" class="text-[10px] font-bold uppercase tracking-widest text-zinc-500 hover:text-white transition">
            ← Volver
        </a>
    </nav>

    <main class="max-w-5xl mx-auto px-6 py-10">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12">
            
            <div class="md:col-span-5 space-y-8">
                <div class="border border-zinc-800 bg-zinc-900 rounded-lg overflow-hidden shadow-2xl">
                    @if($event->flyer)
                        <img src="{{ asset('storage/' . $event->flyer) }}" alt="{{ $event->title }}" class="w-full h-auto">
                    @else
                        <div class="aspect-[3/4] flex flex-col items-center justify-center text-zinc-700">
                            <span class="text-4xl mb-2">🖼️</span>
                            <span class="text-[10px] uppercase tracking-widest font-bold">Sin Flyer</span>
                        </div>
                    @endif
                </div>

                @if(auth()->id() === $event->user_id && $event->is_verified)
                    <div class="p-6 bg-zinc-900 border border-purple-500/30 rounded-xl text-center">
                        <h3 class="text-[10px] font-black uppercase tracking-[0.2em] mb-4 text-purple-400">Stamp QR Code</h3>
                        
                        @if($event->stamp_token)
                            @php
                                $claimUrl = route('events.stamp.claim', $event->stamp_token);
                                $qrUrl = "https://quickchart.io/qr?text=" . urlencode($claimUrl) . "&size=300&margin=2";
                            @endphp

                            <div class="bg-white p-3 inline-block rounded-lg mb-4">
                                <img src="{{ $qrUrl }}" alt="QR Code" class="w-44 h-44">
                            </div>
                            
                            <div class="space-y-3">
                                <a href="{{ $qrUrl }}" target="_blank" download="QR_{{ Str::slug($event->title) }}.png"
                                   class="block w-full py-3 bg-purple-600 hover:bg-purple-500 text-white text-[10px] font-bold uppercase tracking-widest rounded-lg transition">
                                    Descargar QR
                                </a>
                                <p class="text-[9px] text-zinc-500 uppercase tracking-tighter">Click para abrir y guardar imagen</p>
                            </div>
                        @else
                            <p class="text-[10px] text-red-500 uppercase font-black italic">⚠️ Token Missing</p>
                        @endif
                    </div>
                @endif
            </div>

            <div class="md:col-span-7">
                <header class="mb-8 border-b border-zinc-800 pb-8">
                    <div class="flex flex-wrap gap-2 mb-6">
                        @foreach($event->genres as $genre)
                            <span class="text-[9px] font-bold uppercase px-3 py-1 bg-zinc-800 text-purple-400 rounded-full border border-zinc-700">
                                #{{ $genre->name }}
                            </span>
                        @endforeach
                    </div>
                    
                    <h1 class="text-5xl md:text-6xl font-black uppercase tracking-tighter leading-[0.9] text-white mb-6">
                        {{ $event->title }}
                    </h1>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs font-bold uppercase tracking-widest text-zinc-400">
                        <div class="flex items-center"><span class="text-purple-500 mr-3">📅</span> {{ \Carbon\Carbon::parse($event->date)->format('d . m . Y') }}</div>
                        <div class="flex items-center"><span class="text-purple-500 mr-3">🕒</span> {{ substr($event->start_time, 0, 5) }}H - {{ substr($event->end_time, 0, 5) }}H</div>
                        <div class="flex items-center"><span class="text-purple-500 mr-3">📍</span> {{ $event->location_name }}</div>
                        <div class="flex items-center"><span class="text-purple-500 mr-3">🏘️</span> {{ $event->neighborhood }}</div>
                    </div>
                </header>

                <div class="space-y-10">
                    <section>
                        <h3 class="text-[7px] font-black text-zinc-600 uppercase tracking-widest mb-3 italic">// Info</h3>
                        <p class="text-zinc-300 leading-relaxed text-lg font-light">
                            {{ $event->description }}
                        </p>
                    </section>

                    <section>
                        <h3 class="text-[7px] font-black text-zinc-600 uppercase tracking-widest mb-3 italic">// Lineup</h3>
                        <div class="text-2xl font-black uppercase tracking-tighter text-white border-l-4 border-purple-500 pl-4 py-1 italic">
                            {{ $event->lineup }}
                        </div>
                    </section>

                    <section class="bg-zinc-900 border border-zinc-800 rounded-1xl p-8">
                        <div class="flex justify-between items-center mb-8">
                            <div>
                                <p class="text-[7px] font-bold text-zinc-500 uppercase tracking-widest mb-1">Precio Entrada</p>
                                <p class="text-2xl font-black text-white">
                                    {{ $event->price > 0 ? number_format($event->price, 0) . '€' : 'FREE' }}
                                </p>
                            </div>
                            @if($event->price_info)
                                <div class="text-right">
                                    <p class="text-[7px] font-bold text-zinc-500 uppercase tracking-widest mb-1">Detalles</p>
                                    <p class="text-zinc-300 font-bold uppercase text-xs">{{ $event->price_info }}</p>
                                </div>
                            @endif
                        </div>

                        <a href="{{ $event->ticket_link ?? '#' }}" target="_blank" 
                           class="block w-full py-4 bg-white hover:bg-purple-500 text-black hover:text-white text-center text-xs font-black uppercase tracking-[0.2em] rounded-xl transition-all duration-300 transform hover:-translate-y-1">
                            Conseguir Entradas ↗
                        </a>
                        
                        <p class="text-center text-[10px] text-zinc-600 mt-6 uppercase tracking-wider leading-relaxed">
                            *UnderPass no gestiona venta de entradas aún.<br>
                            <span class="italic text-zinc-700">(Patience my young padawan)</span>
                        </p>
                    </section>
                </div>
            </div>
        </div>
    </main>
</body>
</html>