<x-app-layout>
    <div class="py-12 bg-black min-h-screen">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-10 gap-4">
                <div>
                    <h2 class="text-3xl font-black text-white uppercase tracking-tighter italic">
                        Mis <span class="text-purple-500">Eventos</span>
                    </h2>
                    <p class="text-gray-500 text-[10px] font-bold uppercase tracking-widest mt-1">Panel de organizador</p>
                </div>
                <a href="{{ route('events.create') }}" class="bg-purple-600 hover:bg-purple-500 text-white px-5 py-3 rounded-lg text-xs font-bold uppercase tracking-widest transition">
                    + Publicar Nuevo
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($events as $event)
                    <div class="bg-zinc-900 border border-gray-800 rounded-xl overflow-hidden hover:border-purple-500 transition-colors">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <a href="{{ route('events.show', $event) }}">
                                    <h3 class="text-white text-lg font-bold uppercase leading-tight hover:text-purple-400">
                                        {{ $event->title }}
                                    </h3>
                                </a>
                                
                                @if($event->is_verified)
                                    <span class="text-[9px] font-bold px-2 py-1 rounded bg-green-500/10 text-green-400 border border-green-500/20 uppercase">
                                        ✅ Verificado
                                    </span>
                                @else
                                    <span class="text-[9px] font-bold px-2 py-1 rounded bg-yellow-500/10 text-yellow-500 border border-yellow-500/20 uppercase">
                                        ⏳ Pendiente
                                    </span>
                                @endif
                            </div>

                            <p class="text-gray-500 text-xs line-clamp-2 mb-6 uppercase tracking-wide">
                                {{ $event->description }}
                            </p>
                            
                            <div class="flex items-center justify-between pt-4 border-t border-gray-800">
                                <a href="{{ route('events.edit', $event) }}" class="text-[10px] font-bold text-purple-400 hover:text-white uppercase tracking-widest">
                                    ✏️ Editar
                                </a>
                                
                                <form action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('¿Borrar evento? No hay vuelta atrás.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-[10px] font-bold text-gray-600 hover:text-red-500 uppercase tracking-widest">
                                        🗑️ Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full border border-dashed border-gray-800 rounded-xl py-20 text-center">
                        <p class="text-gray-600 font-bold uppercase tracking-widest text-xs mb-4">No tienes eventos publicados todavía.</p>
                        <a href="{{ route('events.create') }}" class="text-purple-500 font-bold uppercase text-xs hover:underline">
                            Empieza aquí →
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>