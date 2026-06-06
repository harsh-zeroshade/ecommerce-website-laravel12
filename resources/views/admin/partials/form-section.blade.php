@php
    $id = $id ?? 'section-' . \Illuminate\Support\Str::slug($title);
@endphp
<div class="admin-form-section" id="{{ $id }}">
    <div class="admin-form-section-head">
        @if(! empty($icon))
            <div class="admin-form-section-icon"><i class="bi {{ $icon }}"></i></div>
        @endif
        <div class="admin-form-section-text">
            <h4>{{ $title }}</h4>
            @if(! empty($desc))<p>{{ $desc }}</p>@endif
        </div>
    </div>
    <div class="admin-form-section-body">
        {!! $body ?? '' !!}
    </div>
</div>
