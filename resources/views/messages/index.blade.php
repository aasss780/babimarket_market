@extends('layouts.app')
@section('content')
<h2>Messages</h2>
<div style="display:grid;grid-template-columns:320px 1fr;gap:16px;">
    <div class="card">
        <h3 style="margin-bottom:10px;">Conversations</h3>
        @forelse($threads as $row)
            @php
                $thread = $row['latest'];
                $partner = $thread->sender_id === auth()->id() ? $thread->receiver : $thread->sender;
            @endphp
            @if($row['type'] === 'product')
                @php
                    $active = !($viewingContact ?? false) && (int) ($receiverId ?? 0) === (int) $partner->id && (int) ($productId ?? 0) === (int) $thread->product_id;
                @endphp
                <a href="{{ route('messages', ['receiver_id' => $partner->id, 'product_id' => $thread->product_id]) }}"
                   style="display:grid;grid-template-columns:52px 1fr;gap:10px;padding:10px;border:1px solid #EFEFEF;border-radius:12px;margin-bottom:8px;background:{{ $active ? '#FFF0EB' : '#FFF' }};text-decoration:none;color:inherit;">
                    <div style="width:52px;height:52px;border-radius:10px;overflow:hidden;background:#F2F2F2;flex-shrink:0;">
                        @if($thread->product && $thread->product->main_image)
                            <img src="{{ asset('storage/'.$thread->product->main_image) }}" alt="" style="width:100%;height:100%;object-fit:cover;">
                        @else
                            <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#CCC;font-size:18px;"><i class="fa-solid fa-image"></i></div>
                        @endif
                    </div>
                    <div>
                        <div style="font-weight:600;">{{ $thread->product->name ?? 'Product' }}</div>
                        <div style="font-size:12px;color:#777;">{{ $partner->name }}</div>
                        <div style="font-size:12px;color:#999;">{{ \Illuminate\Support\Str::limit($thread->message, 40) }}</div>
                    </div>
                </a>
            @else
                @php
                    $active = ($viewingContact ?? false) && $adminUser && (int) $partner->id === (int) $adminUser->id;
                @endphp
                <a href="{{ route('messages', ['contact' => 1, 'admin_id' => $partner->id]) }}"
                   style="display:grid;grid-template-columns:52px 1fr;gap:10px;padding:10px;border:1px solid #EFEFEF;border-radius:12px;margin-bottom:8px;background:{{ $active ? '#FFF0EB' : '#FFF' }};text-decoration:none;color:inherit;">
                    <div style="width:52px;height:52px;border-radius:10px;overflow:hidden;background:#1E3A34;flex-shrink:0;display:flex;align-items:center;justify-content:center;color:#fff;font-size:20px;">
                        <i class="fa-solid fa-headset"></i>
                    </div>
                    <div>
                        <div style="font-weight:600;">Support</div>
                        <div style="font-size:12px;color:#777;">{{ $partner->name }}</div>
                        <div style="font-size:12px;color:#999;">{{ \Illuminate\Support\Str::limit($thread->message, 40) }}</div>
                    </div>
                </a>
            @endif
        @empty
            <p class="muted">No conversations yet.</p>
        @endforelse
    </div>
    <div class="card">
        @if($viewingContact ?? false)
            <div style="margin-bottom:12px;">
                <div style="font-weight:700;font-size:18px;">Contact support</div>
                <div style="font-size:13px;color:#777;">{{ $receiverName ?? 'Admin' }}</div>
            </div>
            <div style="max-height:320px;overflow:auto;margin-bottom:12px;">
                @forelse($messages as $msg)
                    <div style="margin-bottom:10px;padding:10px;border:1px solid #EFEFEF;border-radius:10px;background:{{ $msg->sender_id===auth()->id() ? '#FFF0EB' : '#FFF' }};">
                        <div style="font-size:12px;color:#777;">{{ $msg->sender->name }} • {{ $msg->created_at?->format('M d, H:i') }}</div>
                        <div>{{ $msg->message }}</div>
                    </div>
                @empty
                    <p class="muted">No messages yet. Say hello below.</p>
                @endforelse
            </div>
            <form method="POST" action="{{ route('messages.store') }}">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $receiverId }}">
                <input type="hidden" name="product_id" value="">
                <textarea name="message" required placeholder="Write your message"></textarea>
                <button class="btn" type="submit" style="margin-top:8px;">Send message</button>
            </form>
        @elseif($receiverId && $productId && $product)
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
                <div style="width:56px;height:56px;border-radius:10px;overflow:hidden;background:#F2F2F2;">
                    @if($product->main_image)
                        <img src="{{ asset('storage/'.$product->main_image) }}" alt="{{ $product->name }}" style="width:100%;height:100%;object-fit:cover;">
                    @else
                        <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#CCC;"><i class="fa-solid fa-image"></i></div>
                    @endif
                </div>
                <div>
                    <div style="font-weight:700;">{{ $product->name }}</div>
                    <div style="font-size:12px;color:#777;">Seller: {{ $receiverName }}</div>
                </div>
            </div>
            <div style="max-height:320px;overflow:auto;margin-bottom:12px;">
                @forelse($messages as $msg)
                    <div style="margin-bottom:10px;padding:10px;border:1px solid #EFEFEF;border-radius:10px;background:{{ $msg->sender_id===auth()->id() ? '#FFF0EB' : '#FFF' }};">
                        <div style="font-size:12px;color:#777;">{{ $msg->sender->name }} • {{ $msg->created_at?->format('M d, H:i') }}</div>
                        <div>{{ $msg->message }}</div>
                    </div>
                @empty
                    <p class="muted">No messages yet for this product. Start the conversation.</p>
                @endforelse
            </div>
            <form method="POST" action="{{ route('messages.store') }}">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $receiverId }}">
                <input type="hidden" name="product_id" value="{{ $productId }}">
                <textarea name="message" required placeholder="Write your message"></textarea>
                <button class="btn" type="submit" style="margin-top:8px;">Send Message</button>
            </form>
        @else
            <p class="muted">Select a conversation from the list.</p>
        @endif
    </div>
</div>
@endsection
