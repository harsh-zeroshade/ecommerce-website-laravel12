@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')

    @include('admin.partials.form-page-header', [
        'eyebrow' => 'User Management',
        'title'   => 'Edit User',
        'desc'    => 'Update account details, role, or status for ' . $user->name,
        'icon'    => 'bi-pencil-square',
        'backUrl' => route('admin.users.index'),
        'backLabel' => 'Back to users',
    ])

    <form
        method="POST"
        action="{{ route('admin.users.update', $user) }}"
        class="admin-form-modern"
        data-user-form
    >
        @csrf
        @method('PUT')

        <div class="admin-form-modern-grid">

            <div class="admin-form-modern-main">

                <x-admin-form-section title="Personal Information" icon="bi-person-circle" desc="Basic identity and contact info.">
                    <div class="admin-form-row">
                        @include('admin.partials.text-field', [
                            'name'         => 'name',
                            'label'        => 'Full Name',
                            'value'        => old('name', $user->name),
                            'placeholder'  => 'e.g. Ananya Iyer',
                            'required'     => true,
                            'icon'         => 'bi-person',
                            'autocomplete' => 'name',
                        ])

                        @include('admin.partials.text-field', [
                            'name'         => 'email',
                            'type'         => 'email',
                            'label'        => 'Email Address',
                            'value'        => old('email', $user->email),
                            'placeholder'  => 'name@adgon.com',
                            'required'     => true,
                            'icon'         => 'bi-envelope',
                            'autocomplete' => 'email',
                        ])
                    </div>

                    <div class="admin-form-row">
                        @include('admin.partials.text-field', [
                            'name'         => 'phone',
                            'type'         => 'tel',
                            'label'        => 'Phone Number',
                            'value'        => old('phone', $user->phone),
                            'placeholder'  => '+91 98765 43210',
                            'icon'         => 'bi-telephone',
                            'autocomplete' => 'tel',
                        ])

                        @include('admin.partials.select-field', [
                            'name'        => 'role',
                            'label'       => 'Role',
                            'options'     => ['customer' => 'Customer', 'admin' => 'Admin'],
                            'value'       => old('role', $user->role),
                            'placeholder' => 'Select a role…',
                            'required'    => true,
                            'icon'        => 'bi-shield-lock',
                        ])
                    </div>
                </x-admin-form-section>

                <x-admin-form-section title="Change Password" icon="bi-key" desc="Optional. Leave blank to keep the current password.">
                    <div class="admin-form-row">
                        @include('admin.partials.text-field', [
                            'name'         => 'password',
                            'type'         => 'password',
                            'label'        => 'New Password',
                            'placeholder'  => 'Min 8 characters',
                            'icon'         => 'bi-lock',
                            'autocomplete' => 'new-password',
                            'hint'         => 'Minimum 8 characters. Leave blank to keep the current password.',
                        ])

                        @include('admin.partials.text-field', [
                            'name'         => 'password_confirmation',
                            'type'         => 'password',
                            'label'        => 'Confirm New Password',
                            'placeholder'  => 'Repeat the new password',
                            'icon'         => 'bi-lock-fill',
                            'autocomplete' => 'new-password',
                        ])
                    </div>
                </x-admin-form-section>

                <div class="admin-form-card-footer">
                    <a href="{{ route('admin.users.index') }}" class="admin-btn admin-btn-outline">
                        <i class="bi bi-x-lg"></i> Cancel
                    </a>
                    <button type="submit" class="admin-btn admin-btn-primary admin-btn--lg">
                        <i class="bi bi-check2-circle"></i>
                        <span>Save Changes</span>
                    </button>
                </div>
            </div>

            <aside class="admin-form-modern-side">

                <x-admin-form-section title="Account Status" icon="bi-toggle-on" desc="Inactive users cannot log in until reactivated.">
                    <div class="admin-toggles-stack">
                        @include('admin.partials.toggle-field', [
                            'name'    => 'is_active',
                            'label'   => 'Active',
                            'icon'    => 'bi-check2-circle',
                            'hint'    => 'The user can sign in immediately.',
                            'checked' => old('is_active', $user->is_active),
                        ])
                    </div>
                </x-admin-form-section>

                <div class="admin-form-side-card">
                    <div class="admin-form-side-card-head">
                        <i class="bi bi-clock-history"></i>
                        <span>Account history</span>
                    </div>
                    <ul class="admin-history">
                        <li>
                            <span>Joined</span>
                            <strong>{{ $user->created_at->format('d M Y, H:i') }}</strong>
                        </li>
                        <li>
                            <span>Last updated</span>
                            <strong>{{ $user->updated_at->diffForHumans() }}</strong>
                        </li>
                        <li>
                            <span>Orders placed</span>
                            <strong>{{ $user->orders()->count() }}</strong>
                        </li>
                    </ul>
                </div>
            </aside>

        </div>
    </form>

@endsection
