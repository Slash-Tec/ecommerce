<input
    autocomplete="off"
    type="checkbox"
    name="{{ $name }}"
    id="{{ $id }}"
    class="mr-2"
    size="{{ $size ?? '10' }}"
    placeholder="{{ $placeholder ?? '' }}"
    value="{{ old($name, $value ?? '') }}"
    {{ ($required ?? false) ? 'required' : '' }}
    wire:model={{ $model }}
>
