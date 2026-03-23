<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <h2 class="text-white text-2xl font-black uppercase tracking-tighter">
                Próximos Eventos
            </h2>

            <a href="{{ route('events.create') }}" class="bg-purple-600 hover:bg-purple-500 text-white px-6 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition shadow-lg shadow-purple-500/20 w-fit">
                + Crear Evento
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @foreach($nextEvents as $event)
                <div class="bg-zinc-900 border border-zinc-800 rounded-2xl overflow-hidden shadow-2xl group flex flex-col">
              
                    <div class="relative h-48 w-full overflow-hidden">
                        <img src="{{ asset('storage/' . $event->flyer) }}" 
                             alt="{{ $event->title }}" 
                             class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        
                        <div class="absolute top-3 right-3 z-10">
                            @if($event->is_verified)
                                <span class="bg-purple-600 text-white text-[9px] font-black px-2.5 py-1 rounded-md uppercase tracking-widest shadow-2xl border border-purple-400/30">
                                    Verificado
                                </span>
                            @else
                                <span class="bg-black/60 backdrop-blur-md text-zinc-500 text-[9px] font-black px-2.5 py-1 rounded-md uppercase tracking-widest border border-zinc-700/50">
                                    Pendiente
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="p-6">
                        <h3 class="text-white font-bold text-lg mb-1">{{ $event->title }}</h3>
                        <p class="text-zinc-500 text-xs uppercase tracking-widest mb-4">{{ $event->date }}</p>
                        
                        <div class="flex justify-between items-center mt-auto">
                            <a href="{{ route('events.edit', $event) }}" 
                               class="text-purple-500 text-xs font-black uppercase hover:text-purple-400 transition-colors">
                                Editar Evento
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="border-t border-zinc-800 my-10"></div>

        <h2 class="text-zinc-500 text-xl font-bold mb-6 uppercase tracking-tight">Historial de Eventos Pasados</h2>

        <div class="space-y-4">
            @foreach($pastEvents as $event)
                <div class="bg-zinc-900/40 border border-zinc-800 p-4 rounded-xl flex flex-col md:flex-row justify-between items-center gap-4 opacity-70 hover:opacity-100 transition-all">
                    <div class="flex items-center gap-4 w-full md:w-auto">
                        <img src="{{ asset('storage/' . $event->flyer) }}" 
                             class="w-12 h-12 object-cover rounded-lg grayscale">
                        
                        <div>
                            <h3 class="text-zinc-300 font-bold">{{ $event->title }}</h3>
                            <div class="flex items-center gap-2">
                                <p class="text-zinc-600 text-xs">Finalizado el {{ $event->date }}</p>
                                @if($event->is_verified)
                                    <span class="text-[8px] text-purple-500 uppercase font-black tracking-tighter">● Verificado</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('events.feedback', $event) }}" 
                       class="w-full md:w-auto text-center bg-zinc-800 text-zinc-300 px-6 py-2 rounded-lg text-xs font-black hover:bg-white hover:text-black transition-all duration-300">
                        VER FEEDBACK ANÓNIMO
                    </a>
                </div>
            @endforeach

            @if($pastEvents->isEmpty())
                <div class="text-zinc-700 text-sm italic text-center py-10 border border-dashed border-zinc-800 rounded-xl">
                    No hay registros en el historial.
                </div>
            @endif
        </div>

    </div>
</x-app-layout>