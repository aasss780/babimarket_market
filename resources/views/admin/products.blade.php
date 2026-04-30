@extends('layouts.admin')

@section('page_title', 'Products')

@section('content')
    <p class="muted" style="margin-bottom:18px;">All marketplace listings. Remove inappropriate items.</p>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Seller</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th style="text-align:right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>
                            <div style="width:58px;height:58px;border-radius:10px;overflow:hidden;background:#F2F2F2;display:flex;align-items:center;justify-content:center;">
                                @if($product->primary_image_url)
                                    <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" style="width:100%;height:100%;object-fit:cover;">
                                @else
                                    <i class="fa-regular fa-image" style="color:#B0B0B0;"></i>
                                @endif
                            </div>
                        </td>
                        <td><strong>{{ $product->name }}</strong></td>
                        <td>{{ $product->seller->name ?? '—' }}</td>
                        <td>${{ number_format($product->price, 2) }}</td>
                        <td><span style="text-transform:capitalize;">{{ $product->status }}</span></td>
                        <td style="text-align:right;">
                            <form method="POST" action="{{ route('admin.products.delete', $product) }}" style="display:inline;" onsubmit="return confirm('Delete this product?');">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-danger">Delete</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="muted" style="text-align:center;padding:28px;">No products yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
