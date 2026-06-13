<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use App\Events\MessageSent;

class ChatController extends Controller
{
    /**
     * Tampilkan halaman chat di admin dashboard.
     */
    public function adminIndex()
    {
        // Ambil semua ID user (client) yang pernah mengirim pesan ke admin, atau menerima pesan dari admin
        $userIds = Message::whereHas('sender', function ($q) {
                $q->where('role', 'client');
            })
            ->pluck('sender_id')
            ->merge(
                Message::whereHas('receiver', function ($q) {
                    $q->where('role', 'client');
                })
                ->pluck('receiver_id')
            )
            ->unique();

        // Ambil data user beserta jumlah pesan belum dibaca dan pesan terakhir
        $chattedClients = User::whereIn('id', $userIds)
            ->get()
            ->map(function ($client) {
                // Pesan dari client ke admin yang belum dibaca
                $client->unread_count = Message::where('sender_id', $client->id)
                    ->where('is_read', false)
                    ->whereHas('receiver', function ($q) {
                        $q->where('role', 'admin');
                    })
                    ->count();

                $client->last_message = Message::where(function ($q) use ($client) {
                        $q->where('sender_id', $client->id)
                          ->whereHas('receiver', function ($r) {
                              $r->where('role', 'admin');
                          });
                    })->orWhere(function ($q) use ($client) {
                        $q->where('receiver_id', $client->id)
                          ->whereHas('sender', function ($s) {
                              $s->where('role', 'admin');
                          });
                    })
                    ->orderBy('created_at', 'desc')
                    ->first();

                return $client;
            })
            ->sortByDesc(function ($client) {
                return $client->last_message ? $client->last_message->created_at : now()->subYears(10);
            })
            ->values();

        // Ambil semua daftar client untuk memulai chat baru
        $allClients = User::where('role', 'client')->get();

        return view('admin.chats.index', compact('chattedClients', 'allClients'));
    }

    /**
     * Mengambil riwayat pesan antara client dengan tim admin.
     */
    public function getMessages($userId)
    {
        $myId = auth()->id();

        // Jika user yang login adalah client, lawan bicaranya adalah dirinya sendiri
        if (auth()->user()->role === 'client') {
            $clientId = $myId;
        } else {
            $clientId = $userId;
        }

        // Jika yang login adalah admin, tandai pesan dari client ini ke admin mana saja sebagai dibaca
        if (auth()->user()->role === 'admin') {
            Message::where('sender_id', $clientId)
                ->where('is_read', false)
                ->whereHas('receiver', function($q) {
                    $q->where('role', 'admin');
                })
                ->update(['is_read' => true]);
        } else {
            // Jika client yang login, tandai pesan dari admin ke dia sebagai dibaca
            Message::where('receiver_id', $myId)
                ->where('is_read', false)
                ->whereHas('sender', function($q) {
                    $q->where('role', 'admin');
                })
                ->update(['is_read' => true]);
        }

        // Ambil pesan dari client ini dengan semua admin
        $messages = Message::where(function ($query) use ($clientId) {
                $query->where('sender_id', $clientId)
                      ->whereHas('receiver', function($q) {
                          $q->where('role', 'admin');
                      });
            })
            ->orWhere(function ($query) use ($clientId) {
                $query->where('receiver_id', $clientId)
                      ->whereHas('sender', function($q) {
                          $q->where('role', 'admin');
                      });
            })
            ->with('sender')
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    /**
     * Menyimpan pesan chat baru dan memicu broadcast.
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required_without:image|nullable|string',
            'image' => 'required_without:message|nullable|image|max:2048',
            'receiver_id' => 'nullable|exists:users,id',
        ]);

        $user = auth()->user();
        $receiverId = $request->receiver_id;

        // Jika pengirim adalah client, arahkan secara otomatis ke admin pertama
        if ($user->role === 'client') {
            $admin = User::where('role', 'admin')->first();
            if (!$admin) {
                return response()->json(['error' => 'Admin belum terdaftar di sistem.'], 404);
            }
            $receiverId = $admin->id;
        } else {
            // Jika admin, penerima (client) wajib disertakan
            if (!$receiverId) {
                return response()->json(['error' => 'Penerima tidak valid.'], 400);
            }
        }

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('chats', 'public');
        }

        $message = Message::create([
            'sender_id' => $user->id,
            'receiver_id' => $receiverId,
            'message' => $request->message,
            'image' => $imagePath,
            'is_read' => false,
        ]);

        // Trigger Laravel Event Broadcast
        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'status' => 'Pesan terkirim',
            'message' => $message->load('sender')
        ]);
    }

    /**
     * Tarik (hapus) pesan yang dikirim oleh user sendiri.
     */
    public function destroy($id)
    {
        $message = Message::findOrFail($id);

        // Otorisasi: Hanya pengirim pesan yang boleh menghapus
        if (auth()->id() !== $message->sender_id) {
            return response()->json(['error' => 'Anda tidak memiliki akses untuk menghapus pesan ini.'], 403);
        }

        $messageId = $message->id;
        $senderId = $message->sender_id;
        $receiverId = $message->receiver_id;
        $senderRole = $message->sender->role;

        // Jika pesan memiliki gambar, hapus file fisiknya dari storage
        if ($message->image) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($message->image);
        }

        // Hapus dari database
        $message->delete();

        // Siarkan event MessageDeleted secara real-time
        broadcast(new \App\Events\MessageDeleted($messageId, $senderId, $receiverId, $senderRole))->toOthers();

        return response()->json([
            'status' => 'Pesan berhasil ditarik',
            'message_id' => $messageId
        ]);
    }
}
