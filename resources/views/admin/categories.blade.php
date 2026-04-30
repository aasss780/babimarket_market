@extends('layouts.admin')

@section('page_title', 'Categories')

@section('content')
    <div class="card" style="max-width:520px;">
        <h3 style="font-size:16px;font-weight:700;margin-bottom:14px;">Add category</h3>
        <form method="POST" action="{{ route('admin.categories.store') }}" style="display:flex;gap:10px;flex-wrap:wrap;align-items:flex-end;">
            @csrf
            <div style="flex:1;min-width:180px;">
                <label class="muted" style="display:block;margin-bottom:6px;">Name</label>
                <input type="text" name="name" placeholder="Category name" required style="width:100%;">
            </div>
            <button type="submit" class="btn">Add</button>
        </form>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td><strong>{{ $category->name }}</strong></td>
                        <td style="text-align:right;">
                            <form method="POST" action="{{ route('admin.categories.delete', $category) }}" style="display:inline;" onsubmit="return confirm('Delete this category?');">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-danger">Delete</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="2" class="muted" style="text-align:center;padding:28px;">No categories yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
