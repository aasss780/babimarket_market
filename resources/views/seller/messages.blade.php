@extends('layouts.seller')

@section('content')
    <h2 style="margin-bottom:14px;">Seller Messages</h2>
    <div style="display:grid;grid-template-columns:360px 1fr;gap:16px;">
        <div class="card">
            <h3 style="margin-bottom:10px;">Threads</h3>
            @forelse($threads as $thread)
                @php
                    $customer = $thread->sender_id === auth()->id() ? $thread->receiver : $thread->sender;
                    $active = (int)$customerId === (int)$customer->id && (int)$productId === (int)$thread->product_id;
                    $unread = \App\Models\Message::where('receiver_id', auth()->id())->where('sender_id', $customer->id)->where('product_id', $thread->product_id)->where('is_read', false)->count();
                @endphp
                <a href="{{ route('seller.messages', ['customer_id' => $customer->id, 'product_id' => $thread->product_id]) }}" style="display:grid;grid-template-columns:56px 1fr;gap:10px;padding:10px;border:1px solid #EFEFEF;border-radius:12px;margin-bottom:8px;background:{{ $active ? '#FFF0EB' : '#FFF' }};text-decoration:none;color:inherit;">
                    <div style="width:56px;height:56px;border-radius:10px;overflow:hidden;background:#F2F2F2;display:flex;align-items:center;justify-content:center;">
                        @if($thread->product && $thread->product->main_image)
                            <img src="{{ asset('storage/'.$thread->product->main_image) }}" style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <i class="fa-regular fa-image" style="color:#B0B0B0;"></i>
                        @endif
                    </div>
                    <div>
                        <div style="display:flex;justify-content:space-between;gap:8px;">
                            <strong>{{ $customer->name }}</strong>
                            @if($unread>0)<span style="background:#FF6F43;color:#fff;border-radius:999px;padding:0 8px;font-size:11px;">{{ $unread }}</span>@endif
                        </div>
                        <div class="muted">{{ $thread->product->name ?? 'Product' }}</div>
                        <div class="muted">{{ \Illuminate\Support\Str::limit($thread->message, 42) }}</div>
                        <div class="muted">{{ $thread->created_at?->diffForHumans() }}</div>
                    </div>
                </a>
            @empty
                <p class="muted">No messages yet.</p>
            @endforelse
        </div>
        <div class="card">
            @if($customer && $product)
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
                    <div style="width:64px;height:64px;border-radius:10px;overflow:hidden;background:#F2F2F2;">
                        @if($product->main_image)
                            <img src="{{ asset('storage/'.$product->main_image) }}" style="width:100%;height:100%;object-fit:cover;">
                        @endif
                    </div>
                    <div>
                        <div style="font-weight:700;">{{ $product->name }}</div>
                        <div class="muted">Customer: {{ $customer->name }} ({{ $customer->email }})</div>
                    </div>
                </div>
                <div style="max-height:320px;overflow:auto;margin-bottom:12px;">
                    @forelse($messages as $msg)
                        <div style="margin-bottom:10px;padding:10px;border:1px solid #EFEFEF;border-radius:10px;background:{{ $msg->sender_id===auth()->id() ? '#FFF0EB' : '#FFF' }};">
                            <div class="muted">{{ $msg->sender->name }} • {{ $msg->created_at?->format('M d, H:i') }}</div>
                            <div>{{ $msg->message }}</div>
                        </div>
                    @empty
                        <p class="muted">No messages in this thread yet.</p>
                    @endforelse
                </div>
                <form method="POST" action="{{ route('messages.store') }}">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{ $customerId }}">
                    <input type="hidden" name="product_id" value="{{ $productId }}">
                    <textarea name="message" required placeholder="Reply to customer"></textarea>
                    <button class="btn" type="submit" style="margin-top:8px;">Reply</button>
                </form>
            @else
                <p class="muted">Select a thread to reply.</p>
            @endif
        </div>
    </div>
@endsection
