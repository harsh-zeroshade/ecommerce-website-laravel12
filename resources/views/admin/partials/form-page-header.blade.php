{{--
    Form page header (eyebrow + title + description + optional back button).
    Usage:
        @include('admin.partials.form-page-header', [
            'eyebrow' => 'Inventory',
            'title'   => 'Create Product',
            'desc'    => 'Add a new product to your catalog.',     -- optional
            'icon'    => 'bi-plus-square',                          -- optional
            'backUrl' => route('admin.products.index'),             -- optional
            'backLabel'=> 'Back to products',                       -- optional
        ])
--}}
<div class="admin-form-page-header">
    <div class="admin-form-page-header-text">
        @if(! empty($icon))
            <div class="admin-form-page-header-icon"><i class="bi {{ $icon }}"></i></div>
        @endif
        <div>
            @if(! empty($eyebrow))<span class="eyebrow">{{ $eyebrow }}</span>@endif
            <h1>{{ $title }}</h1>
            @if(! empty($desc))<p>{{ $desc }}</p>@endif
            {{ $slot ?? '' }}
        </div>
    </div>
    @if(! empty($backUrl))
        <a href="{{ $backUrl }}" class="admin-btn admin-btn-ghost">
            <i class="bi bi-arrow-left"></i>
            <span>{{ $backLabel ?? 'Back' }}</span>
        </a>
    @endif
</div>
