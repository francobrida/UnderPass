<x-app-layout>
    <div class="py-12 bg-black min-h-screen">
        <div class="max-w-2xl mx-auto px-6 lg:px-8">
            <div class="bg-zinc-900 border border-zinc-800 overflow-hidden shadow-2xl rounded-2xl">
                <div class="p-8">
                    <header class="mb-8">
                        <h2 class="text-3xl font-black text-white uppercase tracking-tighter italic">
                            Editar <span class="text-purple-500">Usuario</span>
                        </h2>
                        <p class="text-[10px] text-zinc-500 uppercase tracking-[0.2em] font-bold mt-1">
                            ID: {{ $user->id }} — Modificando privilegios de acceso.
                        </p>
                    </header>

                    @if ($errors->any())
                        <div class="bg-red-500/10 border border-red-500/50 text-red-500 p-4 rounded-xl mb-8">
                            <ul class="list-disc list-inside text-[10px] font-bold uppercase tracking-wider">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <div x-data="{ imageUrl: '{{ $user->avatar ? asset('storage/' . $user->avatar) : null }}' }">
                            <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-3 italic">// Foto de Perfil</label>
                            <div class="flex items-center justify-center w-full">
                                <label class="w-full flex flex-col items-center px-4 py-8 bg-black text-purple-500 rounded-2xl border-2 border-dashed border-zinc-800 cursor-pointer hover:border-purple-500/50 transition-all group">
                                    
                                    <div x-show="!imageUrl" class="flex flex-col items-center">
                                        <svg class="w-8 h-8 mb-2 opacity-50 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        <span class="text-[10px] font-black uppercase tracking-widest">Subir Nueva Foto</span>
                                    </div>
                                    
                                    <input type="file" name="avatar" class="hidden" accept="image/*" 
                                        @change="const file = $event.target.files[0]; if (file) { imageUrl = URL.createObjectURL(file) }">
                                    
                                    <template x-if="imageUrl">
                                        <div class="relative">
                                            <img :src="imageUrl" class="rounded-full h-28 w-28 object-cover border-2 border-purple-500 p-1">
                                            <div class="absolute -bottom-1 -right-1 bg-purple-600 px-2 py-1 rounded text-[8px] text-white uppercase font-black">Cambiar</div>
                                        </div>
                                    </template>
                                </label>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label for="nickname" class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-2 italic">// Nickname</label>
                                <input type="text" name="nickname" id="nickname" value="{{ old('nickname', $user->nickname) }}" required
                                    class="w-full bg-black border-zinc-800 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition-all font-bold placeholder-zinc-700">
                            </div>

                            <div>
                                <label for="email" class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-2 italic">// Correo Electrónico</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                    class="w-full bg-black border-zinc-800 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition-all font-bold placeholder-zinc-700">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 bg-black/50 border border-zinc-800 rounded-2xl">
                            <div>
                                <label for="role" class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-2 italic">// Rol Actual</label>
                                <select name="role" id="role" 
                                    class="w-full bg-zinc-900 border-zinc-800 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition-all font-bold text-xs">
                                    <option value="clubber" {{ old('role', $user->role) == 'clubber' ? 'selected' : '' }}>Clubber</option>
                                    <option value="organizer" {{ old('role', $user->role) == 'organizer' ? 'selected' : '' }}>Organizer</option>
                                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </div>

                            <div>
                                <label for="points" class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-2 italic">// Créditos / Points</label>
                                <input type="number" id="points" name="points" value="{{ old('points', $user->points) }}"
                                    class="w-full bg-zinc-900 border-zinc-800 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition-all font-bold text-xs">
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-6 pt-6 border-t border-zinc-800">
                            <a href="{{ route('admin.index') }}" class="text-[10px] font-black text-zinc-600 hover:text-white uppercase tracking-widest transition">
                                Cancelar
                            </a>
                            <button type="submit" class="bg-purple-600 hover:bg-purple-500 text-white px-10 py-4 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] transition-all duration-300 transform hover:-translate-y-1 shadow-lg shadow-purple-500/20">
                                Actualizar Usuario
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>