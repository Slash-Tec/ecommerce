<input
    autocomplete="off"
    type="radio"
    name="{{ $name }}"
    id="{{ $name }}"
    class="mr-2"
    size="{{ $size ?? '10' }}"
    placeholder="{{ $placeholder ?? '' }}"
    value="{{ old($name, $value ?? '') }}"
    {{ ($required ?? false) ? 'required' : '' }}
    wire:model={{ $model }}
>
