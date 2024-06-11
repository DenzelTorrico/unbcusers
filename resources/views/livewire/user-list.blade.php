<div>
    @if(session()->has('message'))
        <div class="bg-green-500 text-white p-4 mb-4">
            {{ session('message') }}
        </div>
    @endif

    <button wire:click="create()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 mb-4 rounded">Crear Usuario</button>

    @if($isOpen)
        @include('livewire.create-user-form')
    @endif

    <table class="table-fixed w-full">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Apellido</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Teléfono</th>
                <th class="px-4 py-2">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td class="border px-4 py-2">{{ $user->name }}</td>
                    <td class="border px-4 py-2">{{ $user->lastname }}</td>
                    <td class="border px-4 py-2">{{ $user->email }}</td>
                    <td class="border px-4 py-2">{{ $user->phone }}</td>
                    <td class="border px-4 py-2">
                        <button wire:click="edit({{ $user->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar</button>
                        <button wire:click="delete({{ $user->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Eliminar</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
