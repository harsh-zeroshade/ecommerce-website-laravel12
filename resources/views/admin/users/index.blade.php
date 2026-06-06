@extends('layouts.admin')

@section('title', 'Users')

@section('styles')
<style>
    .users-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .users-table th {
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--admin-muted);
        text-align: left;
        padding: 0.85rem 1.25rem;
        background: var(--admin-bg);
        border-bottom: 2px solid var(--admin-border);
    }
    
    .users-table td {
        padding: 0.85rem 1.25rem;
        border-bottom: 1px solid var(--admin-border);
        font-size: 0.85rem;
        vertical-align: middle;
    }
    
    .users-table tbody tr {
        transition: all 0.2s ease;
    }
    
    .users-table tbody tr:hover {
        background: rgba(184, 149, 106, 0.04);
    }
    
    .user-cell {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    
    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--admin-gold), #8a6d4a);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #faf8f5;
        font-family: var(--font-display);
        font-size: 0.8rem;
        font-weight: 700;
        flex-shrink: 0;
    }
    
    .user-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }
    
    .user-name {
        font-weight: 600;
        color: var(--admin-text);
    }
    
    .user-email {
        font-size: 0.75rem;
        color: var(--admin-muted);
    }
    
    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.3rem 0.65rem;
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        border-radius: 4px;
    }
    
    .role-badge.admin {
        background: rgba(192, 57, 43, 0.12);
        color: var(--admin-danger);
    }
    
    .role-badge.customer {
        background: rgba(61, 107, 142, 0.12);
        color: var(--admin-info);
    }
    
    .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        padding: 0.3rem 0.65rem;
        font-size: 0.65rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        border-radius: 4px;
    }
    
    .status-badge::before {
        content: '';
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }
    
    .status-badge.active {
        background: rgba(45, 106, 79, 0.12);
        color: var(--admin-success);
    }
    
    .status-badge.inactive {
        background: rgba(107, 101, 96, 0.12);
        color: var(--admin-muted);
    }
    
    .date-cell {
        color: var(--admin-muted);
        font-size: 0.8rem;
    }
    
    .action-btns {
        display: flex;
        gap: 0.5rem;
    }
    
    .action-btn {
        padding: 0.35rem 0.7rem;
        font-size: 0.65rem;
        font-weight: 600;
        letter-spacing: 0.06em;
        text-transform: uppercase;
        background: transparent;
        border: 1px solid var(--admin-border);
        color: var(--admin-text);
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }
    
    .action-btn:hover {
        background: var(--admin-sidebar);
        color: #faf8f5;
        border-color: var(--admin-sidebar);
    }
    
    .action-btn.danger {
        color: var(--admin-danger);
        border-color: rgba(192, 57, 43, 0.3);
    }
    
    .action-btn.danger:hover {
        background: var(--admin-danger);
        color: white;
        border-color: var(--admin-danger);
    }
    
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: var(--admin-muted);
    }
    
    .empty-state i {
        font-size: 3rem;
        margin-bottom: 1rem;
        opacity: 0.3;
        display: block;
    }
    
    .empty-state h4 {
        font-family: var(--font-display);
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--admin-text);
        margin-bottom: 0.5rem;
    }
    
    .empty-state p {
        font-size: 0.9rem;
        margin-bottom: 1.5rem;
    }
    
    @media (max-width: 768px) {
        .users-table th,
        .users-table td {
            padding: 0.65rem 0.85rem;
            font-size: 0.8rem;
        }
        
        .user-cell {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.25rem;
        }
        
        .action-btns {
            flex-direction: column;
        }
        
        .action-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
@endsection

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
    <div class="admin-card-body" style="padding:0;">
        <div class="admin-table-wrap">
            @if($users->count() > 0)
                <table class="users-table datatable-list">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Joined</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>
                                <div class="user-cell">
                                    <div class="user-avatar">
                                        @if($user->avatar)
                                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
                                        @else
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <div class="user-name">{{ $user->name }}</div>
                                        <div class="user-email">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $user->phone ?? '—' }}</td>
                            <td>
                                <span class="role-badge {{ $user->role }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td>
                                <span class="status-badge {{ $user->is_active ? 'active' : 'inactive' }}">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="date-cell">{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="action-btns">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="action-btn">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn danger" onclick="return confirm('Delete this user?')">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <i class="bi bi-people"></i>
                    <h4>No users found</h4>
                    <p>Get started by adding your first user.</p>
                    <a href="{{ route('admin.users.create') }}" class="admin-btn admin-btn-primary">
                        <i class="bi bi-plus-lg"></i> Add User
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection