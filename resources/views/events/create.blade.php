<x-app-layout>
    <div class="py-12 bg-black min-h-screen">
        <div class="max-w-2xl mx-auto px-6 lg:px-8">
            <div class="bg-zinc-900 border border-gray-800 overflow-hidden rounded-xl">
                <div class="p-8">
                    <h2 class="text-2xl font-black text-white uppercase tracking-tighter mb-6 italic">
                        Nuevo <span class="text-purple-500">Evento</span>
                    </h2>

                    @if ($errors->any())
                        <div class="bg-red-900/20 border border-red-500 text-red-500 p-4 rounded-lg mb-6">
                            <ul class="list-disc list-inside text-xs font-bold uppercase">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div x-data="{ imageUrl: null }">
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2">🖼️ Flyer del Evento</label>
                            <div class="w-full">
                                <label class="w-full flex flex-col items-center px-4 py-8 bg-black text-purple-400 rounded-lg border-2 border-dashed border-gray-800 cursor-pointer hover:border-purple-500 transition">
                                    <div x-show="!imageUrl" class="flex flex-col items-center">
                                        <span class="text-2xl mb-2">📸</span>
                                        <span class="text-[10px] font-bold uppercase tracking-widest">Click para subir imagen</span>
                                    </div>
                                    <input type="file" name="flyer" class="hidden" accept="image/*" 
                                        @change="const file = $event.target.files[0]; if (file) { imageUrl = URL.createObjectURL(file) }">
                                    <template x-if="imageUrl">
                                        <div class="relative w-full">
                                            <img :src="imageUrl" class="rounded-lg max-h-60 w-full object-cover border border-purple-500">
                                            <div class="absolute bottom-2 right-2 bg-black text-[8px] px-2 py-1 rounded uppercase">Previsualización</div>
                                        </div>
                                    </template>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label for="title" class="block text-[10px] font-bold text-gray-500 uppercase mb-2">📛 Nombre del Evento</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" 
                                class="w-full bg-black border-gray-800 text-white rounded-lg focus:ring-purple-500 focus:border-purple-500 text-sm"
                                placeholder="Ej: Techno Bunker Night">
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2">🎹 Géneros</label>
                            <div class="grid grid-cols-2 gap-3 bg-black p-4 rounded-lg border border-gray-800">
                                @foreach($genres as $genre)
                                    <label class="flex items-center space-x-3 cursor-pointer">
                                        <input type="checkbox" name="genres[]" value="{{ $genre->id }}" 
                                            class="rounded border-gray-700 text-purple-600 bg-zinc-900"
                                            {{ is_array(old('genres')) && in_array($genre->id, old('genres')) ? 'checked' : '' }}>
                                        <span class="text-[10px] text-gray-400 uppercase font-bold">{{ $genre->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label for="lineup" class="block text-[10px] font-bold text-gray-500 uppercase mb-2">🎧 Line-up</label>
                            <input type="text" name="lineup" id="lineup" value="{{ old('lineup') }}" 
                                class="w-full bg-black border-gray-800 text-white rounded-lg text-sm"
                                placeholder="DJ 1, DJ 2...">
                        </div>

                        <div>
                            <label for="description" class="block text-[10px] font-bold text-gray-500 uppercase mb-2">📝 Descripción</label>
                            <textarea name="description" id="description" rows="4" 
                                class="w-full bg-black border-gray-800 text-white rounded-lg focus:ring-purple-500 focus:border-purple-500 text-sm placeholder-zinc-700"
                                placeholder="Detalles de la fiesta, dresscode, etc...">{{ old('description') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2">📅 Fecha</label>
                                <input type="date" name="date" value="{{ old('date') }}" 
                                    class="w-full bg-black border-gray-800 text-white rounded-lg text-sm">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2">🕒 Apertura</label>
                                <input type="time" name="start_time" value="{{ old('start_time') }}"
                                    class="w-full bg-black border-gray-800 text-white rounded-lg text-sm">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2">🌙 Cierre</label>
                                <input type="time" name="end_time" value="{{ old('end_time') }}"
                                    class="w-full bg-black border-gray-800 text-white rounded-lg text-sm">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2">📍 Lugar</label>
                                <input type="text" name="location_name" value="{{ old('location_name') }}"
                                    class="w-full bg-black border-gray-800 text-white rounded-lg text-sm" placeholder="Nombre del club">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2">🏘️ Barrio</label>
                                <input type="text" name="neighborhood" value="{{ old('neighborhood') }}"
                                    class="w-full bg-black border-gray-800 text-white rounded-lg text-sm" placeholder="Ej: Poblenou">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t border-gray-800 pt-6">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2">💰 Precio (€)</label>
                                <input type="number" step="0.01" name="price" value="{{ old('price', 0) }}"
                                    class="w-full bg-black border-gray-800 text-white rounded-lg text-sm">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-2">ℹ️ Info Extra</label>
                                <input type="text" name="price_info" value="{{ old('price_info') }}"
                                    class="w-full bg-black border-gray-800 text-white rounded-lg text-sm" placeholder="Ej: +1 copa">
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-800">
                            <a href="{{ route('events.index') }}" class="text-gray-500 hover:text-white text-[10px] font-bold uppercase transition">Cancelar</a>
                            <button type="submit" class="bg-purple-600 hover:bg-purple-500 text-white px-8 py-3 rounded-lg text-[10px] font-bold uppercase tracking-widest">
                                Publicar Evento
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>