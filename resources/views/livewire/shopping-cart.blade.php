<div class="container-menu py-8">
    <section class="bg-white rounded-lg shadow-lg p-6 text-gray-700">
        <h1 class="text-lg font-semibold mb-6">CARRITO DE COMPRAS</h1>
        @if(Cart::count())
        <table class="table-auto w-full">
            <thead>
                <tr>
                    <th></th>
                    <th>Precio</th>
                    <th>Cant</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
            @foreach(Cart::content() as $item)
                <tr>
                <td>
                    <div class="flex">
                        <img class="h-15 w-20 object-cover mr-4" src="{{ $item->options->image }}" alt="">
                    <div>
                        <p class="font-bold">{{ $item->name }}</p>
                    @if($item->options->color)
                    <span>
                        Color: {{ __(ucfirst($item->options->color)) }}
                    </span>
                    @endif
                    @if($item->options->size)
                    <span class="mx-1">-</span>
                    <span>
                        {{ __($item->options->size) }}
                    </span>
                    @endif
                    </div>
                    </div>
                </td>
                <td class="text-center">
                <span>{{ $item->price }} &euro;</span>
                    <a class="ml-6 cursor-pointer hover:text-red-600" wire:click="delete('{{ $item->rowId }}')"wire:loading.class="text-red-600 opacity-25" wire:target="delete('{{ $item->rowId }}')">
                    <i class="fas fa-trash"></i>
                    </a>
                </td>
                <td>
                    <div class="flex justify-center">@if($item->options->size)
                    @livewire('update-cart-item-size', ['rowId' => $item->rowId], key($item->rowId))
                @elseif($item->options->color)
                    @livewire('update-cart-item-color', ['rowId' => $item->rowId], key($item->rowId))
                @else
                    @livewire('update-cart-item', ['rowId' => $item->rowId], key($item->rowId))
                @endif
                </div>
                </td>
                <td class="text-center">{{ $item->price * $item->qty }} &euro;</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <a class="text-sm cursor-pointer hover:underline mt-3 inline-block" wire:click="destroy">
            <i class="fas fa-trash"></i>
            Borrar carrito de compras
        </a>
        @else
            <div class="flex flex-col items-center">
            <x-cart />
            <p class="text-lg text-gray-700 mt-4">TU CARRITO DE COMPRAS ESTÁ VACÍO</p>
            <x-button-link href="/" class="mt-4 px-16">
                Ir al inicio
            </x-button-link>
            </div>
        @endif
    </section>
    @if(Cart::count())
    <div class="bg-white rounded-lg shadow-lg px-6 py-4 mt-4">
        <div class="flex justify-between items-center">
            <div class="text-gray-700">
                <span class="font-bold text-lg">Total:</span>
                {{ Cart::subtotal() }} &euro;
            </div>
            <div>
                <x-button-link>
                    Continuar
                </x-button-link>
            </div>
        </div>
    </div>
    @endif
</div>