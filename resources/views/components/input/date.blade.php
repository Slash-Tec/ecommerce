@error($name)
<p class="form-error" role="alert">{{ $message }}</p>
@enderror
    <input
        type="text" placeholder="{{ $placeholder ?? '' }}" class="dateFlatpicker" wire:model="{{ $model }}" name="{{ $name }}" id="{{ $name }}" data-date-format="d/m/Y"
    >

