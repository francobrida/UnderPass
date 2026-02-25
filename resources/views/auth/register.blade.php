<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro | UnderPass</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) </head>
<body class="bg-black text-gray-100 min-h-screen flex items-center justify-center font-sans">

    <div class="max-w-md w-full px-6">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-black tracking-tighter text-white uppercase mb-2">
                Under<span class="text-purple-500">Pass</span>
            </h1>
            <p class="text-gray-500 text-xs uppercase tracking-widest">Crea tu pase de acceso</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="bg-gray-900 p-8 rounded-3xl border border-purple-500/20 shadow-2xl space-y-6">
            @csrf
            
            <div>
                <label class="block text-[10px] uppercase font-bold text-gray-500 mb-2">Nickname</label>
                <input type="text" name="nickname" :value="old('nickname')" required autofocus class="w-full bg-black border border-gray-800 rounded-xl p-3 text-white focus:border-purple-500 outline-none">
                <x-input-error :messages="$errors->get('nickname')" class="mt-2" />
            </div>

            <div>
                <label class="block text-[10px] uppercase font-bold text-gray-500 mb-2">Email</label>
                <input type="email" name="email" :value="old('email')" required class="w-full bg-black border border-gray-800 rounded-xl p-3 text-white focus:border-purple-500 outline-none">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div>
                <label class="block text-[10px] uppercase font-bold text-gray-500 mb-2">Password</label>
                <input type="password" name="password" required class="w-full bg-black border border-gray-800 rounded-xl p-3 text-white focus:border-purple-500 outline-none">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <label class="block text-[10px] uppercase font-bold text-gray-500 mb-2">Confirmar Password</label>
                <input type="password" name="password_confirmation" required class="w-full bg-black border border-gray-800 rounded-xl p-3 text-white focus:border-purple-500 outline-none">
            </div>

            <div class="flex items-center justify-between mt-4">
                <a class="text-s text-gray-500 hover:text-purple-400" href="{{ route('login') }}">
                    ¿Ya tienes cuenta?
                </a>

                <button type="submit" class="px-8 py-3 bg-purple-600 text-white font-black uppercase tracking-widest rounded-xl hover:bg-purple-700 transition shadow-lg shadow-purple-900/40">
                    Registrar
                </button>
            </div>
        </form>
    </div>

</body>
</html>