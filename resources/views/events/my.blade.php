<x-app-layout>
    <div class="py-12 bg-black min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="flex justify-between items-center mb-10">
                <div>
                    <h2 class="text-3xl font-black text-white uppercase tracking-tighter">
                        Mis <span class="text-purple-500">Eventos</span>
                    </h2>
                    <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mt-1">Panel de control</p>
                </div>
                <a href="{{ route('events.create') }}" class="bg-purple-600 hover:bg-purple-500 text-white px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition shadow-lg shadow-purple-500/20">
                    + Publicar Nuevo
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse ($events as $event)
                    <div class="bg-gray-900 border border-purple-900/20 rounded-2xl overflow-hidden hover:border-purple-500/50 transition-all duration-500 group">
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-xl font-bold text-white group-hover:text-purple-400 transition">{{ $event->title }}</h3>
                                
                                @if($event->is_verified)
                                    <span class="bg-green-500/10 text-green-400 text-[10px] font-black px-2 py-1 rounded-md border border-green-500/20 uppercase tracking-tighter">Verificado</span>
                                @else
                                    <span class="bg-yellow-500/10 text-yellow-500 text-[10px] font-black px-2 py-1 rounded-md border border-yellow-500/20 uppercase tracking-tighter">Pendiente</span>
                                @endif
                            </div>

                            <p class="text-gray-400 text-sm line-clamp-2 mb-6">{{ $event->description }}</p>
                            
                            <div class="flex items-center justify-between pt-4 border-t border-gray-800">
                                <a href="{{ route('events.edit', $event) }}" class="text-[10px] font-black text-purple-400 hover:text-white uppercase tracking-widest transition">
                                    Editar Flyer
                                </a>
                                
                                <form action="{{ route('events.destroy', $event) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este evento? No hay vuelta atrás.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-[10px] font-black text-gray-600 hover:text-red-500 uppercase tracking-widest transition">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full border-2 border-dashed border-gray-800 rounded-3xl py-20 text-center">
                        <p class="text-gray-500 font-bold uppercase tracking-widest text-sm mb-4">Tu lista de eventos está vacía</p>
                        <a href="{{ route('events.create') }}" class="text-purple-500 font-black uppercase text-xs hover:text-purple-400 transition">
                            Crea tu evento aquí →
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>