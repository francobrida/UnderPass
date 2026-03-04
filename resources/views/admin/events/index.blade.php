<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Admin | UnderPass</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-black text-gray-200 p-6">

    <div class="max-w-6xl mx-auto">
        
        <div class="flex justify-between items-center mb-10 border-b border-gray-800 pb-6">
            <div>
                <h1 class="text-3xl font-black text-white uppercase italic">
                    Under<span class="text-purple-500">Pass</span> <span class="text-sm font-light text-gray-500 ml-2">Admin</span>
                </h1>
            </div>
            <a href="{{ route('events.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-full text-xs font-bold tracking-widest transition">
                + CREAR EVENTO
            </a>
        </div>

        <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden shadow-2xl">
            <table class="w-full text-left">
                <thead class="bg-gray-800 text-gray-400 text-xs uppercase">
                    <tr>
                        <th class="p-4">Evento</th>
                        <th class="p-4">Barrio</th>
                        <th class="p-4">Fecha</th>
                        <th class="p-4">Precio</th>
                        <th class="p-4">Verificado</th>
                        <th class="p-4 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @foreach($events as $event)
                    <tr class="hover:bg-gray-800/50 transition">
                        <td class="p-4 font-bold">{{ $event->title }}</td>
                        <td class="p-4 text-sm">{{ $event->neighborhood }}</td>
                        <td class="p-4 text-sm text-gray-400">
                            {{ \Carbon\Carbon::parse($event->date)->format('d/m/Y') }}
                        </td>
                        <td class="p-4 text-sm font-mono">
                            {{ $event->price > 0 ? $event->price . '€' : 'FREE' }}
                        </td>

                        <td class="p-4 font-bold">{{ $event->is_verified ? 'Si' : 'No'}}</td>
                        
                        <td class="p-4">
                            <div class="flex items-center justify-center space-x-3">
                                
                                <a href="{{ route('events.show', $event) }}" class="text-blue-400 hover:underline text-xs uppercase font-bold">Ver</a>
                                
                                <a href="{{ route('events.edit', $event) }}" class="text-blue-500 hover:underline text-xs uppercase font-bold">Editar</a>

                                <form action="{{ route('admin.destroy', $event) }}" method="POST" class="flex items-center" onsubmit="return confirm('¿Eliminar definitivamente?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline text-xs uppercase font-bold leading-none p-0 m-0 border-none bg-transparent">
                                        Eliminar
                                    </button>
                                </form>
                                
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-8">
            <a href="/" class="text-gray-500 hover:text-purple-400 text-xs uppercase tracking-widest transition">
                ← Volver a la Agenda
            </a>
        </div>
    </div>

</body>
</html>