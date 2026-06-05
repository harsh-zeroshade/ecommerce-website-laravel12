@extends('layouts.admin')

@section('title', 'Users')

@section('content')
<div class="admin-page-header">
    <div>
        <span class="eyebrow">Management</span>
        <h1>Users</h1>
    </div>
    <a href="{{ route('admin.users.create') }}" class="admin-btn admin-btn-primary">
        <i class="bi bi-plus-lg"></i> Add User
    </a>
</div>

<div class="admin-card">
    <div class="admin-card-body">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td><strong>{{ $user->name }}</strong></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? '—' }}</td>
                        <td>
                            <span class="admin-badge admin-badge-{{ $user->role === 'admin' ? 'danger' : 'info' }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            <span class="admin-badge admin-badge-{{ $user->is_active ? 'success' : 'muted' }}">
                                {{ $user->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td><span class="text-muted">{{ $user->created_at->format('d M Y') }}</span></td>
                        <td>
                            <div class="admin-btn-group">
                                <a href="{{ route('admin.users.edit', $user) }}" class="admin-btn admin-btn-outline admin-btn-sm">Edit</a>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm" onclick="return confirm('Delete this user?')">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-row">
                        <td colspan="7">No users found. <a href="{{ route('admin.users.create') }}" style="color:var(--admin-gold);">Add your first user</a></td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($users->hasPages())
<div class="admin-pagination">
    {{ $users->links() }}
</div>
@endif
@endsection
