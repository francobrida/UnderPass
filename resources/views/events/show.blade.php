<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $event->title }} | UnderPass</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-white font-sans antialiased">

    <nav class="border-b border-white/10 px-6 py-3 flex justify-between items-center sticky top-0 bg-black z-50">
        <a href="{{ route('events.index') }}" class="text-lg font-black tracking-tighter uppercase italic">
            Under<span class="text-purple-500">Pass</span>
        </a>
        <a href="{{ route('events.index') }}" class="text-[9px] font-bold uppercase tracking-[0.2em] text-gray-500 hover:text-purple-500 transition">
            ← Volver
        </a>
    </nav>

    <main class="max-w-5xl mx-auto px-6 py-8">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
            
            <div class="md:col-span-5">
                <div class="sticky top-20 space-y-6">
                    <div class="border border-white/10 bg-zinc-900">
                        @if($event->flyer)
                            <img src="{{ asset('storage/' . $event->flyer) }}" alt="{{ $event->title }}" class="w-full">
                        @else
                            <div class="aspect-[3/4] flex items-center justify-center text-[9px] uppercase tracking-widest text-gray-600">No Flyer</div>
                        @endif
                    </div>

                    @if(auth()->id() === $event->user_id)
                        <div class="p-6 border border-white/10 bg-zinc-950 text-center">
                            <h3 class="text-[9px] font-black uppercase tracking-[0.3em] mb-4 text-gray-500 italic">Stamp QR Code</h3>
                            
                            @if($event->stamp_token)
                                @php
                                    // To generate the QR code URL
                                    $claimUrl = route('events.stamp.claim', $event->stamp_token);
                                    
                                    // Using external service QuickChart to generate QR code image URL
                                    $qrUrl = "https://quickchart.io/qr?text=" . urlencode($claimUrl) . "&size=300&margin=2";
                                @endphp

                                <div class="bg-white p-2 inline-block mb-4 shadow-[0_0_15px_rgba(255,255,255,0.1)]">
                                    <img src="{{ $qrUrl }}" alt="QR Code" class="w-40 h-40">
                                </div>
                                
                                <div class="flex flex-col gap-2">
                                    <a href="{{ $qrUrl }}" 
                                    target="_blank"
                                    download="QR_STAMP_{{ Str::slug($event->title) }}.png"
                                    class="inline-block w-full py-2 border border-white/20 text-[9px] font-black uppercase tracking-widest hover:bg-white hover:text-black transition-all duration-300">
                                        Descargar QR 
                                    </a>
                                    <p class="text-[8px] text-zinc-600 uppercase tracking-tighter">Click para abrir y guardar imagen</p>
                                </div>
                            @else
                                <div class="py-2">
                                    <p class="text-[9px] text-red-500 uppercase font-black italic">Token Missing</p>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <div class="md:col-span-7">
                <header class="mb-6 border-b border-white/10 pb-6">
                    <div class="flex gap-1.5 mb-4">
                        @foreach($event->genres as $genre)
                            <span class="text-[8px] font-black uppercase tracking-tighter px-2 py-0.5 bg-purple-500/10 text-purple-400 border border-purple-500/20">
                                #{{ $genre->name }}
                            </span>
                        @endforeach
                    </div>
                    
                    <h1 class="text-4xl md:text-5xl font-black uppercase tracking-tighter leading-none mb-5">
                        {{ $event->title }}
                    </h1>
                    
                    <div class="grid grid-cols-2 gap-3 text-[10px] font-bold uppercase tracking-widest text-gray-400">
                        <div class="flex items-center">
                            <span class="text-purple-500 mr-2 text-[8px]">●</span> {{ \Carbon\Carbon::parse($event->date)->format('d.m.Y') }}
                        </div>
                        <div class="flex items-center">
                            <span class="text-purple-500 mr-2 text-[8px]">●</span> {{ substr($event->start_time, 0, 5) }}H - {{ substr($event->end_time, 0, 5) }}H
                        </div>
                        <div class="flex items-center">
                            <span class="text-purple-500 mr-2 text-[8px]">●</span> {{ $event->neighborhood }}
                        </div>
                        <div class="flex items-center">
                            <span class="text-purple-500 mr-2 text-[8px]">●</span> {{ $event->location_name }}
                        </div>
                    </div>
                </header>

                <div class="space-y-8">
                    <section>
                        <h3 class="text-[9px] font-black text-gray-600 uppercase tracking-[0.3em] mb-2">Info</h3>
                        <p class="text-gray-300 leading-snug font-light text-base">
                            {{ $event->description }}
                        </p>
                    </section>

                    <section>
                        <h3 class="text-[9px] font-black text-gray-600 uppercase tracking-[0.3em] mb-2">Lineup</h3>
                        <p class="text-xl font-bold uppercase tracking-tight text-white italic border-l-2 border-purple-500 pl-3">
                            {{ $event->lineup }}
                        </p>
                    </section>

                    <section class="bg-zinc-950 border border-white/10 p-6">
                        <div class="flex justify-between items-end mb-6">
                            <div>
                                <p class="text-[9px] font-black text-gray-500 uppercase tracking-widest mb-0.5">Precio</p>
                                <p class="text-4xl font-black text-white">
                                    {{ $event->price > 0 ? number_format($event->price, 0) . '€' : 'FREE' }}
                                </p>
                            </div>
                        </div>

                        <a href="{{ $event->ticket_link ?? 'https://ra.co' }}" target="_blank" 
                           class="block w-full py-3 bg-white text-black text-center text-[11px] font-black uppercase tracking-widest hover:bg-purple-600 hover:text-white transition-colors">
                            Conseguir Entradas ↗
                        </a>
                        
                        <p class="text-center text-[12px] text-gray-600 mt-3 uppercase tracking-[0.2em]">
                            *UnderPass no gestiona venta de entradas. (por ahora, patience my young padawan)
                        </p>
                    </section>
                </div>
            </div>
        </div>
    </main>
</body>
</html>