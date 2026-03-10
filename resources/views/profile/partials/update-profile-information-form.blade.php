<section>
    <header>
        <h2 class="text-lg font-black text-white uppercase tracking-tighter italic">
            {{ __('Información del Perfil') }}
        </h2>

        <p class="mt-1 text-[10px] font-bold text-zinc-500 uppercase tracking-widest">
            {{ __("Actualiza la información de tu cuenta y tu dirección de correo electrónico.") }}
        </p>
    </header>

    {{-- Formulario oculto para reenvío de verificación --}}
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-8 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-2 italic">// {{ __('Nombre') }}</label>
            <input id="name" name="name" type="text" 
                class="block w-full bg-black border-zinc-800 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition-all font-bold placeholder-zinc-800" 
                value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            <x-input-error class="mt-2 text-[10px] uppercase font-bold tracking-tighter" :messages="$errors->get('name')" />
        </div>

        <div>
            <label for="email" class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-2 italic">// {{ __('Email') }}</label>
            <input id="email" name="email" type="email" 
                class="block w-full bg-black border-zinc-800 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition-all font-bold placeholder-zinc-800" 
                value="{{ old('email', $user->email) }}" required autocomplete="username" />
            <x-input-error class="mt-2 text-[10px] uppercase font-bold tracking-tighter" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="mt-4 p-4 border border-amber-900/30 bg-amber-900/10 rounded-xl">
                    <p class="text-[10px] font-bold uppercase tracking-widest text-amber-500">
                        {{ __('Tu dirección de correo no ha sido verificada.') }}

                        <button form="send-verification" class="block mt-2 underline text-amber-200 hover:text-white transition">
                            {{ __('Haz clic aquí para reenviar el email de verificación.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-black text-[9px] uppercase tracking-widest text-purple-400">
                            {{ __('Se ha enviado un nuevo enlace de verificación a tu correo.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-6 pt-4 border-t border-zinc-800/50">
            <button type="submit" class="bg-white text-black hover:bg-purple-600 hover:text-white px-8 py-3 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] transition-all duration-300 transform hover:-translate-y-0.5">
                {{ __('Guardar Cambios') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-[10px] font-black uppercase tracking-widest text-purple-500 flex items-center gap-2"
                >
                    <span class="w-1.5 h-1.5 bg-purple-500 rounded-full animate-ping"></span>
                    {{ __('Actualizado.') }}
                </p>
            @endif
        </div>
    </form>
</section>