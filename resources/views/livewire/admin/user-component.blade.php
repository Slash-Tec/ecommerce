<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
            Usuarios
        </h2>
    </x-slot>
    <div class="container-menu py-12">
        <x-table-responsive>
            <div class="px-6 py-4">
                <x-jet-input wire:model="search" type="text" class="w-full" placeholder="Escriba algo para filtrar" />
            </div>
            @if (count($users))
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            ID
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Nombre
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Rol
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Editar</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($users as $user)
                        <tr wire:key="{{ $user->email }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-gray-900">
                                    {{$user->id}}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{$user->name}}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    {{$user->email}}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="text-sm text-gray-900">
                                    @if ($user->roles->count())
                                        Admin
                                    @else
                                        No tiene rol
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <label>
                                    <input {{ $user->roles->count() ? 'checked' : '' }} value="1" type="radio" name="{{$user->email}}"
                                           wire:change="assignRole({{$user->id}}, $event.target.value)">
                                    Si
                                </label>
                                <label class="ml-2">
                                    <input {{ $user->roles->count() ? '' : 'checked' }} value="0" type="radio" name="{{$user->email}}"
                                           wire:change="assignRole({{$user->id}}, $event.target.value)">
                                    No
                                </label>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="px-6 py-4">
                    No hay ningún registro coincidente
                </div>
            @endif
            @if ($users->hasPages())
                <div class="px-6 py-4">
                    {{$users->links()}}
                </div>
            @endif
        </x-table-responsive>
    </div>
</div>
