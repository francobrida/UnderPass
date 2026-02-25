<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | UnderPass</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-black text-gray-100 min-h-screen flex items-center justify-center font-sans">

    <div class="max-w-md w-full px-6">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-black tracking-tighter text-white uppercase mb-2">
                Under<span class="text-purple-500">Pass</span>
            </h1>
            <p class="text-gray-500 text-[10px] uppercase tracking-[0.3em]">Acceso al Backstage</p>
        </div>

        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="bg-gray-900 p-8 rounded-3xl border border-purple-500/20 shadow-2xl space-y-6">
            @csrf
            
            <div>
                <label class="block text-[10px] uppercase font-bold text-gray-500 mb-2">Email del Clubber</label>
                <input type="email" name="email" :value="old('email')" required autofocus class="w-full bg-black border border-gray-800 rounded-xl p-3 text-white focus:border-purple-500 outline-none transition-all">
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500 text-xs" />
            </div>

            <div>
                <div class="flex justify-between items-center mb-2">
                    <label class="block text-[10px] uppercase font-bold text-gray-500">Contraseña</label>
                    @if (Route::has('password.request'))
                        <a class="text-[10px] uppercase text-purple-500 hover:text-purple-400 font-bold" href="{{ route('password.request') }}">
                            ¿Olvidaste el acceso?
                        </a>
                    @endif
                </div>
                <input type="password" name="password" required class="w-full bg-black border border-gray-800 rounded-xl p-3 text-white focus:border-purple-500 outline-none transition-all">
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500 text-xs" />
            </div>

            <div class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 bg-black border-gray-800 rounded text-purple-600 focus:ring-purple-500 focus:ring-offset-black">
                <label for="remember_me" class="ms-2 text-[10px] uppercase font-bold text-gray-500 cursor-pointer">Mantener sesión abierta</label>
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-4 bg-purple-600 text-white font-black uppercase tracking-widest rounded-xl hover:bg-purple-700 transition-all shadow-lg shadow-purple-900/40 active:scale-95">
                    Entrar al Club
                </button>
            </div>

            <p class="text-center text-[13px] text-gray-600 uppercase font-bold">
                ¿Aún no tienes pase? 
                <a href="{{ route('register') }}" class="text-purple-500 hover:underline">Regístrate aquí</a>
            </p>
        </form>
    </div>

</body>
</html>