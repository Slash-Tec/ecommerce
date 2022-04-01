<x-app-layout>
    <div class="grid grid-cols-5 gap-6 container-menu py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="bg-white rounded-lg shadow-lg px-12 py-8 mb-6 flex items-center">
                <div class="relative">
                    <div class="{{ ($order->status >= 2 && $order->status != 5) ? 'bg-blue-400' : 'bg-gray-400' }} rounded-full h-12 w-12 flex items-center justify-center">
                        <i class="fas fa-check text-white"></i>
                    </div>
                    <div class="absolute -left-1.5 mt-0.5">
                        <p>Recibido</p>
                    </div>
                </div>
                <div class="{{ ($order->status >= 3 && $order->status != 5) ? 'bg-blue-400' : 'bg-gray-400' }} h-1 flex-1 mx-2"></div>
                <div class="relative">
                    <div class="{{ ($order->status >= 3 && $order->status != 5) ? 'bg-blue-400' : 'bg-gray-400' }} rounded-full h-12 w-12 flex items-center justify-center">
                        <i class="fas fa-truck text-white"></i>
                    </div>
                    <div class="absolute -left-1 mt-0.5">
                        <p>Enviado</p>
                    </div>
                </div>
                <div class="{{ ($order->status >= 4 && $order->status != 5) ? 'bg-blue-400' : 'bg-gray-400' }} h-1 flex-1 mx-2"></div>
                <div class="relative">
                    <div class="{{ ($order->status >= 4 && $order->status != 5) ? 'bg-blue-400' : 'bg-gray-400' }} rounded-full h-12 w-12 flex items-center justify-center">
                        <i class="fas fa-check text-white"></i>
                    </div>
                    <div class="absolute -left-3 mt-0.5">
                        <p>Entregado</p>
                    </div>
                </div>
            </div>
        <div class="bg-white rounded-lg shadow-lg px-6 py-4 mb-6 flex items-center">
            <p class="text-gray-700 uppercase"><span class="font-semibold">Número de Orden:</span> {{ $order->id }}</p>
            @if ($order->status == 1)
                <x-button-link class="ml-auto" href="{{route('orders.payment', $order)}}">
                    Ir a pagar
                </x-button-link>
            @endif
        </div>
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-lg font-semibold uppercase">Envío</p>
                    @if($order->envio_type == 1)
                        <p class="text-sm">Los productos deben ser recogidos en tienda</p>
                        <p class="text-sm">Calle Falsa 123</p>
                    @else
                        <p class="text-sm">Los productos serán enviados a:</p>
                        <p class="text-sm">{{ $order->address }}</p>
                        <p>{{ $order->department->name }} - {{ $order->city->name }} - {{ $order->district->name }}</p>
                    @endif
                </div>
                <div>
                    <p class="text-lg font-semibold uppercase">Datos de contacto</p>
                    <p class="text-sm">Persona que recibirá el producto: {{ $order->contact }}</p>
                    <p class="text-sm">Teléfono de contacto: {{ $order->phone }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow-lg p-6 text-gray-700">
            <p class="text-xl font-semibold mb-4">Resumen</p>
            <table class="table-auto w-full">
            <thead>
                <tr>
                    <th></th>
                    <th>Precio</th>
                    <th>Cant</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach($items as $item)
                    <tr>
                        <td>
                        <div class="flex">
                            <img class="h-15 w-20 object-cover mr-4" src="{{ $item->options->image }}" alt="">
                            <article>
                                <h1 class="font-bold">{{ $item->name }}</h1>
                            <div class="flex text-xs">
                            @isset($item->options->color)
                                Color: {{ __(ucfirst($item->options->color)) }}
                            @endisset
                            @isset($item->options->size)
                                {{ $item->options->size }}
                            @endisset
                            </div>
                            </article>
                        </div>
                        </td>
                        <td class="text-center">
                            {{ $item->price }} &euro;
                        </td>
                        <td class="text-center">
                            {{ $item->qty }}
                        </td>
                        <td class="text-center">
                            {{ $item->price * $item->qty }} &euro;
                        </td>
                    </tr>
                @endforeach
            </tbody>
            </table>
        </div>
        </div>
        <div class="col-span-2">
        <div class="bg-white rounded-lg shadow-lg px-6 pt-6">
        <div class="flex justify-between items-center mb-4">
        <img class="h-8" src="{{ asset('img/MC_VI_DI_2-1.jpg') }}" alt="">
        <div class="text-gray-700">
            <p class="text-sm font-semibold">
                Subtotal: {{ $order->total - $order->shipping_cost }} &euro;
            </p>
            <p class="text-sm font-semibold">
                Envío: {{ $order->shipping_cost }} &euro;
            </p>
            <p class="text-lg font-semibold uppercase">
                Pago: {{ $order->total }} &euro;
            </p>
            </div>
            </div>
            <div id="paypal-button-container"></div>
        </div>
        </div>
</div>
@push('scripts')
<script src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id') }}&currency=EUR"></script>
<script>
    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: "{{ $order->total }}"
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(orderData) {
                Livewire.emit('payOrder');
            });
        }
    }).render('#paypal-button-container');
</script>
@endpush
</x-app-layout>