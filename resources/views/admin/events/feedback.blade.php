<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl text-white font-bold">
            Feedback de: {{ $event->title }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4">
            
            <h3 class="text-white mb-4 text-sm uppercase">Comentarios de los asistentes:</h3>

            <div class="space-y-4">
                @foreach($event->vibeChecks as $check)
                  
                    <div class="bg-gray-900 border border-gray-700 p-4 rounded-lg">
                        
                        <div class="mb-2">
                            <span class="text-purple-400 font-bold">Clubber Anónimo</span>
                            <span class="text-gray-500 text-xs ml-2">- {{ $check->created_at->format('d/m/Y') }}</span>
                        </div>

                       
                        <div class="bg-black p-2 rounded mb-3 inline-block">
                            <p class="text-xs text-gray-300">
                                Sonido: <b>{{ $check->sound_score }}/5</b> | 
                                Seguridad: <b>{{ $check->safe_space_score }}/5</b>
                            </p>
                        </div>

                        <p class="text-white text-base">
                            "{{ $check->comment }}"
                        </p>
                    </div>
                @endforeach

                @if($event->vibeChecks->isEmpty())
                    <div class="text-center p-10 border border-dashed border-gray-700 rounded">
                        <p class="text-gray-500">Nadie ha dejado feedback todavía...</p>
                    </div>
                @endif
            </div>

            <div class="mt-6">
                <a href="{{ route('events.my') }}" class="text-purple-500 underline text-sm">
                    Volver a mis eventos
                </a>
            </div>

        </div>
    </div>
</x-app-layout>