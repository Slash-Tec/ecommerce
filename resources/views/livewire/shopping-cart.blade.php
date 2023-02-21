<div class="container-menu py-8">
    <x-table-responsive>
        <div class="px-6 py-4 bg-white">
            <h1 class="text-lg font-semibold text-gray-700">CARRITO DE COMPRAS</h1>
        </div>
        @if(Cart::count())
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nombre
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Precio
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Cantidad
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Total
                    </th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @foreach(Cart::content() as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-full object-cover object-center"
                                         src="{{ $item->options->image }}"
                                         alt="">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $item->name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        @if ($item->options->color)
                                            <span>
Color: {{ __(ucfirst($item->options->color)) }}
</span>
                                        @endif
                                        @if ($item->options->size)
                                            <span class="mx-1">-</span>
                                            <span>
{{ $item->options->size }}
</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">
                                <span>{{ $item->price }} &euro;</span>
                                <a class="ml-6 cursor-pointer hover:text-red-600"
                                   wire:click="delete('{{ $item->rowId }}')"
                                   wire:loading.class="text-red-600 opacity-25"
                                   wire:target="delete('{{ $item->rowId }}')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">
                                @if ($item->options->size)
                                    @livewire('update-cart-item-size', ['rowId' => $item->rowId], key($item->rowId))
                                @elseif($item->options->color)
                                    @livewire('update-cart-item-color', ['rowId' => $item->rowId], key($item->rowId))
                                @else
                                    @livewire('update-cart-item', ['rowId' => $item->rowId], key($item->rowId))
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="text-sm text-gray-500">
                                {{ $item->price * $item->qty }} &euro;
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <div class="px-6 py-4">
                <a class="text-sm cursor-pointer hover:underline mt-3 inline-block"
                   wire:click="destroy">
                    <i class="fas fa-trash"></i>
                    Borrar carrito de compras
                </a>
            </div>
        @else
            <div class="flex flex-col items-center">
                <x-cart />
                <p class="text-lg text-gray-700 mt-4">TU CARRITO DE COMPRAS ESTÁ VACÍO</p>
                <x-button-link href="/" class="mt-4 px-16">
                    Ir al inicio
                </x-button-link>
            </div>
            @endif
            </x-table-responsive>
    @if(Cart::count())
        <div class="bg-white rounded-lg shadow-lg px-6 py-4 mt-4">
            <div class="flex justify-between items-center">
                <div class="text-gray-700">
                    <span class="font-bold text-lg">Total:</span>
                    {{ Cart::subtotal() }} &euro;
                </div>
                <div>
                    <x-button-link href="{{ route('orders.create') }}">
                        Continuar
                    </x-button-link>
                </div>
            </div>
        </div>
    @endif
</div>
