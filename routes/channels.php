<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Log;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('conversation.{conversationId}', function ($user, $conversationId) {
    Log::info("Mengesahkan pengguna #{$user->id} ({$user->name}) untuk perbualan #{$conversationId}.");

    $conversation = \App\Models\Conversation::find($conversationId);
    
    if (!$conversation) {
        Log::warning("Gagal: Perbualan #{$conversationId} tidak ditemui.");
        return false;
    }
    
    $is_customer = ($user->id === $conversation->user_id);
    $is_admin = ($user->role === 'admin');
    $authorized = $is_customer || $is_admin;

    Log::info("Keputusan untuk perbualan #{$conversationId}: " . ($authorized ? 'DIBENARKAN' : 'DITOLAK'));
    
    return $authorized;
}); 