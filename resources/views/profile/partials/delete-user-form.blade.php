<section class="space-y-6">
    <header>
        <h2 class="text-lg font-black text-red-500 uppercase tracking-tighter italic">
            {{ __('Eliminar Cuenta') }}
        </h2>

        <p class="mt-1 text-[10px] font-bold text-zinc-500 uppercase tracking-widest leading-relaxed">
            {{ __('Una vez que tu cuenta sea eliminada, todos sus recursos y datos se borrarán permanentemente. Por favor, descarga cualquier información que desees conservar antes de proceder.') }}
        </p>
    </header>

    <button 
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-600/10 border border-red-600/50 text-red-500 hover:bg-red-600 hover:text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] transition-all duration-300"
    >
        {{ __('Eliminar Cuenta') }}
    </button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8 bg-zinc-900 border border-zinc-800 rounded-2xl">
            @csrf
            @method('delete')

            <h2 class="text-xl font-black text-white uppercase tracking-tighter italic">
                {{ __('¿Estás absolutamente seguro?') }}
            </h2>

            <p class="mt-3 text-[10px] font-bold text-zinc-400 uppercase tracking-widest leading-relaxed">
                {{ __('Esta acción es irreversible. Por favor, introduce tu contraseña para confirmar que deseas eliminar permanentemente tu acceso a UnderPass.') }}
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">{{ __('Contraseña') }}</label>

                <input 
                    id="password"
                    name="password"
                    type="password"
                    class="block w-full bg-black border-zinc-800 text-white rounded-xl focus:ring-red-500 focus:border-red-500 transition-all font-bold placeholder-zinc-700"
                    placeholder="{{ __('Introduce tu contraseña para confirmar') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-[10px] uppercase font-bold tracking-tighter" />
            </div>

            <div class="mt-8 flex justify-end gap-4">
                <button 
                    type="button"
                    x-on:click="$dispatch('close')"
                    class="text-[10px] font-black text-zinc-500 hover:text-white uppercase tracking-widest transition"
                >
                    {{ __('Cancelar') }}
                </button>

                <button type="submit" class="bg-red-600 hover:bg-red-500 text-white px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] transition-all shadow-lg shadow-red-500/20">
                    {{ __('Confirmar Eliminación') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>