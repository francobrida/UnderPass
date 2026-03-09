<x-app-layout>
    <div class="py-12 bg-black min-h-screen">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-900 border border-purple-900/50 overflow-hidden shadow-2xl rounded-2xl">
                <div class="p-8">
                    <h2 class="text-2xl font-black text-white uppercase tracking-tighter mb-6">
                        Editar <span class="text-purple-500">Usuario</span>
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

                    <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div x-data="{ imageUrl: '{{ $user->avatar ? asset('storage/' . $user->avatar) : null }}' }">
                            <label class="block text-xs font-bold text-purple-400 uppercase mb-2">Avatar del Usuario</label>
                            <div class="flex flex-col items-center justify-center w-full">
                                <label class="w-full flex flex-col items-center px-4 py-6 bg-gray-800 text-purple-400 rounded-xl border-2 border-dashed border-purple-900/50 cursor-pointer hover:border-purple-500 transition shadow-inner">
                                    
                                    <div x-show="!imageUrl" class="flex flex-col items-center">
                                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        <span class="text-sm font-bold uppercase tracking-widest">Subir Foto</span>
                                    </div>
                                    
                                    <input type="file" name="avatar" class="hidden" accept="image/*" 
                                        @change="const file = $event.target.files[0]; if (file) { imageUrl = URL.createObjectURL(file) }">
                                    
                                    <template x-if="imageUrl">
                                        <div class="relative">
                                            <img :src="imageUrl" class="rounded-full h-32 w-32 object-cover shadow-2xl border-2 border-purple-500">
                                            <div class="absolute -bottom-2 right-0 bg-purple-600 px-2 py-1 rounded text-[8px] text-white uppercase font-bold">Cambiar</div>
                                        </div>
                                    </template>
                                </label>
                            </div>
                        </div>

                        <div>
                            <label for="nickname" class="block text-xs font-bold text-purple-400 uppercase mb-2">Nickname</label>
                            <input type="text" name="nickname" id="nickname" value="{{ old('nickname', $user->nickname) }}" required
                                class="w-full bg-gray-800 border-gray-700 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition shadow-inner">
                        </div>

                        <div>
                            <label for="email" class="block text-xs font-bold text-purple-400 uppercase mb-2">Correo Electrónico</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                class="w-full bg-gray-800 border-gray-700 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition shadow-inner">
                        </div>

                        <div>
                            <label for="role" class="block text-xs font-bold text-purple-400 uppercase mb-2">Rol del Usuario</label>
                            <select name="role" id="role" 
                                class="w-full bg-gray-800 border-gray-700 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition shadow-inner">
                                <option value="clubber" {{ old('role', $user->role) == 'clubber' ? 'selected' : '' }}>Clubber</option>
                                <option value="organizer" {{ old('role', $user->role) == 'organizer' ? 'selected' : '' }}>Organizer</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>

                        <div>
                            <label for="points" class="block text-xs font-bold text-purple-400 uppercase mb-2">Puntos:</label>
                            <input type="number" id="points" name="points" value="{{ old('points', $user->points) }}"
                                class="w-full bg-gray-800 border-gray-700 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition shadow-inner">
                        </div>

                        <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-800">
                            <a href="{{ route('admin.index') }}" class="text-gray-500 hover:text-white text-xs font-bold uppercase transition">Cancelar</a>
                            <button type="submit" class="bg-purple-600 hover:bg-purple-500 text-white px-8 py-3 rounded-xl text-xs font-black uppercase tracking-widest transition shadow-lg shadow-purple-500/20">
                                Actualizar Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>