<x-app-layout>
    <div class="py-12 bg-black min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 border border-purple-900/50 overflow-hidden shadow-2xl rounded-2xl">
                <div class="p-8">
                    <h2 class="text-2xl font-black text-white uppercase tracking-tighter mb-6">
                        Editar <span class="text-purple-500">Evento</span>
                    </h2>
                    
                    @if ($errors->any())
                        <div class="bg-red-500/10 border border-red-500 text-red-500 p-4 rounded-xl mb-6">
                            <ul class="list-disc list-inside text-xs font-bold uppercase">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('events.update', $event) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT') <div x-data="{ imageUrl: '{{ $event->flyer_path ? asset('storage/' . $event->flyer_path) : null }}' }">
                            <label class="block text-xs font-bold text-purple-400 uppercase mb-2">Flyer del Evento</label>
                            
                            <div class="flex flex-col items-center justify-center w-full">
                                <label class="w-full flex flex-col items-center px-4 py-6 bg-gray-800 text-purple-400 rounded-xl border-2 border-dashed border-purple-900/50 cursor-pointer hover:border-purple-500 transition shadow-inner">
                                    <div x-show="!imageUrl" class="flex flex-col items-center">
                                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span class="text-sm font-bold uppercase tracking-widest">Seleccionar Imagen</span>
                                    </div>
                                    
                                    <input type="file" name="flyer" class="hidden" accept="image/*" 
                                        @change="const file = $event.target.files[0]; if (file) { imageUrl = URL.createObjectURL(file) }">
                                    
                                    <template x-if="imageUrl">
                                        <div class="relative w-full">
                                            <img :src="imageUrl" class="rounded-lg max-h-80 w-full object-cover shadow-2xl border border-purple-500/30">
                                            <div class="absolute bottom-2 right-2 bg-black/70 px-2 py-1 rounded text-[8px] text-white uppercase">Vista Previa</div>
                                        </div>
                                    </template>
                                </label>
                            </div>
                            @error('flyer') <p class="text-red-500 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="title" class="block text-xs font-bold text-purple-400 uppercase mb-2">Nombre del Evento</label>
                            <input type="text" name="title" id="title" value="{{ old('title', $event->title) }}" 
                                class="w-full bg-gray-800 border-gray-700 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition shadow-inner">
                            @error('title') <p class="text-red-500 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-purple-400 uppercase mb-2">Géneros Musicales</label>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 bg-gray-800/30 p-4 rounded-xl border border-gray-700/50">
                                @foreach($genres as $genre)
                                    <label class="flex items-center space-x-3 cursor-pointer group">
                                        <input type="checkbox" name="genres[]" value="{{ $genre->id }}" 
                                            class="rounded border-gray-700 text-purple-600 focus:ring-purple-500 bg-gray-900 transition"
                                            {{ (is_array(old('genres')) && in_array($genre->id, old('genres'))) || $event->genres->contains($genre->id) ? 'checked' : '' }}>
                                        <span class="text-xs text-gray-400 group-hover:text-white transition uppercase font-bold">{{ $genre->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('genres') <p class="text-red-500 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="lineup" class="block text-xs font-bold text-purple-400 uppercase mb-2">Line-up (Artistas)</label>
                            <input type="text" name="lineup" id="lineup" value="{{ old('lineup', $event->lineup) }}" 
                                class="w-full bg-gray-800 border-gray-700 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition shadow-inner">
                            @error('lineup') <p class="text-red-500 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-xs font-bold text-purple-400 uppercase mb-2">Descripción de la Experiencia</label>
                            <textarea name="description" id="description" rows="3" 
                                class="w-full bg-gray-800 border-gray-700 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition shadow-inner"
                                >{{ old('description', $event->description) }}</textarea>
                            @error('description') <p class="text-red-500 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="date" class="block text-xs font-bold text-purple-400 uppercase mb-2">Fecha</label>
                                <input type="date" name="date" id="date" value="{{ old('date', $event->date) }}" min="{{ date('Y-m-d') }}" 
                                    class="w-full bg-gray-800 border-gray-700 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition shadow-inner">
                                @error('date') <p class="text-red-500 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="start_time" class="block text-xs font-bold text-purple-400 uppercase mb-2">Apertura</label>
                                <input type="time" name="start_time" id="start_time" value="{{ old('start_time', substr($event->start_time, 0, 5)) }}"
                                    class="w-full bg-gray-800 border-gray-700 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition shadow-inner">
                                @error('start_time') <p class="text-red-500 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="end_time" class="block text-xs font-bold text-purple-400 uppercase mb-2">Cierre</label>
                                <input type="time" name="end_time" id="end_time" value="{{ old('end_time', substr($event->end_time, 0, 5)) }}"
                                    class="w-full bg-gray-800 border-gray-700 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition shadow-inner">
                                @error('end_time') <p class="text-red-500 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="location_name" class="block text-xs font-bold text-purple-400 uppercase mb-2">Dónde?</label>
                                <input type="text" name="location_name" id="location_name" value="{{ old('location_name', $event->location_name) }}"
                                    class="w-full bg-gray-800 border-gray-700 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition shadow-inner">
                                @error('location_name') <p class="text-red-500 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="neighborhood" class="block text-xs font-bold text-purple-400 uppercase mb-2">Barrio / Zona</label>
                                <input type="text" name="neighborhood" id="neighborhood" value="{{ old('neighborhood', $event->neighborhood) }}"
                                    class="w-full bg-gray-800 border-gray-700 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition shadow-inner">
                                @error('neighborhood') <p class="text-red-500 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t border-gray-800 pt-6">
                            <div>
                                <label for="price" class="block text-xs font-bold text-purple-400 uppercase mb-2">Precio Entrada (€)</label>
                                <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $event->price) }}"
                                    class="w-full bg-gray-800 border-gray-700 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition shadow-inner">
                                @error('price') <p class="text-red-500 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="price_info" class="block text-xs font-bold text-purple-400 uppercase mb-2">Detalles del Precio</label>
                                <input type="text" name="price_info" id="price_info" value="{{ old('price_info', $event->price_info) }}"
                                    class="w-full bg-gray-800 border-gray-700 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition shadow-inner">
                                @error('price_info') <p class="text-red-500 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="ticket_link" class="block text-xs font-bold text-purple-400 uppercase mb-2">Link de Venta de Entradas</label>
                            <input type="url" name="ticket_link" id="ticket_link" value="{{ old('ticket_link', $event->ticket_link) }}"
                                class="w-full bg-gray-800 border-gray-700 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition shadow-inner">
                            @error('ticket_link') <p class="text-red-500 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            @if(auth()->check() && auth()->user()->role->value === 'admin')
                                <label class="inline-flex items-center space-x-2 cursor-pointer">
                                    <input type="checkbox" name="is_verified" value="1" {{ $event->is_verified ? 'checked' : '' }} 
                                        class="rounded border-gray-700 text-purple-600 focus:ring-purple-500 bg-gray-900 transition">
                                    <span class="text-xs font-bold uppercase tracking-widest text-purple-400">Verificado</span>
                                </label>
                            @endif
                        </div>

                        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-800">
                            <a href="{{ route('events.my') }}" class="text-gray-500 hover:text-white text-xs font-bold uppercase transition">Cancelar</a>
                            <button type="submit" class="bg-purple-600 hover:bg-purple-500 text-white px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition shadow-lg shadow-purple-500/20">
                                Actualizar Evento
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>