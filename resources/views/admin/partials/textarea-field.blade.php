{{--
    Reusable textarea.
    Usage:
        @include('admin.partials.textarea-field', [
            'name'        => 'description',
            'label'       => 'Description',
            'value'       => old('description', $product->description ?? ''),
            'rows'        => 5,                          -- optional, default 5
            'required'    => true,                       -- optional
            'placeholder' => '...',                       -- optional
            'hint'        => '...',                       -- optional
            'icon'        => 'bi-card-text',              -- optional
        ])
--}}
@php
    $id        = $id        ?? $name;
    $rows      = $rows      ?? 5;
    $required  = $required  ?? false;
    $value     = $value     ?? old($name);
    $hasIcon   = ! empty($icon);
@endphp
<div class="admin-field admin-field--textarea{{ $errors->has($name) ? ' admin-field--error' : '' }}">
    @if(! empty($label))
        <label for="{{ $id }}">
            @if($hasIcon)<i class="bi {{ $icon }} admin-field-icon"></i>@endif
            <span>{{ $label }}</span>
            @if($required)<span class="admin-required-mark" aria-label="required">*</span>@endif
        </label>
    @endif

    <div class="admin-input-wrap admin-input-wrap--textarea{{ $hasIcon ? ' admin-input-wrap--icon' : '' }}">
        @if($hasIcon)<i class="bi {{ $icon }} admin-input-icon admin-input-icon--textarea"></i>@endif
        <textarea
            id="{{ $id }}"
            name="{{ $name }}"
            rows="{{ $rows }}"
            placeholder="{{ $placeholder ?? '' }}"
            {{ $required ? 'required' : '' }}
            {{ $attributes ?? '' }}
        >{{ $value }}</textarea>
        @if(! empty($counter))
            <div class="admin-textarea-counter"><span data-counter-for="{{ $id }}">0</span> / {{ $counter }}</div>
        @endif
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
