<section>
    <header>
        <h2 class="text-lg font-black text-white uppercase tracking-tighter italic">
            {{ __('Actualizar Contraseña') }}
        </h2>

        <p class="mt-1 text-[10px] font-bold text-zinc-500 uppercase tracking-widest">
            {{ __('Asegúrate de que tu cuenta use una contraseña larga y aleatoria para mantener la seguridad.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-8 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-2 italic">// {{ __('Contraseña Actual') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" 
                class="block w-full bg-black border-zinc-800 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition-all font-bold" 
                autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-[10px] uppercase font-bold tracking-tighter" />
        </div>

        <div>
            <label for="update_password_password" class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-2 italic">// {{ __('Nueva Contraseña') }}</label>
            <input id="update_password_password" name="password" type="password" 
                class="block w-full bg-black border-zinc-800 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition-all font-bold" 
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-[10px] uppercase font-bold tracking-tighter" />
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-2 italic">// {{ __('Confirmar Contraseña') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" 
                class="block w-full bg-black border-zinc-800 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition-all font-bold" 
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-[10px] uppercase font-bold tracking-tighter" />
        </div>

        <div class="flex items-center gap-6 pt-4 border-t border-zinc-800/50">
            <button type="submit" class="bg-white text-black hover:bg-purple-600 hover:text-white px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] transition-all duration-300 transform hover:-translate-y-0.5">
                {{ __('Cambiar Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-[10px] font-black uppercase tracking-widest text-purple-500 flex items-center gap-2"
                >
                    <span class="w-1.5 h-1.5 bg-purple-500 rounded-full animate-ping"></span>
                    {{ __('Clave Actualizada.') }}
                </p>
            @endif
        </div>
    </form>
</section>