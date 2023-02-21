@props(['categories'])


<select wire:model.lazy="{{ $model ?? ''}}">
    <option value="all" selected disabled>Selecciona una categoría</option>
    @foreach($categories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
    @endforeach
</select>
