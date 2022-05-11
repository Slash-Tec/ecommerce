<div class="container-menu py-8 grid grid-cols-5 gap-6">
    <div class="col-span-3">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="mb-4">
                <x-jet-label value="Nombre de contacto" />
                <x-jet-input type="text"
                             wire:model.defer="contact"
                             placeholder="Introduzca el nombre de la persona que recibirá el pedido"
                             class="w-full"/>
                <x-jet-input-error for="contact" />
            </div>
            <div>
                <x-jet-label value="Teléfono de contacto" />
                <x-jet-input type="text"
                             wire:model.defer="phone"
                             placeholder="Introduzca el teléfono de contacto"
                             class="w-full"/>
                <x-jet-input-error for="phone" />
            </div>
        </div>
        <div x-data="{ envio_type: @entangle('envio_type') }">
            <p class="mt-6 mb-3 text-lg text-gray-700 font-semibold">Envíos</p>
            <label class="bg-white rounded-lg shadow px-6 py-4 flex items-center mb-4">
                <input x-model="envio_type" type="radio" name="envio_type" value="1" class="text-gray-600">
                <span class="ml-2 text-gray-700">Recojo en tienda (Calle Falsa 123)</span>
                <span class="font-semibold text-gray-700 ml-auto">Gratis</span>
            </label>
            <div class="bg-white rounded-lg shadow">
                <label class="px-6 py-4 flex items-center">
                    <input x-model="envio_type" type="radio" name="envio_type" value="2" class="text-gray-600">
                    <span class="ml-2 text-gray-700">Envío a domicilio</span>
                </label>
                <div class="px-6 pb-6 grid grid-cols-2 gap-6" :class="{ 'hidden': envio_type != 2 }">
                    <div>
                        <x-jet-label value="Departamento" />
                        <select class="form-control w-full" wire:model="department_id">
                            <option value="" disabled selected>Seleccione un departamento</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="department_id" />
                    </div>
                    <div></div>
                    <div>
                        <x-jet-label value="Ciudad" />
                        <select class="form-control w-full" wire:model="city_id">
                            <option value="" disabled selected>Seleccione una ciudad</option>
                            @foreach($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="city_id" />
                    </div>
                    <div>
                        <x-jet-label value="Distrito" />
                        <select class="form-control w-full" wire:model="district_id">
                            <option value="" disabled selected>Seleccione un distrito</option>
                            @foreach($districts as $district)
                                <option value="{{ $district->id }}">{{ $district->name }}</option>
                            @endforeach
                        </select>
                        <x-jet-input-error for="district_id" />
                    </div>
                    <div>
                        <x-jet-label value="Dirección" />
                        <x-jet-input class="w-full" wire:model="address" type="text" />
                        <x-jet-input-error for="address" />
                    </div>
                    <div class="col-span-2">
                        <x-jet-label value="Referencia" />
                        <x-jet-input class="w-full" wire:model="reference" type="text" />
                        <x-jet-input-error for="reference" />
                    </div>
                </div>
            </div>
        </div>
        <div>
            <x-jet-button
                wire:loading.attr="disabled"
                wire:target="create_order"
                class="mt-6 mb-4" wire:click="create_order">
                Continuar con la compra
            </x-jet-button>
            <hr>
            <p class="text-sm text-gray-700 mt-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Commodi, maiores,
                porro. Accusantium architecto cum excepturi necessitatibus omnis ratione, rerum sed similique veniam. Dolorum iste, omnis
                repudiandae sunt tempora totam unde!
                <a href="" class="font-semibold text-orange-500">Políticas y privacidad</a></p>
        </div>
    </div>
    <div class="col-span-2">
        <div class="bg-white rounded-lg shadow p-6">
            <ul>
                @forelse(Cart::content() as $item)
                    <li class="flex p-2 border-b border-gray-200">
                        <img class="h-15 w-20 object-cover mr-4" src="{{ $item->options->image }}" alt="">
                        <article class="flex-1">
                            <h1 class="font-bold">{{ $item->name }}</h1>
                            <div class="flex">
                                <p class="">Cant: {{ $item->qty }}</p>
                                @isset($item->options['color'])
                                    <p class="mx-2">- Color: {{ __(ucfirst($item->options['color'])) }}</p>
                                @endisset
                                @isset($item->options['size'])
                                    <p class="mx-2">{{ $item->options['size'] }}</p>
                                @endisset
                            </div>
                            <p>{{ $item->price }} &euro;</p>
                        </article>
                    </li>
                @empty
                    <li class="py-6 px-4">
                        <p class="text-center text-gray-700">
                            No tiene agregado ningún item en el carrito
                        </p>
                    </li>
                @endforelse
            </ul>
            <hr class="mt-4 mb-3">
            <div class="text-gray-700">
                <p class="flex justify-between items-center">
                    Subtotal
                    <span>{{ Cart::subtotal() }} &euro;</span>
                </p>
                <p class="flex justify-between items-center">
                    Envío
                    <span class="font-semibold">
                          @if($envio_type == 1 || $shipping_cost == 0)
                          Gratis
                          @else
                          {{ $shipping_cost }} &euro;
                    @endif
                    </span>
                </p>
                <hr class="mt-4 mb-3">
                <p class="flex justify-between items-center font-semibold">
                    <span class="text-lg">Total</span>
                    @if($envio_type == 1)
                    {{ Cart::subtotal() }} &euro;
                    @else
                    {{ Cart::subtotal() + $shipping_cost }} &euro;
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

