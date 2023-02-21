<div>
    <div class="my-12 bg-white shadow-lg rounded-lg p-6">
        <div class="mb-6">
            <x-jet-label>
                Color
            </x-jet-label>
            <div class="grid grid-cols-6 gap-6">
                @foreach ($colors as $color)
                    <label>
                        <input type="radio" class="colorProduct" name="color_id" wire:model.defer="color_id" value="{{ $color->id }}">
                        <span class="ml-2 text-gray-700 capitalize">
{{ __(ucfirst($color->name)) }}
</span>
                    </label>
                @endforeach
            </div>
            <x-jet-input-error for="color_id" id="errorColor"/>
        </div>
        <div>
            <x-jet-label>
                Cantidad
            </x-jet-label>
            <x-jet-input type="number" wire:model.defer="quantity" placeholder="Ingrese una cantidad" class="w-full quantityColor" />
            <x-jet-input-error for="quantity" id="errorQuantity" />
        </div>
        <div class="flex justify-end items-center mt-4">
        <x-jet-action-message class="mr-3" on="saved" id="agregado">
            Agregado
        </x-jet-action-message>
        <x-jet-button wire:loading.attr="disabled" wire:target="save" wire:click="save">
            Agregar
        </x-jet-button>
    </div>
    </div>
    @if($productColors->count())
    <div class="bg-white shadow-lg rounded-lg p-6">
        <table>
            <thead>
            <tr>
                <th class="px-4 py-2 w-1/3">
                    Color
                </th>
                <th class="px-4 py-2 w-1/3">
                    Cantidad
                </th>
                <th class="px-4 py-2 w-1/3">
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($productColors as $color)
                <tr wire:key="product_color-{{ $color->pivot->id }}">
                    <td class="capitalize px-4 py-2">
                        {{ __(ucfirst($colors->find($color->pivot->color_id)->name)) }}
                    </td>
                    <td class="px-4 py-2">
                        {{ $color->pivot->quantity }} unidades
                    </td>
                    <td class="px-4 py-2 flex">
                        <x-jet-secondary-button
                            class="ml-auto mr-2"
                            wire:click="edit({{ $color->pivot->id }})"
                            wire:loading.attr="disabled"
                            wire:target="edit({{ $color->pivot->id }})">
                            Actualizar
                        </x-jet-secondary-button>
                        <x-jet-danger-button
                            wire:click="$emit('deleteColor', {{ $color->pivot->id }})">
                            Eliminar
                        </x-jet-danger-button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        @endif
    </div>
    <x-jet-dialog-modal wire:model="open">
        <x-slot name="title">
            Editar colores
        </x-slot>
        <x-slot name="content">
            <div class="mb-4">
                <x-jet-label>
                    Color
                </x-jet-label>
                <select class="form-control w-full" wire:model="pivot_color_id">
                    <option value="">Seleccione un color</option>
                    @foreach ($colors as $color)
                        <option value="{{ $color->id }}">{{ __(ucfirst($color->name)) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <x-jet-label>
                    Cantidad
                </x-jet-label>
                <x-jet-input
                    class="w-full"
                    wire:model="pivot_quantity" type="number"
                    placeholder="Ingrese una cantidad" />
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('open', false)">
                Cancelar
            </x-jet-secondary-button>
            <x-jet-button wire:click="update" wire:loading.attr="disabled" wire:target="update">
                Actualizar
            </x-jet-button>
        </x-slot>
        </x-jet-dialog-modal>
</div>

