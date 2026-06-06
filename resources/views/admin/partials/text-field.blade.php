{{--
    Reusable text / number / email / password / tel / url input.
    Usage:
        @include('admin.partials.text-field', [
            'name'        => 'name',
            'label'       => 'Full Name',
            'type'        => 'text',                    -- optional, default 'text'
            'value'       => old('name', $user->name ?? ''),
            'required'    => true,                       -- optional
            'placeholder' => 'e.g. John Doe',            -- optional
            'icon'        => 'bi-person',                -- optional bootstrap-icons class
            'suffix'      => 'kg',                        -- optional inline suffix
            'prefix'      => '₹',                        -- optional inline prefix
            'hint'        => 'Min 8 chars',               -- optional help text
            'col'         => 'col-md-6',                  -- optional wrapper class
        ])
--}}
@php
    $id        = $id        ?? $name;
    $type      = $type      ?? 'text';
    $required  = $required  ?? false;
    $value     = $value     ?? old($name);
    $col       = $col       ?? '';
    $hasIcon   = ! empty($icon);
    $hasAffix  = ! empty($prefix) || ! empty($suffix);
@endphp
<div class="admin-field {{ $col }}{{ $errors->has($name) ? ' admin-field--error' : '' }}">
    @if(! empty($label))
        <label for="{{ $id }}">
            @if($hasIcon)<i class="bi {{ $icon }} admin-field-icon"></i>@endif
            <span>{{ $label }}</span>
            @if($required)<span class="admin-required-mark" aria-label="required">*</span>@endif
        </label>
    @endif

    <div class="admin-input-wrap{{ $hasIcon ? ' admin-input-wrap--icon' : '' }}{{ $hasAffix ? ' admin-input-wrap--affix' : '' }}">
        @if($hasIcon)<i class="bi {{ $icon }} admin-input-icon"></i>@endif
        @if(! empty($prefix))<span class="admin-input-affix admin-input-affix--prefix">{{ $prefix }}</span>@endif
        <input
            type="{{ $type }}"
            id="{{ $id }}"
            name="{{ $name }}"
            value="{{ $value }}"
            placeholder="{{ $placeholder ?? '' }}"
            {{ $required ? 'required' : '' }}
            {{ $step ?? null ? "step={$step}" : '' }}
            {{ $min  ?? null ? "min={$min}"   : '' }}
            {{ $max  ?? null ? "max={$max}"   : '' }}
            @if(! empty($autocomplete)) autocomplete="{{ $autocomplete }}" @endif
            {{ $attributes ?? '' }}
        >
        @if(! empty($suffix))<span class="admin-input-affix admin-input-affix--suffix">{{ $suffix }}</span>@endif
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
