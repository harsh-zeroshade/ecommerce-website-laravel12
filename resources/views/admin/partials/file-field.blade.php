{{--
    Reusable file-upload field with drag-and-drop + live preview.
    Usage:
        @include('admin.partials.file-field', [
            'name'        => 'image',
            'label'       => 'Primary Product Image',
            'accept'      => 'image/*',                       -- optional
            'multiple'    => false,                           -- optional
            'preview'     => $product->image ?? null,         -- optional existing image path
            'previewWidth'=> 120, 'previewHeight' => 90,     -- optional preview size
            'hint'        => 'Recommended 1200×1500px, max 5MB',
            'icon'        => 'bi-cloud-arrow-up',
        ])
--}}
@php
    $id        = $id        ?? $name;
    $accept    = $accept    ?? 'image/*';
    $multiple  = $multiple  ?? false;
    $hint      = $hint      ?? null;
    $icon      = $icon      ?? 'bi-cloud-arrow-up';
@endphp
<div class="admin-field admin-field--file{{ $errors->has($name) ? ' admin-field--error' : '' }}">
    @if(! empty($label))
        <label for="{{ $id }}">
            <i class="bi {{ $icon }} admin-field-icon"></i>
            <span>{{ $label }}</span>
        </label>
    @endif

    <label for="{{ $id }}" class="admin-file-drop" data-file-drop>
        <input
            type="file"
            id="{{ $id }}"
            name="{{ $name }}{{ $multiple ? '[]' : '' }}"
            accept="{{ $accept }}"
            {{ $multiple ? 'multiple' : '' }}
            {{ $attributes ?? '' }}
            data-file-input
        >
        <div class="admin-file-drop-inner">
            <div class="admin-file-drop-icon"><i class="bi {{ $icon }}"></i></div>
            <div class="admin-file-drop-text">
                <strong>Click to upload</strong>
                <span>or drag & drop {{ $multiple ? 'files' : 'a file' }} here</span>
            </div>
        </div>
    </label>

    <div class="admin-file-preview" data-file-preview @if(empty($preview)) hidden @endif>
        @if(! empty($preview))
            <img src="{{ asset('storage/' . $preview) }}" alt="Current image">
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
