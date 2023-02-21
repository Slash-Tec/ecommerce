<div class="flex-1 relative">
    <form action="{{ route('search') }}" autocomplete="off" method="get">
    <x-jet-input name="name" wire:model="search" type="text" class="flex w-full"
                 placeholder="¿Estás buscando algún producto?"></x-jet-input>
    <button class="absolute top-0 right-0 w-12 h-full bg-orange-500 flex items-center justify-center rounded-r-md">
        <x-search size="35" color="white"></x-search>
    </button>
        </form>
    <div class="absolute w-full mt-1 hidden" :class="{ 'hidden' : !$wire.open }" @click.away="$wire.open = false">
        <div class="bg-white rounded-lg shadow-lg">
            <div class="px-4 py-3 space-y-1">
                @forelse ($products as $product)
                    <a href="{{ route('products.show', $product) }}" class="flex">
                        <img class="w-16 h-12 object-cover" src="{{ Storage::url($product->images->first()->url) }}" alt="">
                        <div class="ml-4 text-gray-700">
                            <p class="text-lg font-semibold leading-5">{{$product->name}}</p>
                            <p>Categoria: {{$product->subcategory->category->name}}</p>
                        </div>
                    </a>
                @empty
                    <p class="text-lg leading-5">
                        No existe ningún registro con los parámetros especificados
                    </p>
                @endforelse
            </div>
        </div>
    </div>
</div>
