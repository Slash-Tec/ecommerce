
<div class="mt-4" wire:ignore>
    <a class="button form-control bg-red-500 p-2" href="{{ request()->url() }}">Limpiar filtros</a>
</div>
<div class="pl-2 py-4">
    <label><b>
            Producto:
        </b>
    </label>
    <x-input.text size="32"
                  name="search"
                  model="search"
                  type="text"
                  placeholder="Introduzca el nombre del producto a buscar" />
    <label class="ml-2"><b>
            Categoría:
        </b>
    </label>
    <select wire:model.lazy="category">
        <option value="all" selected disabled>Seleccionar una Categoría</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>

    <label class="mx-2"><b>
            Subcategorías:
        </b>
    </label>
    <select wire:model.lazy="subcategory">
        <option value="all" selected disabled>Seleccionar una subcategoría</option>
        @foreach($subcategories as $subcategory)
            <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
        @endforeach
    </select>
    <label class="ml-2"><b>
            Marcas:
        </b>
    </label>
    <select wire:model.lazy="brand">
        <option value="all" selected disabled>Seleccionar una marca</option>
        @foreach($brands as $brand)
            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
        @endforeach
    </select>
    <label><b>
            Estado
        </b>
    </label>
    <select wire:model="status">
        <option value="all">Cualquiera</option>
        <option value="1">Borrador</option>
        <option value="2">Publicado</option>
    </select>
</div>

<label class="ml-2"><b>
        Fechas:
    </b>
</label>

<div class="inline-block" wire:ignore>

    <x-input.date placeholder="Desde" model="from" name="from"/>

    <x-input.date placeholder="Hasta" model="to" name="to"/>
</div>
<div class="inline-block" wire:ignore>
    <button class="form-control bg-red-500 p-2" @click="flatpickr('.dateFlatpicker')[0].clear();flatpickr('.dateFlatpicker')[1].clear();" title="clear" >Limpiar</button>
</div>
<label class="ml-2"><b>
        Precio:
    </b>
</label>
<x-input.text name="minPrice" type="text" size="10" placeholder="Precio mínimo" model="minPrice"/>
<x-input.text name="maxPrice" type="text" size="10" placeholder="Precio máximo" model="maxPrice"/>
<span class="ml-2"><b>Stock: </b></span>
@foreach($quantities as $stock)
    <label for="">{{ $stock . "+" }}</label>
    <x-input.radio name="stock" class="mr-2" model="stock" value="{{ $stock }}"/>
@endforeach
<span x-data="{ open: false }" @click.away="open = false">
                        <input type="radio" name="stock"  @click="open = !open" >Otro</button>
    <span x-show="open">
                    <input type="text" size="4" class="mr-2" wire:model="stock" value="{{ $stock }}">
                        </span>
                        </span>
<label class="ml-4"><b>
        Tallas:
    </b>
</label>
<x-input.text size="20"
              name="searchSize"
              model="searchSize"
              type="text"
              placeholder="Introduzca la talla a buscar" />
<div class="mt-2">
    <label class="ml-2"><b>
            Colores:
        </b>
    </label>
    <div class="inline-block"  wire:ignore>
        @foreach($colorsf as $color_id => $color_name)
            <label for="color_{{ $color_id }}">{{ __(ucfirst($color_name)) }}</label>
            <x-input.checkbox id="color_{{ $color_id }}" name="selectedColors[]" model="selectedColors" value="{{ $color_id }}"/>
        @endforeach
    </div>
</div>
