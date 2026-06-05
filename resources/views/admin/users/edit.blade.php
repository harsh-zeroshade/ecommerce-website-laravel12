@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="admin-page-header">
    <div>
        <span class="eyebrow">User Management</span>
        <h1>Edit User</h1>
        <p style="margin-top:0.5rem; color:var(--text-muted); font-size:0.95rem;">
            Update user account details and permissions.
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
        <form method="POST" action="{{ route('admin.users.update', $user) }}" style="padding:0 1.5rem;">
            @csrf
            @method('PUT')

            <!-- Personal Information Section -->
            <h4 style="font-size:0.9rem; font-weight:600; text-transform:uppercase; letter-spacing:0.08em; color:var(--text-muted); margin:0 0 1.5rem 0;">Personal Information</h4>

            <div class="admin-form-grid">
                <div class="admin-field">
                    <label for="name">Full Name <span style="color:#d97706;">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    @error('name')<span style="color:#d97706; font-size:0.85rem;">{{ $message }}</span>@enderror
                </div>
                <div class="admin-field">
                    <label for="email">Email <span style="color:#d97706;">*</span></label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                    @error('email')<span style="color:#d97706; font-size:0.85rem;">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="admin-form-grid">
                <div class="admin-field">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                    @error('phone')<span style="color:#d97706; font-size:0.85rem;">{{ $message }}</span>@enderror
                </div>
                <div class="admin-field">
                    <label for="role">Role <span style="color:#d97706;">*</span></label>
                    <select id="role" name="role" required>
                        <option value="customer" {{ old('role', $user->role) === 'customer' ? 'selected' : '' }}>Customer</option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')<span style="color:#d97706; font-size:0.85rem;">{{ $message }}</span>@enderror
                </div>
            </div>

            <hr style="border:none; border-top:1px solid var(--border); margin:2rem 0;">

            <!-- Account Information -->
            <h4 style="font-size:0.9rem; font-weight:600; text-transform:uppercase; letter-spacing:0.08em; color:var(--text-muted); margin:0 0 1.5rem 0;">Account Information</h4>

            <div class="admin-form-grid">
                <div class="admin-field">
                    <label>Joined Date</label>
                    <input type="text" value="{{ $user->created_at->format('d M Y, H:i') }}" disabled style="background:var(--bg-warm); cursor:not-allowed;">
                </div>
                <div class="admin-field">
                    <label>Last Updated</label>
                    <input type="text" value="{{ $user->updated_at->format('d M Y, H:i') }}" disabled style="background:var(--bg-warm); cursor:not-allowed;">
                </div>
            </div>

            <hr style="border:none; border-top:1px solid var(--border); margin:2rem 0;">

            <!-- Password Section -->
            <h4 style="font-size:0.9rem; font-weight:600; text-transform:uppercase; letter-spacing:0.08em; color:var(--text-muted); margin:0 0 1.5rem 0;">Change Password (Optional)</h4>

            <div class="admin-form-grid">
                <div class="admin-field">
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password">
                    <small style="color:var(--text-muted); margin-top:0.35rem; display:block;">Leave blank to keep current password</small>
                    @error('password')<span style="color:#d97706; font-size:0.85rem;">{{ $message }}</span>@enderror
                </div>
                <div class="admin-field">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation">
                </div>
            </div>

            <hr style="border:none; border-top:1px solid var(--border); margin:2rem 0;">

            <!-- Status -->
            <div class="admin-field">
                <label style="display:flex; align-items:center; gap:0.75rem; cursor:pointer; font-weight:500;">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }} style="width:18px; height:18px; cursor:pointer;">
                    <span>Active (User can log in)</span>
                </label>
            </div>

            <!-- Actions -->
            <div class="admin-form-actions" style="margin-top:2rem; padding-bottom:1.5rem;">
                <button type="submit" class="admin-btn admin-btn-primary">
                    <i class="bi bi-check-lg" style="margin-right:0.5rem;"></i>Save Changes
                </button>
                <a href="{{ route('admin.users.index') }}" class="admin-btn admin-btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
