<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-lg shadow-lg px-12 py-8 mb-6 flex items-center">
        <div class="relative">
            <div class="{{ ($order->status >= 2 && $order->status != 5) ? 'bg-blue-400' : 'bg-gray-400' }} rounded-full h-12 w-
12 flex items-center justify-center">
                <i class="fas fa-check text-white"></i>
            </div>
            <div class="absolute -left-1.5 mt-0.5">
                <p>Recibido</p>
            </div>
        </div>
        <div class="{{ ($order->status >= 3 && $order->status != 5) ? 'bg-blue-400' : 'bg-gray-400' }} h-1 flex-1 mx-2"></div>
        <div class="relative">
            <div class="{{ ($order->status >= 3 && $order->status != 5) ? 'bg-blue-400' : 'bg-gray-400' }} rounded-full h-12 w-
12 flex items-center justify-center">
                <i class="fas fa-truck text-white"></i>
            </div>
            <div class="absolute -left-1 mt-0.5">
                <p>Enviado</p>
            </div>
        </div>
        <div class="{{ ($order->status >= 4 && $order->status != 5) ? 'bg-blue-400' : 'bg-gray-400' }} h-1 flex-1 mx-2"></div>
        <div class="relative">
            <div class="{{ ($order->status >= 4 && $order->status != 5) ? 'bg-blue-400' : 'bg-gray-400' }} rounded-full h-12 w-
12 flex items-center justify-center">
                <i class="fas fa-check text-white"></i>
            </div>
            <div class="absolute -left-3 mt-0.5">
                <p>Entregado</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-lg px-6 py-4 mb-6">
        <div>
            <p class="text-lg font-semibold uppercase">Envío</p>
            @if($order->envio_type == 1)
                <p class="text-sm">Los productos deben ser recogidos en tienda</p>
                <p class="text-sm">Calle Falsa 123</p>
            @else
                <p class="text-sm">Los productos serán enviados a:</p>
                <p class="text-sm">{{ $envio->address }}</p>
                <p>{{ $envio->department }} - {{ $envio->city }} - {{ $envio->district }}</p>
            @endif
        </div>
        <p class="text-gray-700 uppercase"><span class="font-semibold">Número de Orden:</span> {{ $order->id }}</p>
        <form wire:submit.prevent="update">
            <div class="flex space-x-3 mt-2">
                <x-jet-label>
                    <input wire:model="status" type="radio" name="status" value="2" class="mr-2">
                    RECIBIDO
                </x-jet-label>
                <x-jet-label>
                    <input wire:model="status" type="radio" name="status" value="3" class="mr-2">
                    ENVIADO
                </x-jet-label>
                <x-jet-label>
                    <input wire:model="status" type="radio" name="status" value="4" class="mr-2">
                    ENTREGADO
                </x-jet-label>
                <x-jet-label>
                    <input wire:model="status" type="radio" name="status" value="5" class="mr-2">
                    ANULADO
                </x-jet-label>
            </div>
            <div class="flex mt-2">
                <x-jet-button class="ml-auto">
                    Actualizar
                </x-jet-button>
            </div>
        </form>
    </div>
</div>
