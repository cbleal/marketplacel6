<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function notifications()
    {
        // RECUPERAR AS NOTIFICAÇÕES NÃO LIDAS DO USUÁRIO AUTENTICADO
        $unreadNotifications = auth()->user()->unreadNotifications;
    
        return view('admin.notifications', compact('unreadNotifications'));
    }

    public function readAll()
    {
        // RECUPERAR AS NOTIFICAÇÕES NÃO LIDAS DO USUÁRIO AUTENTICADO
        $unreadNotifications = auth()->user()->unreadNotifications;

        // MARCAR COMO LIDAS AS NOTIFICAÇÕES NÃO LIDAS
        $unreadNotifications->each(function ($notification) {
            $notification->markAsRead();
        });

        flash('Notificações lidas com sucesso')->success();

        return redirect()->back();
    }

    public function read($notification)
    {
        $notification = auth()->user()->notifications()->find($notification);

        $notification->markAsRead();

        flash('Notificação lida com sucesso')->success();

        return redirect()->back();
    }
}
