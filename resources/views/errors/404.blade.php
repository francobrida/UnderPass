<x-app-layout>
    <div class="min-h-screen bg-black flex flex-col items-center justify-center text-center px-4">
        <h1 class="text-9xl font-black text-purple-600 animate-pulse tracking-tighter">
            404
        </h1>
        
        <div class="mt-4">
            <h2 class="text-2xl font-bold text-white uppercase tracking-widest">
                No Encontrado
            </h2>
            <p class="text-gray-500 mt-2 max-w-md mx-auto font-medium">
                Ups,  
                Este evento no existe o el acceso está restringido.
            </p>
        </div>

        <a href="{{ route('events.index') }}" 
           class="mt-10 bg-purple-600 hover:bg-purple-500 text-white px-8 py-4 rounded-2xl text-xs font-black uppercase tracking-widest transition-all shadow-lg shadow-purple-500/20">
            Volver a la agenda
        </a>

        <div class="mt-12 opacity-20">
            <span class="text-[10px] text-purple-400 uppercase font-mono tracking-[0.5em]">
                System Error // Connection Lost
            </span>
        </div>
    </div>
</x-app-layout>