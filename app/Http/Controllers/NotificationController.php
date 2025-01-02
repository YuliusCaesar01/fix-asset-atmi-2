<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function sendSSE()
{
    // Mengambil notifikasi yang belum dibaca untuk pengguna yang sedang login
    $notifications = Notification::where('id_user_penerima', auth()->user()->id)
        ->where('read_at', null)
        ->get();

    // Mengatur header untuk SSE
    header('Content-Type: text/event-stream');
    header('Cache-Control: no-cache');
    header('Connection: keep-alive');

    // Mengirim sinyal keep-alive dengan jumlah notifikasi
    echo "data: {\"count\": " . $notifications->count() . "}\n\n"; // Mengirim jumlah notifikasi

    // Menandai semua notifikasi sebagai dibaca
    foreach ($notifications as $notification) {
        $notification->update(['read_at' => now()]);
    }

    ob_flush(); // Mengirim output ke browser
    flush(); // Mengosongkan buffer output
}

}
