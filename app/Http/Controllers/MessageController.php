<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;

class MessageController extends Controller
{
    // 📩 Menampilkan semua pesan
    public function index()
    {
        $messages = Message::latest()->get();

        return view('messages.index', compact('messages'));
    }

    // 👁️ Tandai pesan sudah dibaca
    public function read($id)
    {
        $message = Message::findOrFail($id);
        $message->is_read = true;
        $message->save();

        return redirect()->back()->with('success', 'Pesan dibaca');
    }

    // 🗑️ Hapus pesan (opsional)
    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();

        return redirect()->back()->with('success', 'Pesan dihapus');
    }
}