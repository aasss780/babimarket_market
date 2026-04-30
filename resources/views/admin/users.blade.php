@extends('layouts.admin')

@section('page_title', 'Users')

@section('content')
    <p class="muted" style="margin-bottom:18px;">Manage registered accounts. Block or remove users as needed.</p>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td><strong>{{ $user->name }}</strong></td>
                        <td>{{ $user->email }}</td>
                        <td><span style="text-transform:capitalize;">{{ $user->role }}</span></td>
                        <td>
                            <span style="padding:4px 10px;border-radius:999px;font-size:12px;font-weight:600;background:{{ $user->status === 'active' ? '#E8F5E9' : '#FFEBEE' }};color:{{ $user->status === 'active' ? '#2E7D32' : '#C62828' }};">{{ $user->status }}</span>
                        </td>
                        <td style="text-align:right;">
                            @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.toggle', $user) }}" style="display:inline;">@csrf<button type="submit" class="btn btn-sm btn-secondary">{{ $user->status === 'active' ? 'Block' : 'Unblock' }}</button></form>
                                <form method="POST" action="{{ route('admin.users.delete', $user) }}" style="display:inline;margin-left:6px;" onsubmit="return confirm('Delete this user?');">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-danger">Delete</button></form>
                            @else
                                <span class="muted">You</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
