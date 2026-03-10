<nav x-data="{ open: false }" class="bg-black border-b border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('events.index') }}" class="text-xl font-black uppercase italic tracking-tighter text-white">
                        Under<span class="text-purple-500">Pass</span>
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if(auth()->check() && auth()->user()->role->value === 'admin')
                        <x-nav-link :href="route('admin.index')" :active="request()->routeIs('admin.index')" class="text-xs uppercase font-bold tracking-widest">
                            Admin
                        </x-nav-link>
                    @endif
                    
                    <x-nav-link :href="route('events.index')" :active="request()->routeIs('events.index')" class="text-xs uppercase font-bold tracking-widest">
                        Eventos
                    </x-nav-link>
                    
                    <x-nav-link :href="route('events.my')" :active="request()->routeIs('events.my')" class="text-xs uppercase font-bold tracking-widest">
                        Mis Eventos
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-xs font-bold uppercase tracking-widest text-gray-400 hover:text-purple-500 transition">
                            <div>{{ Auth::user()->nickname }}</div>
                            <div class="ms-1">👇</div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="text-xs uppercase font-bold">
                            👤 Mi Perfil
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    class="text-xs uppercase font-bold text-red-500"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                🚪 Salir
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="text-gray-400 p-2 text-xl">
                    <span x-show="!open">🍔</span>
                    <span x-show="open">❌</span>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-zinc-900 border-t border-gray-800">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('events.index')" :active="request()->routeIs('events.index')" class="text-xs uppercase font-bold">
                🏠 Eventos
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('events.my')" :active="request()->routeIs('events.my')" class="text-xs uppercase font-bold">
                🎫 Mis Eventos
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-800">
            <div class="px-4 mb-3">
                <div class="font-bold text-sm text-white uppercase">{{ Auth::user()->nickname }}</div>
                <div class="font-medium text-[10px] text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="text-xs uppercase font-bold">
                    👤 Mi Perfil
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            class="text-xs uppercase font-bold text-red-500"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        🚪 Salir
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>