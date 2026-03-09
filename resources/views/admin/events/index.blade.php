<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin | UnderPass</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-gray-200 p-6 font-sans">

    <div class="max-w-6xl mx-auto">
        
        <div class="flex justify-between items-center mb-10 border-b border-gray-800 pb-6">
            <div>
                <h1 class="text-3xl font-black text-white uppercase italic tracking-tighter">
                    Under<span class="text-purple-500 text-glow">Pass</span> <span class="text-sm font-light text-gray-500 ml-2 italic">Admin Control</span>
                </h1>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('users.create') }}" class="bg-gray-800 hover:bg-gray-700 text-white px-5 py-2 rounded-lg text-xs font-bold tracking-widest transition border border-gray-700">
                    + CREAR USUARIO
                </a>
                <a href="{{ route('events.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-5 py-2 rounded-lg text-xs font-bold tracking-widest transition shadow-lg shadow-purple-500/20">
                    + CREAR EVENTO
                </a>
            </div>
        </div>

        <div class="mb-12">
            <h2 class="text-lg font-bold text-white uppercase tracking-widest mb-4 flex items-center">
                <span class="bg-purple-500 w-1 h-6 mr-3"></span>
                Usuarios <span class="text-purple-500 ml-2">Registrados</span>
            </h2>
            <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden shadow-2xl">
                <table class="w-full text-left">
                    <thead class="bg-gray-800/50 text-gray-400 text-[10px] uppercase tracking-wider">
                        <tr>
                            <th class="p-4">Usuario</th>
                            <th class="p-4">E-mail</th>
                            <th class="p-4">Rol</th>
                            <th class="p-4 text-center">Puntos</th>
                            <th class="p-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @foreach($users as $user)
                        <tr class="hover:bg-gray-800/30 transition text-sm">
                            <td class="p-4 font-bold text-white">{{ $user->nickname }}</td>
                            <td class="p-4 text-gray-400">{{ $user->email }}</td>
                            <td class="p-4">
                                <span class="text-[10px] font-bold uppercase px-2 py-0.5 border border-gray-700 rounded text-gray-300">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="p-4 text-center font-mono text-purple-400">{{ $user->points }}</td>
                            <td class="p-4">
                                <div class="flex items-center justify-center space-x-4">
                                    <a href="{{ route('users.show', $user) }}" class="text-gray-400 hover:text-white font-bold text-[10px] uppercase tracking-tighter">Ver</a>
                                    <a href="{{ route('users.edit', $user) }}" class="text-blue-400 hover:text-blue-300 font-bold text-[10px] uppercase tracking-tighter">Editar</a>
                                    <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Borrar usuario?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-500/70 hover:text-red-500 font-bold text-[10px] uppercase tracking-tighter">Borrar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mb-12">
            <h2 class="text-lg font-bold text-white uppercase tracking-widest mb-4 flex items-center">
                <span class="bg-purple-500 w-1 h-6 mr-3"></span>
                Eventos <span class="text-purple-500 ml-2">UnderPass</span>
            </h2>
            <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden shadow-2xl">
                <table class="w-full text-left">
                    <thead class="bg-gray-800/50 text-gray-400 text-[10px] uppercase tracking-wider">
                        <tr>
                            <th class="p-4">Evento</th>
                            <th class="p-4">Barrio</th>
                            <th class="p-4 text-center">Fecha</th>
                            <th class="p-4 text-center">Status</th>
                            <th class="p-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @foreach($events as $event)
                        <tr class="hover:bg-gray-800/30 transition text-sm">
                            <td class="p-4 font-bold text-white">{{ $event->title }}</td>
                            <td class="p-4 text-gray-400">{{ $event->neighborhood }}</td>
                            <td class="p-4 text-center font-mono text-xs text-gray-500">
                                {{ \Carbon\Carbon::parse($event->date)->format('d.m.y') }}
                            </td>
                            <td class="p-4 text-center">
                                @if($event->is_verified)
                                    <span class="text-green-500 text-[10px] font-black uppercase tracking-widest">Verificado</span>
                                @else
                                    <span class="text-orange-500 text-[10px] font-black uppercase italic tracking-widest">Pendiente</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <div class="flex items-center justify-center space-x-4">
                                    <a href="{{ route('events.show', $event) }}" class="text-gray-400 hover:text-white font-bold text-[10px] uppercase tracking-tighter">Ver</a>
                                    <a href="{{ route('events.edit', $event) }}" class="text-blue-400 hover:text-blue-300 font-bold text-[10px] uppercase tracking-tighter">Editar</a>
                                    <form action="{{ route('admin.destroy', $event) }}" method="POST" onsubmit="return confirm('¿Eliminar evento?')">
                                        @csrf @method('DELETE')
                                        <button class="text-red-500/70 hover:text-red-500 font-bold text-[10px] uppercase tracking-tighter">Borrar</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8 border-t border-gray-800 pt-6">
            <a href="/" class="text-gray-600 hover:text-purple-400 text-xs uppercase tracking-[0.2em] transition inline-flex items-center">
                <span>← Volver a la Agenda pública</span>
            </a>
        </div>
    </div>

</body>
</html>