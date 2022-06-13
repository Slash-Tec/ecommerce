<input
        autocomplete="off"
        type="text"
        name="{{ $name }}"
        id="{{ $name }}"
        class="input"
        size="{{ $size ?? '10' }}"
        placeholder="{{ $placeholder ?? '' }}"
        value="{{ old($name, $value ?? '') }}"
        {{ ($required ?? false) ? 'required' : '' }}
        wire:model.debounce.500ms={{ $model }}
    >
