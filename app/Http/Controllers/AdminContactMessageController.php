<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminContactMessageController extends Controller
{
    public function index(Request $request): View
    {
        $query = ContactMessage::query()->latest();

        if ($request->filled('q')) {
            $keyword = trim((string) $request->q);

            $query->where(function ($q) use ($keyword) {
                $q->where('full_name', 'like', "%{$keyword}%")
                    ->orWhere('email', 'like', "%{$keyword}%")
                    ->orWhere('phone', 'like', "%{$keyword}%")
                    ->orWhere('subject', 'like', "%{$keyword}%")
                    ->orWhere('message', 'like', "%{$keyword}%");
            });
        }

        if ($request->status === 'read') {
            $query->where('is_read', true);
        } elseif ($request->status === 'unread') {
            $query->where('is_read', false);
        }

        $messages = $query->paginate(12)->withQueryString();

        $stats = [
            'total' => ContactMessage::count(),
            'unread' => ContactMessage::where('is_read', false)->count(),
            'read' => ContactMessage::where('is_read', true)->count(),
        ];

        return view('admin.contact_messages.index', compact('messages', 'stats'));
    }

    public function show(ContactMessage $contactMessage): View
    {
        if (!$contactMessage->is_read) {
            $contactMessage->update([
                'is_read' => true,
            ]);
        }

        return view('admin.contact_messages.show', compact('contactMessage'));
    }

    public function markRead(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->update([
            'is_read' => true,
        ]);

        return back()->with('success', 'Tin nhắn đã được đánh dấu là đã đọc.');
    }

    public function markUnread(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->update([
            'is_read' => false,
        ]);

        return back()->with('success', 'Tin nhắn đã được chuyển về trạng thái chưa đọc.');
    }

    public function destroy(ContactMessage $contactMessage): RedirectResponse
    {
        $contactMessage->delete();

        return redirect()
            ->route('admin.contact-messages.index')
            ->with('success', 'Đã xoá tin nhắn liên hệ.');
    }
}