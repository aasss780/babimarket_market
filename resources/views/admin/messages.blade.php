@extends('layouts.admin')

@section('page_title', 'Contact messages')

@section('content')
    <p class="muted" style="margin-bottom:18px;">Conversations from the Contact page (not product seller chats).</p>
    <div style="display:grid;grid-template-columns:minmax(280px,340px) 1fr;gap:20px;align-items:start;">
        <div class="card" style="margin:0;padding:0;overflow:hidden;">
            <div style="padding:16px 18px;border-bottom:1px solid var(--border-color);font-weight:700;">Threads</div>
            <div style="max-height:calc(100vh - 220px);overflow-y:auto;">
                @forelse($threads as $t)
                    @php
                        $latest = $t->latest;
                        $other = \App\Models\User::find($t->other_user_id);
                        $active = (int) $selectedUserId === (int) $t->other_user_id;
                    @endphp
                    <a href="{{ route('admin.messages', ['user_id' => $t->other_user_id]) }}"
                       style="display:block;padding:14px 18px;border-bottom:1px solid var(--border-color);text-decoration:none;color:inherit;background:{{ $active ? '#FFF0EB' : 'transparent' }};">
                        <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:8px;">
                            <strong style="font-size:14px;">{{ $other?->name ?? 'User' }}</strong>
                            @if($t->unread > 0)
                                <span style="background:var(--primary);color:#fff;font-size:11px;font-weight:700;padding:2px 8px;border-radius:999px;">{{ $t->unread }}</span>
                            @endif
                        </div>
                        <div class="muted" style="font-size:12px;margin-top:4px;">{{ $other?->email }}</div>
                        <div class="muted" style="font-size:12px;margin-top:6px;">{{ \Illuminate\Support\Str::limit($latest->message, 48) }}</div>
                        <div class="muted" style="font-size:11px;margin-top:6px;">{{ $latest->created_at?->format('M j, Y g:i a') }}</div>
                    </a>
                @empty
                    <div class="muted" style="padding:24px;text-align:center;">No contact messages yet.</div>
                @endforelse
            </div>
        </div>
        <div class="card" style="margin:0;">
            @if($selectedUser && $conversation->isNotEmpty())
                <div style="border-bottom:1px solid var(--border-color);padding-bottom:16px;margin-bottom:16px;">
                    <h3 style="font-size:17px;font-weight:800;">{{ $selectedUser->name }}</h3>
                    <p class="muted" style="margin-top:4px;">{{ $selectedUser->email }}</p>
                </div>
                <div style="max-height:360px;overflow-y:auto;margin-bottom:18px;display:flex;flex-direction:column;gap:10px;">
                    @foreach($conversation as $msg)
                        <div style="padding:12px 14px;border-radius:12px;border:1px solid var(--border-color);background:{{ $msg->sender_id === auth()->id() ? '#FFF0EB' : '#F9F9F9' }};">
                            <div class="muted" style="font-size:12px;margin-bottom:6px;">{{ $msg->sender->name }} · {{ $msg->created_at?->format('M j, g:i a') }}</div>
                            <div style="font-size:14px;white-space:pre-wrap;">{{ $msg->message }}</div>
                        </div>
                    @endforeach
                </div>
                <form method="POST" action="{{ route('messages.store') }}">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{ $selectedUser->id }}">
                    <input type="hidden" name="product_id" value="">
                    <label class="muted" style="display:block;margin-bottom:8px;">Reply</label>
                    <textarea name="message" rows="4" required placeholder="Write your reply…" style="width:100%;resize:vertical;"></textarea>
                    <button type="submit" class="btn" style="margin-top:12px;">Send reply</button>
                </form>
            @elseif($selectedUser)
                <div style="border-bottom:1px solid var(--border-color);padding-bottom:16px;margin-bottom:16px;">
                    <h3 style="font-size:17px;font-weight:800;">{{ $selectedUser->name }}</h3>
                    <p class="muted" style="margin-top:4px;">{{ $selectedUser->email }}</p>
                </div>
                <p class="muted" style="margin-bottom:16px;">No messages in this thread yet.</p>
                <form method="POST" action="{{ route('messages.store') }}">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{ $selectedUser->id }}">
                    <input type="hidden" name="product_id" value="">
                    <textarea name="message" rows="4" required placeholder="Write a message…" style="width:100%;resize:vertical;"></textarea>
                    <button type="submit" class="btn" style="margin-top:12px;">Send</button>
                </form>
            @else
                <p class="muted" style="text-align:center;padding:40px 16px;">Select a thread to read the conversation and reply.</p>
            @endif
        </div>
    </div>
@endsection
