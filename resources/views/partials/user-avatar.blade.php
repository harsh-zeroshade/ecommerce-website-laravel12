@php
    $sizes = ['xs' => 28, 'sm' => 32, 'md' => 38, 'lg' => 48, 'xl' => 72];
    $px = $sizes[$size] ?? 38;
    $extraClass = $class ?? '';
@endphp

<span class="user-avatar user-avatar--{{ $size }} {{ $extraClass }}" style="--avatar-size: {{ $px }}px;">
    @if($user->avatar)
        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" loading="lazy">
    @else
        <span class="user-avatar-initial" aria-hidden="true">{{ $user->initials() }}</span>
    @endif
</span>
