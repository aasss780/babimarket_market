<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Notification;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Canonical entry from product page: always sets correct seller + product (no query typos).
     */
    public function indexForProduct(Request $request, Product $product)
    {
        if ($request->user()->role !== 'customer') {
            abort(403);
        }

        return redirect()->route('messages', [
            'receiver_id' => $product->seller_id,
            'product_id' => $product->id,
        ]);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $userId = $user->id;

        $base = Message::with(['sender', 'receiver', 'product'])
            ->where(function ($q) use ($userId) {
                $q->where('sender_id', $userId)->orWhere('receiver_id', $userId);
            })
            ->whereNotNull('product_id')
            ->latest()
            ->get();

        $productThreads = $base
            ->groupBy(function ($m) use ($userId) {
                $counterpartyId = $m->sender_id === $userId ? $m->receiver_id : $m->sender_id;

                return $counterpartyId.'_'.$m->product_id;
            })
            ->map(fn ($group) => $group->sortByDesc('id')->first())
            ->map(fn ($latest) => [
                'type' => 'product',
                'latest' => $latest,
                'sort_at' => $latest->created_at,
            ]);

        $contactBase = Message::with(['sender', 'receiver'])
            ->where(function ($q) use ($userId) {
                $q->where('sender_id', $userId)->orWhere('receiver_id', $userId);
            })
            ->whereNull('product_id')
            ->where(function ($q) {
                $q->whereHas('receiver', fn ($r) => $r->where('role', 'admin'))
                    ->orWhereHas('sender', fn ($s) => $s->where('role', 'admin'));
            })
            ->latest()
            ->get();

        $contactThreads = $contactBase
            ->groupBy(function ($m) use ($userId) {
                $counterpartyId = $m->sender_id === $userId ? $m->receiver_id : $m->sender_id;

                return 'contact_'.$counterpartyId;
            })
            ->map(fn ($group) => $group->sortByDesc('id')->first())
            ->map(fn ($latest) => [
                'type' => 'contact',
                'latest' => $latest,
                'sort_at' => $latest->created_at,
            ]);

        $threads = $productThreads->concat($contactThreads)->sortByDesc('sort_at')->values();

        $receiverId = null;
        $productId = null;
        $openContact = $request->boolean('contact');
        $adminUser = User::where('role', 'admin')->when(
            $request->filled('admin_id'),
            fn ($q) => $q->where('id', (int) $request->input('admin_id'))
        )->first();

        if ($request->filled('receiver_id') && $request->filled('product_id')) {
            $receiverId = (int) $request->input('receiver_id');
            $productId = (int) $request->input('product_id');
        }

        $messages = collect();
        $product = null;
        $receiver = null;
        $viewingContact = false;

        if ($receiverId && $productId) {
            $product = Product::find($productId);
            $receiver = User::find($receiverId);

            if (! $product || ! $receiver || $receiver->role !== 'seller' || (int) $product->seller_id !== $receiverId) {
                return redirect()->route('messages')
                    ->withErrors(['message' => 'Invalid conversation link. Open Contact Seller from the product page again.']);
            }

            if ($user->role !== 'customer') {
                return redirect()->route('seller.dashboard');
            }

            $messages = Message::with(['sender', 'receiver', 'product'])
                ->where('product_id', $productId)
                ->where(function ($q) use ($userId, $receiverId) {
                    $q->where(function ($q2) use ($userId, $receiverId) {
                        $q2->where('sender_id', $userId)->where('receiver_id', $receiverId);
                    })->orWhere(function ($q2) use ($userId, $receiverId) {
                        $q2->where('sender_id', $receiverId)->where('receiver_id', $userId);
                    });
                })
                ->orderBy('created_at')
                ->get();

            Message::where('receiver_id', $userId)
                ->where('sender_id', $receiverId)
                ->where('product_id', $productId)
                ->where('is_read', false)
                ->update(['is_read' => true]);
        } elseif ($openContact && $adminUser) {
            $viewingContact = true;
            $receiver = $adminUser;
            $receiverId = $adminUser->id;
            $productId = null;
            $product = null;

            $messages = Message::with(['sender', 'receiver'])
                ->whereNull('product_id')
                ->where(function ($q) use ($userId, $adminUser) {
                    $aid = $adminUser->id;
                    $q->where(function ($q2) use ($userId, $aid) {
                        $q2->where('sender_id', $userId)->where('receiver_id', $aid);
                    })->orWhere(function ($q2) use ($userId, $aid) {
                        $q2->where('sender_id', $aid)->where('receiver_id', $userId);
                    });
                })
                ->orderBy('created_at')
                ->get();

            Message::where('receiver_id', $userId)
                ->where('sender_id', $adminUser->id)
                ->whereNull('product_id')
                ->where('is_read', false)
                ->update(['is_read' => true]);
        }

        if ($openContact && ! $adminUser && ! ($receiverId && $productId)) {
            return redirect()->route('messages')
                ->withErrors(['message' => 'Could not open this conversation.']);
        }

        return view('messages.index', [
            'threads' => $threads,
            'messages' => $messages,
            'receiverId' => $receiverId,
            'productId' => $productId,
            'openContact' => $openContact && $adminUser,
            'viewingContact' => $viewingContact,
            'adminUser' => $adminUser,
            'receiverName' => $receiver?->name,
            'productName' => $product?->name,
            'product' => $product,
            'receiver' => $receiver,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'receiver_id' => ['required', 'exists:users,id'],
            'product_id' => ['nullable', 'exists:products,id'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $receiver = User::findOrFail($data['receiver_id']);
        $sender = $request->user();

        if (! empty($data['product_id'])) {
            $product = Product::findOrFail($data['product_id']);

            if ($sender->role === 'customer') {
                if ($receiver->role !== 'seller' || (int) $product->seller_id !== (int) $receiver->id) {
                    return back()->withErrors(['message' => 'Product does not match this seller.']);
                }
            } elseif ($sender->role === 'seller') {
                if ($receiver->role !== 'customer' || (int) $product->seller_id !== (int) $sender->id) {
                    return back()->withErrors(['message' => 'You can only reply in threads for your own products.']);
                }
            }
        }

        if ($data['product_id'] && $receiver->role === 'seller' && $sender->role !== 'customer') {
            return back()->withErrors(['message' => 'Only customers can contact sellers as buyers.']);
        }

        if ($receiver->role === 'seller' && empty($data['product_id'])) {
            return back()->withErrors(['message' => 'Product context is required to contact seller.']);
        }

        if ($sender->role === 'seller' && empty($data['product_id'])) {
            return back()->withErrors(['message' => 'Product context is required to reply.']);
        }

        $message = Message::create([
            'sender_id' => $sender->id,
            'receiver_id' => $data['receiver_id'],
            'product_id' => $data['product_id'] ?: null,
            'message' => $data['message'],
            'is_read' => false,
        ]);

        Notification::create([
            'user_id' => $message->receiver_id,
            'title' => 'New message',
            'message' => 'You received a new message.',
            'type' => 'message',
            'is_read' => false,
        ]);

        if ($sender->role === 'seller') {
            return redirect()->route('seller.messages', [
                'customer_id' => $data['receiver_id'],
                'product_id' => $data['product_id'],
            ])->with('success', 'Message sent.');
        }

        if ($sender->role === 'admin' && empty($data['product_id'])) {
            return redirect()->route('admin.messages', [
                'user_id' => $data['receiver_id'],
            ])->with('success', 'Reply sent.');
        }

        if (empty($data['product_id'])) {
            return redirect()->route('messages', [
                'contact' => 1,
                'admin_id' => $data['receiver_id'],
            ])->with('success', 'Message sent.');
        }

        return redirect()->route('messages', [
            'receiver_id' => $data['receiver_id'],
            'product_id' => $data['product_id'],
        ])->with('success', 'Message sent.');
    }

    public function adminMessages(Request $request)
    {
        $adminId = auth()->id();

        $grouped = Message::with(['sender', 'receiver'])
            ->whereNull('product_id')
            ->where(function ($q) use ($adminId) {
                $q->where('receiver_id', $adminId)->orWhere('sender_id', $adminId);
            })
            ->orderByDesc('id')
            ->get()
            ->groupBy(function ($m) use ($adminId) {
                return $m->sender_id === $adminId ? $m->receiver_id : $m->sender_id;
            });

        $threads = $grouped->map(function ($group) use ($adminId) {
            $latest = $group->sortByDesc('id')->first();
            $otherId = $latest->sender_id === $adminId ? $latest->receiver_id : $latest->sender_id;
            $unread = $group->where('receiver_id', $adminId)->where('sender_id', '!=', $adminId)->where('is_read', false)->count();

            return (object) [
                'latest' => $latest,
                'other_user_id' => $otherId,
                'unread' => $unread,
            ];
        })->values()->sortByDesc(fn ($t) => $t->latest->created_at)->values();

        $selectedUserId = $request->integer('user_id');
        $conversation = collect();
        $selectedUser = null;

        if ($selectedUserId && $selectedUserId !== $adminId) {
            $selectedUser = User::find($selectedUserId);
            if ($selectedUser) {
                $conversation = Message::with(['sender', 'receiver'])
                    ->whereNull('product_id')
                    ->where(function ($q) use ($adminId, $selectedUserId) {
                        $q->where(function ($q2) use ($adminId, $selectedUserId) {
                            $q2->where('sender_id', $adminId)->where('receiver_id', $selectedUserId);
                        })->orWhere(function ($q2) use ($adminId, $selectedUserId) {
                            $q2->where('sender_id', $selectedUserId)->where('receiver_id', $adminId);
                        });
                    })
                    ->orderBy('created_at')
                    ->get();

                Message::where('receiver_id', $adminId)
                    ->where('sender_id', $selectedUserId)
                    ->whereNull('product_id')
                    ->where('is_read', false)
                    ->update(['is_read' => true]);
            }
        }

        return view('admin.messages', [
            'threads' => $threads,
            'conversation' => $conversation,
            'selectedUser' => $selectedUser,
            'selectedUserId' => $selectedUserId,
        ]);
    }
}
