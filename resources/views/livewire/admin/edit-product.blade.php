<div>
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <h1 class="font-semibold text-xl text-gray-800 leading-tight">
                    Productos
                </h1>
                <x-jet-danger-button wire:click="$emit('deleteProduct')">
                    Eliminar
                </x-jet-danger-button>
            </div>
        </div>
    </header>
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-gray-700">
    <h1 class="text-3xl text-center font-semibold mb-8">Complete los datos para crear un producto</h1>
    <div class="mb-4" wire:ignore>
    <form action="{{ route('admin.products.files', $product) }}"
          method="POST"
          class="dropzone"
          id="my-awesome-dropzone"></form>
</div>
    @if ($product->images->count())
        <section class="bg-white shadow-xl rounded-lg">
            <h1 class="text-2xl text-center font-semibold mb-2">Imagenes del producto</h1>
            <ul class="flex flex-wrap">
                @foreach ($product->images as $image)
                    <li class="relative" wire:key="image-{{ $image->id }}">
                        <img class="w-32 h-20 object-cover" src="{{ Storage::url($image->url) }}" alt="">
                        <x-jet-danger-button class="absolute right-2 top-2 w-6 h-4"
                                             wire:click="deleteImage({{ $image->id }})" wire:loading.attr="disabled"
                                             wire:target="deleteImage({{ $image->id }})">
                            x
                        </x-jet-danger-button>
                    </li>
                @endforeach
            </ul>
        </section>
    @endif
    @livewire('admin.status-product', ['product' => $product], key('status-product-' . $product->id))
    <div class="bg-white shadow-xl rounded-lg p-6">
    <div class="grid grid-cols-2 gap-6 mb-4">
        <div>
            <x-jet-label value="Categorías" />
            <select name="category" class="w-full form-control" wire:model="category_id">
                <option value="" selected disabled>Seleccione una categoría</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
            <x-jet-input-error for="category_id" />
        </div>
        <div>
            <x-jet-label value="Subcategorías" />
            <select name="subcategory" class="w-full form-control" wire:model="product.subcategory_id">
                <option value="" selected disabled>Seleccione una subcategoría</option>
                @foreach($subcategories as $subcategory)
                    <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                @endforeach
            </select>
            <x-jet-input-error for="product.subcategory_id" />
        </div>
    </div>
    <div class="mb-4">
        <div class="mb-4">
            <x-jet-label value="Nombre" />
            <x-jet-input type="text"
                         class="w-full name"
                         wire:model="product.name"
                         placeholder="Ingrese el nombre del producto" />
            <x-jet-input-error for="product.name" id="product" />
        </div>
    </div>
    <div class="mb-4">
        <x-jet-label value="Slug" />
        <x-jet-input type="text" id="slug"
                     disabled
                     wire:model="product.slug"
                     class="w-full bg-gray-200"
                     placeholder="Ingrese el slug del producto" />
        <x-jet-input-error for="product.slug" class="slug" />
    </div>
    <div class="mb-4">
        <div wire:ignore>
            <x-jet-label value="Descripción" />
            <textarea class="w-full form-control ck description" rows="4"
                      wire:model="product.description"
                      name="description"
                      x-data
                      x-init="ClassicEditor.create($refs.miEditor)
.then(function(editor){
editor.model.document.on('change:data', () => {
@this.set('product.description', editor.getData())
})
})
.catch( error => {
console.error( error );
} );"
                      x-ref="miEditor">
</textarea>
        </div>
        <x-jet-input-error for="product.description" class="description" />
    </div>
    <div class="grid grid-cols-2 gap-6 mb-4">
        <div class="mb-4">
            <x-jet-label value="Marca" />
            <select class="form-control w-full" name="brand" wire:model="product.brand_id">
                <option value="" selected disabled>Seleccione una marca</option>
                @foreach ($brands as $brand)
                    <option value="{{$brand->id}}">{{$brand->name}}</option>
                @endforeach
            </select>
            <x-jet-input-error for="product.brand_id" />
        </div>
        <div>
            <x-jet-label value="Precio" />
            <x-jet-input name="price"
                wire:model="product.price"
                type="number"
                class="w-full"
                step=".01" />
            <x-jet-input-error for="product.price" class="priceError" />
        </div>
    </div>
    @if ($this->subcategory && !$this->subcategory->color && !$this->subcategory->size)
        <div>
            <x-jet-label value="Cantidad" />
            <x-jet-input id="quantity"
                wire:model="product.quantity"
                type="number"
                class="w-full quantity"
                name="quantity"/>
            <x-jet-input-error for="product.quantity" class="quantityError" />
        </div>
    @endif
        <div class="flex justify-end items-center mt-4">
            <x-jet-action-message class="mr-3" on="saved" id="actualizado">
                Actualizado
            </x-jet-action-message>
        <x-jet-button
            wire:loading.attr="disabled"
            wire:target="save"
            wire:click="save"
            class="ml-auto">
            Actualizar producto
        </x-jet-button>
    </div>
    </div>
    @if($this->subcategory)
        @if($this->subcategory->size)
            @livewire('admin.size-product', ['product' => $product], key('size-product-' . $product->id))
        @elseif($this->subcategory->color)
            @livewire('admin.color-product', ['product' => $product], key('color-product-' . $product->id))
        @endif
    @endif
</div>


@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () =>{
            Dropzone.options.myAwesomeDropzone = {
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                dictDefaultMessage: "Mueva una imagen al recuadro",
                acceptedFiles: 'image/*',
                paramName: "file", // The name that will be used to transfer the file
                maxFilesize: 2, // MB
                complete: function(file) {
                    this.removeFile(file);
                },
                queuecomplete: function() {
                    Livewire.emit('refreshProduct');
                }
            };
        });

        Livewire.on('deleteSize', sizeId => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('admin.size-product', 'delete', sizeId);
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                }
            });
        });
        Livewire.on('errorSize', mensaje => {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: mensaje,
            }) /* */
        });

        Livewire.on('deleteColor', pivot => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('admin.color-product', 'delete', pivot);
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                }
            });
        });
        Livewire.on('deleteProduct', () => {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                timer: 20000,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emitTo('admin.edit-product', 'delete');
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                }
            });
        });
    </script>
@endpush
</div>
