@extends('admin.layouts.app')

@section('title', 'Manage Users - Themeour')
@section('page-title', 'Users')

@section('content')
    <div class="users-container">
        <!-- Header Section -->
        <div class="page-header">
            <div class="header-info">
                <h2>Manage Users</h2>
                <p>View and manage registered users</p>
            </div>
            <div class="header-actions">
                <div class="search-box">
                    <i class="fas fa-search"></i>
                    <input type="text" id="userSearch" placeholder="Search users..." class="search-input">
                </div>
            </div>
        </div>

        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Users Table -->
        <div class="data-table">
            @if ($users->count() > 0)
                <div class="table-responsive">
                    <table class="table" id="usersTable">
                        <thead>
                            <tr>
                                <th width="60">ID</th>
                                <th width="60">Avatar</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Orders</th>
                                <th>Joined Date</th>
                                <th>Status</th>
                                <th width="120">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>#{{ $user->id }}</td>
                                    <td>
                                        @if ($user->avatar)
                                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}"
                                                class="user-avatar">
                                        @else
                                            <div class="avatar-placeholder"
                                                style="background: {{ $user->avatar_color ?? '#6366f1' }}">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="user-info">
                                            <strong>{{ $user->name }}</strong>
                                            <small class="text-muted">{{ $user->username ?? '' }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="user-email">
                                            <i class="fas fa-envelope"></i>
                                            {{ $user->email }}
                                            @if ($user->email_verified_at)
                                                <span class="verified-badge" title="Email Verified">
                                                    <i class="fas fa-check-circle"></i>
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="order-count">
                                            <i class="fas fa-shopping-cart"></i>
                                            {{ $user->orders_count ?? 0 }} orders
                                        </span>
                                    </td>
                                    <td>
                                        <div class="join-date">
                                            <i class="fas fa-calendar-alt"></i>
                                            {{ $user->created_at->format('d M, Y') }}
                                        </div>
                                        <small>{{ $user->created_at->diffForHumans() }}</small>
                                    </td>
                                    <td>
                                        @if ($user->status === 'active')
                                            <span class="status-badge status-active">
                                                <i class="fas fa-circle"></i> Active
                                            </span>
                                        @else
                                            <span class="status-badge status-inactive">
                                                <i class="fas fa-circle"></i> Inactive
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="{{ route('admin.users.show', $user) }}" class="btn-icon btn-view"
                                                title="View User Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <button type="button" class="btn-icon btn-delete" title="Delete User"
                                                onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <form id="delete-form-{{ $user->id }}"
                                                action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <i class="fas fa-users-slash"></i>
                    <h3>No Users Found</h3>
                    <p>No registered users yet.</p>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .users-container {
            padding: 0;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #f0f0f0;
        }

        .header-info h2 {
            font-size: 24px;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 5px;
        }

        .header-info p {
            color: var(--gray);
            font-size: 14px;
        }

        .search-box {
            position: relative;
        }

        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
        }

        .search-input {
            padding: 10px 15px 10px 40px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            width: 250px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table thead th {
            background: #f9fafb;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: var(--dark);
            font-size: 13px;
            border-bottom: 2px solid #e5e7eb;
        }

        .table tbody td {
            padding: 15px;
            border-bottom: 1px solid #f0f0f0;
            vertical-align: middle;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .avatar-placeholder {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 18px;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-info strong {
            color: var(--dark);
            margin-bottom: 2px;
        }

        .user-info small {
            font-size: 12px;
            color: #6b7280;
        }

        .user-email {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #6b7280;
            font-size: 14px;
        }

        .user-email i {
            color: #9ca3af;
            width: 16px;
        }

        .verified-badge {
            color: #10b981;
            margin-left: 5px;
        }

        .verified-badge i {
            color: #10b981;
        }

        .order-count {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            background: #f3f4f6;
            border-radius: 12px;
            font-size: 13px;
            color: #4b5563;
        }

        .join-date {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 3px;
        }

        .join-date i {
            color: #9ca3af;
            width: 14px;
            font-size: 12px;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }

        .status-badge i {
            font-size: 8px;
        }

        .status-active {
            background: #d1fae5;
            color: #10b981;
        }

        .status-inactive {
            background: #fee2e2;
            color: #ef4444;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s;
            cursor: pointer;
            border: none;
        }

        .btn-view {
            background: #e0e7ff;
            color: #6366f1;
        }

        .btn-view:hover {
            background: #6366f1;
            color: white;
        }

        .btn-delete {
            background: #fee2e2;
            color: #ef4444;
        }

        .btn-delete:hover {
            background: #ef4444;
            color: white;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state i {
            font-size: 64px;
            color: #d1d5db;
            margin-bottom: 20px;
        }

        .empty-state h3 {
            font-size: 20px;
            color: var(--dark);
            margin-bottom: 10px;
        }

        .empty-state p {
            color: var(--gray);
            margin-bottom: 20px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        function confirmDelete(userId, userName) {
            if (confirm(`Are you sure you want to delete user "${userName}"? This action cannot be undone.`)) {
                document.getElementById('delete-form-' + userId).submit();
            }
        }

        // Search functionality
        document.getElementById('userSearch').addEventListener('keyup', function() {
            const searchValue = this.value.toLowerCase();
            const table = document.getElementById('usersTable');
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) {
                const row = rows[i];
                const name = row.cells[2]?.textContent.toLowerCase() || '';
                const email = row.cells[3]?.textContent.toLowerCase() || '';

                if (name.includes(searchValue) || email.includes(searchValue)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    </script>
@endpush
