<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = Notification::where('user_id', $request->user()->id)->latest()->get();
        Notification::where('user_id', $request->user()->id)->where('is_read', false)->update(['is_read' => true]);
        return view('notifications', compact('notifications'));
    }

    public function sellerIndex(Request $request)
    {
        $notifications = Notification::where('user_id', $request->user()->id)->latest()->get();
        Notification::where('user_id', $request->user()->id)->where('is_read', false)->update(['is_read' => true]);
        return view('seller.notifications', compact('notifications'));
    }

    public function adminIndex(Request $request)
    {
        $notifications = Notification::where('user_id', $request->user()->id)->latest()->get();
        Notification::where('user_id', $request->user()->id)->where('is_read', false)->update(['is_read' => true]);

        return view('admin.notifications', compact('notifications'));
    }
}
