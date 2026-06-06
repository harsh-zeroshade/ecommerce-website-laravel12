{{--
    Reusable toggle switch (replaces native checkboxes for a modern look).
    Usage:
        @include('admin.partials.toggle-field', [
            'name'     => 'is_active',
            'label'    => 'Active (visible to customers)',
            'checked'  => old('is_active', $category->is_active ?? true),
            'icon'     => 'bi-eye',         -- optional
            'hint'     => '...',            -- optional
        ])
--}}
@php
    $id      = $id      ?? $name;
    $checked = $checked ?? old($name);
@endphp
<label class="admin-toggle{{ ! empty($checked) && $checked !== '0' && $checked !== false ? ' is-on' : '' }}" for="{{ $id }}">
    <input
        type="checkbox"
        id="{{ $id }}"
        name="{{ $name }}"
        value="1"
        {{ ! empty($checked) && $checked !== '0' && $checked !== false ? 'checked' : '' }}
        {{ $attributes ?? '' }}
    >
    <span class="admin-toggle-track">
        <span class="admin-toggle-thumb"></span>
    </span>
    <span class="admin-toggle-label">
        @if(! empty($icon))<i class="bi {{ $icon }}"></i>@endif
        <span>
            {{ $label ?? '' }}
            @if(! empty($hint))<small class="admin-toggle-hint">{{ $hint }}</small>@endif
        </span>
    </span>
</label>
