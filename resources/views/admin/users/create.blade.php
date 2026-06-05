@extends('layouts.admin')

@section('title', 'Add User')

@section('content')
<div class="admin-page-header">
    <div>
        <span class="eyebrow">User Management</span>
        <h1>Add New User</h1>
        <p style="margin-top:0.5rem; color:var(--text-muted); font-size:0.95rem;">
            Create a new user account with custom permissions.
        </p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="admin-btn admin-btn-outline">
        <i class="bi bi-arrow-left" style="margin-right:0.35rem;"></i> Back
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-header" style="padding:1.5rem; background:linear-gradient(135deg, var(--cream) 0%, var(--bg-warm) 100%); border-bottom:1px solid var(--border);">
        <h3 style="font-size:1rem; font-weight:600; color:var(--text);">User Details</h3>
    </div>
    <div class="admin-card-body">
        <form method="POST" action="{{ route('admin.users.store') }}" style="padding:0 1.5rem;">
            @csrf

            <!-- Personal Information Section -->
            <h4 style="font-size:0.9rem; font-weight:600; text-transform:uppercase; letter-spacing:0.08em; color:var(--text-muted); margin:0 0 1.5rem 0; ">Personal Information</h4>

            <div class="admin-form-grid">
                <div class="admin-field">
                    <label for="name">Full Name <span style="color:#d97706;">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')<span style="color:#d97706; font-size:0.85rem;">{{ $message }}</span>@enderror
                </div>
                <div class="admin-field">
                    <label for="email">Email <span style="color:#d97706;">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')<span style="color:#d97706; font-size:0.85rem;">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="admin-form-grid">
                <div class="admin-field">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}">
                    @error('phone')<span style="color:#d97706; font-size:0.85rem;">{{ $message }}</span>@enderror
                </div>
                <div class="admin-field">
                    <label for="role">Role <span style="color:#d97706;">*</span></label>
                    <select id="role" name="role" required>
                        <option value="">Select a role...</option>
                        <option value="customer" {{ old('role') === 'customer' ? 'selected' : '' }}>Customer</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')<span style="color:#d97706; font-size:0.85rem;">{{ $message }}</span>@enderror
                </div>
            </div>

            <hr style="border:none; border-top:1px solid var(--border); margin:2rem 0;">

            <!-- Password Section -->
            <h4 style="font-size:0.9rem; font-weight:600; text-transform:uppercase; letter-spacing:0.08em; color:var(--text-muted); margin:0 0 1.5rem 0;">Set Password</h4>

            <div class="admin-form-grid">
                <div class="admin-field">
                    <label for="password">Password <span style="color:#d97706;">*</span></label>
                    <input type="password" id="password" name="password" required>
                    <small style="color:var(--text-muted); margin-top:0.35rem; display:block;">Minimum 8 characters</small>
                    @error('password')<span style="color:#d97706; font-size:0.85rem;">{{ $message }}</span>@enderror
                </div>
                <div class="admin-field">
                    <label for="password_confirmation">Confirm Password <span style="color:#d97706;">*</span></label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                </div>
            </div>

            <hr style="border:none; border-top:1px solid var(--border); margin:2rem 0;">

            <!-- Status -->
            <div class="admin-field">
                <label style="display:flex; align-items:center; gap:0.75rem; cursor:pointer; font-weight:500;">
                    <input type="checkbox" name="is_active" value="1" checked style="width:18px; height:18px; cursor:pointer;">
                    <span>Active (User can log in)</span>
                </label>
            </div>

            <!-- Actions -->
            <div class="admin-form-actions" style="margin-top:2rem; padding-bottom:1.5rem;">
                <button type="submit" class="admin-btn admin-btn-primary">
                    <i class="bi bi-plus-lg" style="margin-right:0.5rem;"></i>Create User
                </button>
                <a href="{{ route('admin.users.index') }}" class="admin-btn admin-btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
