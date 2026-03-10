<x-app-layout>
    <div class="py-12 bg-black min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <header class="px-4 sm:px-0 mb-10">
                <h2 class="text-3xl font-black text-white uppercase tracking-tighter italic">
                    Configuración de <span class="text-purple-500">Perfil</span>
                </h2>
                <p class="text-[10px] text-zinc-500 uppercase tracking-[0.2em] font-bold mt-1">
                    Backstage // Gestión de identidad y seguridad de la cuenta.
                </p>
            </header>

            <div class="p-6 sm:p-10 bg-zinc-900 border border-zinc-800 shadow-2xl sm:rounded-2xl transition-all duration-300 hover:border-zinc-700">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-6 sm:p-10 bg-zinc-900 border border-zinc-800 shadow-2xl sm:rounded-2xl transition-all duration-300 hover:border-zinc-700">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-6 sm:p-10 bg-black border border-red-900/30 shadow-2xl sm:rounded-2xl group">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>