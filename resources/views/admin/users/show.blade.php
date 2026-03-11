<x-app-layout>
    <div class="py-12 bg-black min-h-screen">
        <div class="max-w-2xl mx-auto px-6 lg:px-8">
            <div class="bg-zinc-900 border border-zinc-800 overflow-hidden shadow-2xl rounded-2xl">
                <div class="p-8">
                    <header class="mb-8 flex justify-between items-start">
                        <div>
                            <h2 class="text-3xl font-black text-white uppercase tracking-tighter italic">
                                Perfil de <span class="text-purple-500">Usuario</span>
                            </h2>
                        </div>
                        <a href="{{ route('admin.index') }}" class="text-[10px] bg-zinc-800 hover:bg-zinc-700 text-zinc-400 py-2 px-4 rounded-full transition-all font-black uppercase tracking-widest">
                            Volver
                        </a>
                    </header>

                    <div class="space-y-8">
                        <div>
                            <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-3 italic">// Foto de Perfil</label>
                            <div class="flex items-center justify-center w-full">
                                <div class="w-full flex flex-col items-center px-4 py-8 bg-black rounded-2xl border border-zinc-800">
                                    <div class="relative">
                                        @if($user->avatar)
                                            <img src="{{ asset('storage/' . $user->avatar) }}" class="rounded-full h-28 w-28 object-cover border-2 border-purple-500 p-1 shadow-[0_0_20px_rgba(168,85,247,0.2)]">
                                        @else
                                            <div class="rounded-full h-28 w-28 flex items-center justify-center bg-zinc-900 border-2 border-zinc-800">
                                                <svg class="w-12 h-12 text-zinc-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div>
                                <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-2 italic">// Nickname</label>
                                <div class="w-full bg-black border border-zinc-800 text-white px-4 py-3 rounded-xl font-bold tracking-tight">
                                    {{ $user->nickname }}
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-2 italic">// Correo Electrónico</label>
                                <div class="w-full bg-black border border-zinc-800 text-zinc-300 px-4 py-3 rounded-xl font-bold">
                                    {{ $user->email }}
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 bg-black/50 border border-zinc-800 rounded-2xl">
                            <div>
                                <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-2 italic">// Rol </label>
                                <div class="inline-flex items-center px-3 py-1 bg-purple-500/10 border border-purple-500/50 rounded-lg">
                                    <span class="text-purple-500 text-xs font-black uppercase tracking-tighter">{{ $user->role->value ?? $user->role }}</span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-2 italic">// Créditos / Points</label>
                                <div class="text-white text-xl font-black italic">
                                    {{ number_format($user->points) }} <span class="text-purple-500 not-italic text-sm">Puntos</span>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-zinc-800/50 flex justify-between items-center text-[9px] font-bold uppercase tracking-widest text-zinc-600 italic">
                            <span>Miembro desde: {{ $user->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>