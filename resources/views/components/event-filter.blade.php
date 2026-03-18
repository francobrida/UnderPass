
<div>
    
    <section class="mb-12 bg-zinc-900 p-6 rounded-xl border border-gray-800">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
            
            <div class="flex flex-col">
                <label class="text-[10px] uppercase text-gray-500 mb-1 font-bold">Búsqueda</label>
                <input wire:model.live="search" type="text" placeholder="Nombre..." 
                    class="bg-black border border-gray-700 rounded-lg px-3 py-2 text-sm text-white outline-none focus:border-purple-500">
            </div>

            <div class="flex flex-col">
                <label class="text-[10px] uppercase text-gray-500 mb-1 font-bold">Barrio</label>
                <select wire:model.live="neighborhood" class="bg-black border border-gray-700 rounded-lg px-3 py-2 text-sm text-white outline-none focus:border-purple-500">
                    <option value="">Todos</option>
                    @foreach($neighborhoods as $n)
                        <option value="{{ $n }}">{{ $n }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col">
                <label class="text-[10px] uppercase text-gray-500 mb-1 font-bold">Estilo</label>
                <select wire:model.live="genre" class="bg-black border border-gray-700 rounded-lg px-3 py-2 text-sm text-white outline-none">
                    <option value="">Cualquiera</option>
                    @foreach($genres as $g)
                        <option value="{{ $g->id }}">{{ $g->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col">
                <label class="text-[10px] uppercase text-gray-500 mb-1 font-bold">Precio</label>
                <select wire:model.live="price" class="bg-black border border-gray-700 rounded-lg px-3 py-2 text-sm text-white outline-none">
                    <option value="">Cualquiera</option>
                    <option value="asc">Más baratos</option>
                    <option value="desc">Más caros</option>
                </select>
            </div>

            <div class="flex items-end">
                <button wire:click="$set('search', ''); $set('neighborhood', ''); $set('genre', ''); $set('price', '');" 
                        class="w-full bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 rounded-lg text-xs uppercase transition">
                    Limpiar Filtros 🔄
                </button>
            </div>
        </div>
    </section>

    {{-- main events GRID --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($events as $event)
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
                        <h3 class="text-lg font-bold uppercase truncate pr-4 text-white">{{ $event->title }}</h3>
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
        @empty
            <div class="col-span-full py-20 text-center border border-dashed border-gray-800 rounded-xl">
                <p class="text-gray-600 uppercase tracking-widest text-xs">No hay eventos que coincidan</p>
            </div>
        @endforelse
    </div>
</div>