<x-guest-layout>
    <div class="max-w-md mx-auto">
        <header class="mb-8 text-center">
            <h2 class="text-2xl font-black text-white uppercase tracking-tighter italic">
                Recuperar <span class="text-purple-500">Acceso</span>
            </h2>
            <div class="mt-4 p-4 border border-zinc-800 bg-zinc-900/50 rounded-xl">
                <p class="text-[10px] text-zinc-400 uppercase tracking-widest leading-relaxed font-bold">
                    {{ __('Olvidaste tu contraseña? No hay problema. Solo necesitamos tu dirección de correo electrónico y te enviaremos un enlace para restablecer tu contraseña.') }}
                </p>
            </div>
        </header>

        <x-auth-session-status class="mb-6" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-[10px] font-black text-zinc-500 uppercase tracking-widest mb-2 italic">
                    // {{ __('Email') }}
                </label>
                <input id="email" 
                    class="block w-full bg-black border-zinc-800 text-white rounded-xl focus:ring-purple-500 focus:border-purple-500 transition-all font-bold placeholder-zinc-800" 
                    type="email" 
                    name="email" 
                    value="{{ old('email') }}" 
                    placeholder="tu@email.com"
                    required autofocus />
                
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-[10px] uppercase font-bold tracking-tighter" />
            </div>

            <div class="flex flex-col gap-4 items-center justify-end mt-8">
                <button type="submit" class="w-full bg-white text-black hover:bg-purple-600 hover:text-white px-8 py-4 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] transition-all duration-300 transform hover:-translate-y-1 shadow-lg shadow-purple-500/10">
                    {{ __('Send Reset Link') }}
                </button>

                <a href="{{ route('login') }}" class="text-[9px] font-black text-zinc-600 hover:text-white uppercase tracking-[0.2em] transition">
                    ← Volver al login
                </a>
            </div>
        </form>
    </div>
</x-guest-layout>