@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<section class="account-page" style="padding:6rem 0 3rem 0;">
    <div class="container">
        <!-- Header -->
        <div class="account-header reveal" style="margin-bottom:2.5rem;">
            <span class="eyebrow" style="color:var(--text-muted);">My Account</span>
            <h1 class="display-md">Profile Settings</h1>
            <p class="text-muted" style="max-width:650px; margin-top:.75rem; font-size:1.05rem;">
                Update your personal information and manage your account.
            </p>
        </div>

        <!-- Main Form Card -->
        <div style="
            background:var(--surface);
            border:1px solid var(--border);
            border-radius:var(--radius-lg);
            overflow:hidden;
            box-shadow:var(--shadow-md);
        ">
            <!-- Form Body -->
            <div style="padding:2.5rem;">
                @if(session('success'))
                    <div style="
                        background:rgba(75, 192, 116, 0.1);
                        border:1px solid rgba(75, 192, 116, 0.3);
                        color:#2d6a3a;
                        padding:1rem 1.25rem;
                        border-radius:var(--radius-sm);
                        margin-bottom:1.5rem;
                        display:flex;
                        align-items:center;
                        gap:.75rem;
                    ">
                        <i class="bi bi-check-circle" style="font-size:1.3rem;"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('account.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Profile Image Section -->
                    <div style="
                        background:linear-gradient(135deg, var(--cream) 0%, var(--bg-warm) 100%);
                        border:1px solid var(--border);
                        border-radius:var(--radius);
                        padding:2rem;
                        margin-bottom:2.5rem;
                        display:flex;
                        align-items:center;
                        gap:2rem;
                    ">
                        <div style="
                            width:120px;
                            height:120px;
                            border-radius:var(--radius);
                            overflow:hidden;
                            background:var(--surface);
                            display:flex;
                            align-items:center;
                            justify-content:center;
                            border:2px solid var(--border);
                            flex-shrink:0;
                        ">
                            @if($user->avatar)
                                <img
                                    src="{{ asset('storage/' . $user->avatar) }}"
                                    alt="Profile"
                                    style="width:100%; height:100%; object-fit:cover;"
                                >
                            @else
                                <i class="bi bi-person" style="font-size:3rem; color:var(--text-muted);"></i>
                            @endif
                        </div>

                        <div style="flex:1;">
                            <label style="
                                display:block;
                                font-weight:600;
                                font-size:0.9rem;
                                text-transform:uppercase;
                                letter-spacing:0.08em;
                                color:var(--text-muted);
                                margin-bottom:0.75rem;
                            ">Profile Photo</label>
                            <input type="file" id="avatar" name="avatar" accept="image/*" style="
                                display:block;
                                margin-bottom:0.5rem;
                                font-size:0.9rem;
                            ">
                            @error('avatar')<div style="color:#d97706; font-size:0.9rem; margin-top:0.25rem;">{{ $message }}</div>@enderror
                            <p class="text-muted" style="font-size:0.9rem;">JPG, PNG up to 5MB</p>
                        </div>
                    </div>

                    <!-- Form Grid -->
                    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(300px, 1fr)); gap:1.75rem; margin-bottom:2rem;">
                        <!-- Full Name -->
                        <div>
                            <label for="name" style="
                                display:block;
                                font-weight:600;
                                font-size:0.9rem;
                                text-transform:uppercase;
                                letter-spacing:0.08em;
                                color:var(--text-muted);
                                margin-bottom:0.65rem;
                            ">Full Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required style="
                                width:100%;
                                padding:0.75rem 1rem;
                                border:1px solid var(--border);
                                border-radius:var(--radius-sm);
                                font-family:inherit;
                                font-size:1rem;
                                background:var(--surface);
                                color:var(--text);
                                transition:all var(--transition-fast);
                            ">
                            @error('name')<div style="color:#d97706; font-size:0.85rem; margin-top:0.35rem;">{{ $message }}</div>@enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" style="
                                display:block;
                                font-weight:600;
                                font-size:0.9rem;
                                text-transform:uppercase;
                                letter-spacing:0.08em;
                                color:var(--text-muted);
                                margin-bottom:0.65rem;
                            ">Phone Number</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" style="
                                width:100%;
                                padding:0.75rem 1rem;
                                border:1px solid var(--border);
                                border-radius:var(--radius-sm);
                                font-family:inherit;
                                font-size:1rem;
                                background:var(--surface);
                                color:var(--text);
                                transition:all var(--transition-fast);
                            ">
                            @error('phone')<div style="color:#d97706; font-size:0.85rem; margin-top:0.35rem;">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Address Section -->
                    <div style="margin-bottom:2rem;">
                        <label for="address" style="
                            display:block;
                            font-weight:600;
                            font-size:0.9rem;
                            text-transform:uppercase;
                            letter-spacing:0.08em;
                            color:var(--text-muted);
                            margin-bottom:0.65rem;
                        ">Street Address</label>
                        <input type="text" id="address" name="address" value="{{ old('address', $user->address) }}" style="
                            width:100%;
                            padding:0.75rem 1rem;
                            border:1px solid var(--border);
                            border-radius:var(--radius-sm);
                            font-family:inherit;
                            font-size:1rem;
                            background:var(--surface);
                            color:var(--text);
                            transition:all var(--transition-fast);
                        ">
                        @error('address')<div style="color:#d97706; font-size:0.85rem; margin-top:0.35rem;">{{ $message }}</div>@enderror
                    </div>

                    <!-- City, State, Zip Grid -->
                    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(280px, 1fr)); gap:1.75rem; margin-bottom:2rem;">
                        <div>
                            <label for="city" style="
                                display:block;
                                font-weight:600;
                                font-size:0.9rem;
                                text-transform:uppercase;
                                letter-spacing:0.08em;
                                color:var(--text-muted);
                                margin-bottom:0.65rem;
                            ">City</label>
                            <input type="text" id="city" name="city" value="{{ old('city', $user->city) }}" style="
                                width:100%;
                                padding:0.75rem 1rem;
                                border:1px solid var(--border);
                                border-radius:var(--radius-sm);
                                font-family:inherit;
                                font-size:1rem;
                                background:var(--surface);
                                color:var(--text);
                                transition:all var(--transition-fast);
                            ">
                            @error('city')<div style="color:#d97706; font-size:0.85rem; margin-top:0.35rem;">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label for="state" style="
                                display:block;
                                font-weight:600;
                                font-size:0.9rem;
                                text-transform:uppercase;
                                letter-spacing:0.08em;
                                color:var(--text-muted);
                                margin-bottom:0.65rem;
                            ">State / Province</label>
                            <input type="text" id="state" name="state" value="{{ old('state', $user->state) }}" style="
                                width:100%;
                                padding:0.75rem 1rem;
                                border:1px solid var(--border);
                                border-radius:var(--radius-sm);
                                font-family:inherit;
                                font-size:1rem;
                                background:var(--surface);
                                color:var(--text);
                                transition:all var(--transition-fast);
                            ">
                            @error('state')<div style="color:#d97706; font-size:0.85rem; margin-top:0.35rem;">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label for="zipcode" style="
                                display:block;
                                font-weight:600;
                                font-size:0.9rem;
                                text-transform:uppercase;
                                letter-spacing:0.08em;
                                color:var(--text-muted);
                                margin-bottom:0.65rem;
                            ">Postal Code</label>
                            <input type="text" id="zipcode" name="zipcode" value="{{ old('zipcode', $user->zipcode) }}" style="
                                width:100%;
                                padding:0.75rem 1rem;
                                border:1px solid var(--border);
                                border-radius:var(--radius-sm);
                                font-family:inherit;
                                font-size:1rem;
                                background:var(--surface);
                                color:var(--text);
                                transition:all var(--transition-fast);
                            ">
                            @error('zipcode')<div style="color:#d97706; font-size:0.85rem; margin-top:0.35rem;">{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label for="country" style="
                                display:block;
                                font-weight:600;
                                font-size:0.9rem;
                                text-transform:uppercase;
                                letter-spacing:0.08em;
                                color:var(--text-muted);
                                margin-bottom:0.65rem;
                            ">Country</label>
                            <input type="text" id="country" name="country" value="{{ old('country', $user->country) }}" style="
                                width:100%;
                                padding:0.75rem 1rem;
                                border:1px solid var(--border);
                                border-radius:var(--radius-sm);
                                font-family:inherit;
                                font-size:1rem;
                                background:var(--surface);
                                color:var(--text);
                                transition:all var(--transition-fast);
                            ">
                            @error('country')<div style="color:#d97706; font-size:0.85rem; margin-top:0.35rem;">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <!-- Divider -->
                    <div style="height:1px; background:var(--border); margin:2.5rem 0;"></div>

                    <!-- Password Section -->
                    <div style="margin-bottom:2rem;">
                        <h3 style="
                            font-size:1.1rem;
                            font-weight:600;
                            margin-bottom:1.5rem;
                            color:var(--text);
                            font-family:var(--font-display);
                        ">Change Password</h3>

                        <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(300px, 1fr)); gap:1.75rem;">
                            <div>
                                <label for="password" style="
                                    display:block;
                                    font-weight:600;
                                    font-size:0.9rem;
                                    text-transform:uppercase;
                                    letter-spacing:0.08em;
                                    color:var(--text-muted);
                                    margin-bottom:0.65rem;
                                ">New Password (optional)</label>
                                <input type="password" id="password" name="password" autocomplete="new-password" style="
                                    width:100%;
                                    padding:0.75rem 1rem;
                                    border:1px solid var(--border);
                                    border-radius:var(--radius-sm);
                                    font-family:inherit;
                                    font-size:1rem;
                                    background:var(--surface);
                                    color:var(--text);
                                    transition:all var(--transition-fast);
                                ">
                                @error('password')<div style="color:#d97706; font-size:0.85rem; margin-top:0.35rem;">{{ $message }}</div>@enderror
                            </div>

                            <div>
                                <label for="password_confirmation" style="
                                    display:block;
                                    font-weight:600;
                                    font-size:0.9rem;
                                    text-transform:uppercase;
                                    letter-spacing:0.08em;
                                    color:var(--text-muted);
                                    margin-bottom:0.65rem;
                                ">Confirm Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password" style="
                                    width:100%;
                                    padding:0.75rem 1rem;
                                    border:1px solid var(--border);
                                    border-radius:var(--radius-sm);
                                    font-family:inherit;
                                    font-size:1rem;
                                    background:var(--surface);
                                    color:var(--text);
                                    transition:all var(--transition-fast);
                                ">
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div style="display:flex; gap:1rem; justify-content:flex-start; margin-top:2.5rem;">
                        <button type="submit" style="
                            padding:0.875rem 2rem;
                            background:var(--text);
                            color:var(--surface);
                            border:none;
                            border-radius:var(--radius-sm);
                            font-weight:600;
                            font-size:0.9rem;
                            cursor:pointer;
                            text-transform:uppercase;
                            letter-spacing:0.08em;
                            transition:all var(--transition-fast);
                        ">Save Changes</button>
                        <a href="{{ route('account.orders.index') }}" style="
                            padding:0.875rem 2rem;
                            background:transparent;
                            color:var(--text);
                            border:1px solid var(--border);
                            border-radius:var(--radius-sm);
                            font-weight:600;
                            font-size:0.9rem;
                            cursor:pointer;
                            text-transform:uppercase;
                            letter-spacing:0.08em;
                            transition:all var(--transition-fast);
                            text-decoration:none;
                            display:inline-flex;
                            align-items:center;
                        ">Back to Orders</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
    input[type="text"],
    input[type="password"],
    input[type="file"] {
        transition: all var(--transition-fast);
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
        outline: none;
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(44, 40, 37, 0.1);
    }

    input[type="file"]::file-selector-button {
        background: var(--accent);
        color: var(--surface);
        border: none;
        padding: 0.5rem 1rem;
        border-radius: var(--radius-sm);
        cursor: pointer;
        font-weight: 600;
        margin-right: 1rem;
    }

    button:hover,
    a:hover {
        opacity: 0.8;
    }

    [data-theme="dark"] input[type="text"],
    [data-theme="dark"] input[type="password"] {
        background: rgba(255, 255, 255, 0.08);
        border-color: rgba(255, 255, 255, 0.1);
        color: rgba(255, 255, 255, 0.95);
    }
</style>
@endsection
