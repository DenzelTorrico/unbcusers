<!-- resources/views/livewire/user-crud.blade.php -->

<div>
    @if($isOpen)
    @include('livewire.create-user-form')
    @endif
    <button wire:click="create()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">Crear Nuevo Usuario</button>
    @if(session()->has('message'))
    <div class="p-3 bg-green-300 text-green-800 rounded shadow-sm">
        {{ session('message') }}
    </div>
    @endif
    <div class="my-3">
        <div class="p-3 text-green-800 rounded">
            <h2>Filtrar por activos e inactivos</h2>
            <button onclick="location.reload()" wire:click="showActive" wire:loading.attr="disabled" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Activos</button>
            <button wire:click="showInactive" wire:loading.attr="disabled" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Inactivos</button>
        </div>


    </div>
    <table class="table-fixed w-full">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2">No.</th>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Phone</th>
                <th class="px-4 py-2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td class="border px-4 py-2">{{ $user->id }}</td>
                <td class="border px-4 py-2">{{ $user->name }}</td>
                <td class="border px-4 py-2">{{ $user->email }}</td>
                <td class="border px-4 py-2">{{ $user->phone }}</td>
                <td class="border px-4 py-2">
                    @if ($showActive)
                    <button wire:click="edit({{ $user->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Editar</button>
                    <button wire:click="delete({{ $user->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Borrar</button>
                    @else
                    <button wire:click="activate({{ $user->id }})" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Activar</button>
                    @endif
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4 flex">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Cerrar sesión</button>
        </form>
    </div>
</div>