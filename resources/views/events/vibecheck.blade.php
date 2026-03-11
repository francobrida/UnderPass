<x-app-layout>
    <div class="py-12 bg-black min-h-screen">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-900/50 border border-red-500 text-red-200 rounded-lg">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-gray-900 border border-purple-900 p-8 rounded-2xl shadow-xl">
                <h2 class="text-xl font-bold text-white uppercase text-center mb-6">
                    Vibe<span class="text-purple-500">Check</span>: {{ $event->title }}
                </h2>

                <form action="{{ route('events.vibecheck.store', $event) }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-purple-400 text-xs font-bold uppercase mb-2">Puntaje Sonido (1 al 5)</label>
                        <input type="number" name="sound_score" min="1" max="5" required
                            class="w-full bg-gray-800 border-gray-700 text-white rounded-lg focus:ring-purple-500 shadow-inner">
                    </div>

                    <div>
                        <label class="block text-purple-400 text-xs font-bold uppercase mb-2">Puntaje Espacio Seguro (1 al 5)</label>
                        <input type="number" name="safe_space_score" min="1" max="5" required
                            class="w-full bg-gray-800 border-gray-700 text-white rounded-lg focus:ring-purple-500 shadow-inner">
                    </div>

                    <div>
                        <label class="block text-purple-400 text-xs font-bold uppercase mb-2">Tu Review Privada</label>
                        <textarea name="comment" rows="3" required
                            class="w-full bg-gray-800 border-gray-700 text-white rounded-lg focus:ring-purple-500 shadow-inner"
                            placeholder="¿Qué tal la experiencia?"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-black py-4 rounded-xl uppercase tracking-widest transition transform active:scale-95 shadow-lg shadow-purple-500/20">
                        Enviar VibeCheck (+5 pts)
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>