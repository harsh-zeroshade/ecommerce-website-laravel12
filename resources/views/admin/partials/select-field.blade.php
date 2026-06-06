{{--
    Reusable select.
    Usage:
        @include('admin.partials.select-field', [
            'name'     => 'category_id',
            'label'    => 'Category',
            'options'  => $categories->pluck('name', 'id'),
            'value'    => old('category_id', $product->category_id ?? null),
            'placeholder' => 'Select Category',  -- optional
            'required' => true,                  -- optional
            'icon'     => 'bi-grid-3x3-gap',    -- optional
            'hint'     => '...',                  -- optional
        ])
--}}
@php
    $id        = $id        ?? $name;
    $required  = $required  ?? false;
    $hasIcon   = ! empty($icon);
@endphp
<div class="admin-field{{ $errors->has($name) ? ' admin-field--error' : '' }}">
    @if(! empty($label))
        <label for="{{ $id }}">
            @if($hasIcon)<i class="bi {{ $icon }} admin-field-icon"></i>@endif
            <span>{{ $label }}</span>
            @if($required)<span class="admin-required-mark" aria-label="required">*</span>@endif
        </label>
    @endif

    <div class="admin-input-wrap admin-input-wrap--select{{ $hasIcon ? ' admin-input-wrap--icon' : '' }}">
        @if($hasIcon)<i class="bi {{ $icon }} admin-input-icon"></i>@endif
        <select
            id="{{ $id }}"
            name="{{ $name }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes ?? '' }}
        >
            @if(! empty($placeholder))
                <option value="">{{ $placeholder }}</option>
            @endif
            @foreach($options as $key => $label)
                <option value="{{ $key }}" {{ (string) old($name, $value ?? '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        <i class="bi bi-chevron-down admin-select-chevron"></i>
    </div>

    @if(! empty($hint))
        <div class="admin-field-hint">{{ $hint }}</div>
    @endif

    @error($name)
        <div class="admin-field-error">
            <i class="bi bi-exclamation-circle-fill"></i>
            <span>{{ $message }}</span>
        </div>
    @elseerror
    @enderror
</div>
