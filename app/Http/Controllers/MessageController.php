<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Mostrar modal con mensaje de la empresa
     */
    public function show(Request $request): JsonResponse
    {
        $user = User::whereKey($request->input('user'))->first(['name', 'surname']);

        $messages = Message::where([
            'offer_id' => $request->input('offer'),
            'user_id' => $request->input('user'),
        ])->with('children')->get();

        return response()->json([
            'user' => $user,
            'messages' => $messages,
            'reader' => session('id'),
        ]);
    }

    /**
     * Enviar el mensaje al usuario
     */
    public function send(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'subject' => ['nullable', 'string', 'max:255'],
            'offer_id' => ['required', 'exists:aquabe_offers,id'],
            'user_id' => ['required', 'exists:aquabe_users,id'],
            'content' => ['required', 'string'],
        ]);

        Message::create($data + [
            'status' => Message::SENDED,
            'sender_id' => session('id'),
        ]);

        return back()->with('message', ['success', 'Mensaje enviado al usuario']);
    }

    /**
     * Respuesta del usuario al mensaje
     */
    public function reply(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'subject' => ['nullable', 'string', 'max:255'],
            'offer_id' => ['required', 'exists:aquabe_offers,id'],
            'user_id' => ['required', 'exists:aquabe_users,id'],
            'message_id' => ['required', 'exists:aquabe_messages,id'],
            'content' => ['required', 'string'],
        ]);

        Message::whereKey($data['message_id'])->update(['status' => Message::READED]);

        Message::create($data + [
            'status' => Message::REPLYED,
            'sender_id' => session('id'),
        ]);

        return back()->with('message', ['success', 'Mensaje respondido']);
    }
}
