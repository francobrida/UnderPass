<x-app-layout>
    <div class="py-12 bg-black min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 border border-purple-900/50 overflow-hidden shadow-2xl rounded-2xl">
                <div class="p-8">
                    <h2 class="text-2xl font-black text-white uppercase tracking-tighter mb-6">
                        Nuevo <span class="text-purple-500">Evento</span>
                    </h2>

                    <form action="{{ route('events.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <label for="title" class="block text-xs font-bold text-purple-400 uppercase mb-2">Nombre del Evento</label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" 
                                class="w-full bg-gray-800 border-gray-700 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition shadow-inner"
                                placeholder="Ej: Techno Bunker Night">
                            @error('title') <p class="text-red-500 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="lineup" class="block text-xs font-bold text-purple-400 uppercase mb-2">Line-up (Artistas)</label>
                            <input type="text" name="lineup" id="lineup" value="{{ old('lineup') }}" 
                                class="w-full bg-gray-800 border-gray-700 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition shadow-inner"
                                placeholder="DJ 1, DJ 2, Especial Guest...">
                            @error('lineup') <p class="text-red-500 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-xs font-bold text-purple-400 uppercase mb-2">Descripción de la Experiencia</label>
                            <textarea name="description" id="description" rows="3" 
                                class="w-full bg-gray-800 border-gray-700 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition shadow-inner"
                                placeholder="Cuéntale al mundo de que va">{{ old('description') }}</textarea>
                            @error('description') <p class="text-red-500 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label for="date" class="block text-xs font-bold text-purple-400 uppercase mb-2">Fecha</label>
                                <input type="date" 
                                    name="date" 
                                    id="date" 
                                    value="{{ old('date') }}"
                                    min="{{ date('Y-m-d') }}" 
                                    class="w-full bg-gray-800 border-gray-700 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition shadow-inner">
                                @error('date') <p class="text-red-500 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="start_time" class="block text-xs font-bold text-purple-400 uppercase mb-2">Apertura</label>
                                <input type="time" name="start_time" id="start_time" value="{{ old('start_time') }}"
                                    class="w-full bg-gray-800 border-gray-700 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition shadow-inner">
                                @error('start_time') <p class="text-red-500 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="end_time" class="block text-xs font-bold text-purple-400 uppercase mb-2">Cierre</label>
                                <input type="time" name="end_time" id="end_time" value="{{ old('end_time') }}"
                                    class="w-full bg-gray-800 border-gray-700 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition shadow-inner">
                                @error('end_time') <p class="text-red-500 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="location_name" class="block text-xs font-bold text-purple-400 uppercase mb-2">Dónde?</label>
                                <input type="text" name="location_name" id="location_name" value="{{ old('location_name') }}"
                                    class="w-full bg-gray-800 border-gray-700 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition shadow-inner"
                                    placeholder="Ej: Garage de Pepe">
                                @error('location_name') <p class="text-red-500 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="neighborhood" class="block text-xs font-bold text-purple-400 uppercase mb-2">Barrio / Zona</label>
                                <input type="text" name="neighborhood" id="neighborhood" value="{{ old('neighborhood') }}"
                                    class="w-full bg-gray-800 border-gray-700 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition shadow-inner"
                                    placeholder="Ej: Poble-sec">
                                @error('neighborhood') <p class="text-red-500 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="price" class="block text-xs font-bold text-purple-400 uppercase mb-2">Precio Entrada (€)</label>
                            <input type="number" step="0.01" name="price" id="price" value="{{ old('price', 0) }}"
                                class="w-full bg-gray-800 border-gray-700 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition shadow-inner">
                            @error('price') <p class="text-red-500 text-[10px] mt-1 font-bold uppercase">{{ $message }}</p> @enderror
                        </div>

                        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-800">
                            <a href="{{ route('events.index') }}" class="text-gray-500 hover:text-white text-xs font-bold uppercase transition">Cancelar</a>
                            <button type="submit" class="bg-purple-600 hover:bg-purple-500 text-white px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition shadow-lg shadow-purple-500/20">
                                Publicar Flyer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>