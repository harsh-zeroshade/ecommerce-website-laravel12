@extends('layouts.admin')

@section('title', 'Add User')

@section('content')

    @include('admin.partials.form-page-header', [
        'eyebrow' => 'User Management',
        'title'   => 'Add New User',
        'desc'    => 'Create a new user account and choose their role.',
        'icon'    => 'bi-person-plus',
        'backUrl' => route('admin.users.index'),
        'backLabel' => 'Back to users',
    ])

    <form
        method="POST"
        action="{{ route('admin.users.store') }}"
        class="admin-form-modern"
        data-user-form
    >
        @csrf

        <div class="admin-form-modern-grid">

            <div class="admin-form-modern-main">

                <x-admin-form-section title="Personal Information" icon="bi-person-circle" desc="Basic identity and contact info.">
                    <div class="admin-form-row">
                        @include('admin.partials.text-field', [
                            'name'         => 'name',
                            'label'        => 'Full Name',
                            'placeholder'  => 'e.g. Ananya Iyer',
                            'required'     => true,
                            'icon'         => 'bi-person',
                            'autocomplete' => 'name',
                        ])

                        @include('admin.partials.text-field', [
                            'name'         => 'email',
                            'type'         => 'email',
                            'label'        => 'Email Address',
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
                            'placeholder'  => '+91 98765 43210',
                            'icon'         => 'bi-telephone',
                            'autocomplete' => 'tel',
                        ])

                        @include('admin.partials.select-field', [
                            'name'        => 'role',
                            'label'       => 'Role',
                            'options'     => ['customer' => 'Customer', 'admin' => 'Admin'],
                            'placeholder' => 'Select a role…',
                            'required'    => true,
                            'icon'        => 'bi-shield-lock',
                        ])
                    </div>
                </x-admin-form-section>

                <x-admin-form-section title="Set Password" icon="bi-key" desc="They can change this after their first login.">
                    <div class="admin-form-row">
                        @include('admin.partials.text-field', [
                            'name'         => 'password',
                            'type'         => 'password',
                            'label'        => 'Password',
                            'placeholder'  => 'Min 8 characters',
                            'required'     => true,
                            'icon'         => 'bi-lock',
                            'autocomplete' => 'new-password',
                            'hint'         => 'Minimum 8 characters with letters and numbers.',
                        ])

                        @include('admin.partials.text-field', [
                            'name'         => 'password_confirmation',
                            'type'         => 'password',
                            'label'        => 'Confirm Password',
                            'placeholder'  => 'Repeat the password',
                            'required'     => true,
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
                        <span>Create User</span>
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
                            'checked' => old('is_active', true),
                        ])
                    </div>
                </x-admin-form-section>

                <div class="admin-form-side-card">
                    <div class="admin-form-side-card-head">
                        <i class="bi bi-shield-check"></i>
                        <span>Role guide</span>
                    </div>
                    <ul class="admin-tips">
                        <li><i class="bi bi-person"></i> <strong>Customer</strong> — can shop, review, track orders</li>
                        <li><i class="bi bi-shield-lock"></i> <strong>Admin</strong> — full access to the admin panel</li>
                    </ul>
                </div>
            </aside>

        </div>
    </form>

@endsection
