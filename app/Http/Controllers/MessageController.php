<?php

namespace App\Http\Controllers;

use App\Message;
use App\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Mostrar modal con mensaje de la empresa
     */
    public function show(Request $request)
    {
        $user = User::whereId($request->input('user'))
            ->select(['name', 'surname'])
            ->first();

        $messages = Message::where([
            "offer_id" => $request->input('offer'),
            "user_id" => $request->input('user')
        ])->with('children')->get();

        $response = [
            "user" => $user,
            "messages" => $messages,
            "reader" => session()->get("id"),
        ];

        return response()->json($response, 200);
    }

    /**
     * Enviar el mensaje al usuario
     */
    public function send(Request $request)
    {
        $request->merge(['status' => Message::SENDED]);
        $request->merge(['sender_id' => session()->get('id')]);

        Message::create($request->input());

        return back()->with('message', ['success', 'Mensaje enviado al usuario']);
    }

    /**
     * Usuario puede leer el mensaje
     */

    /**
     * Respueta del usuario al mensaje
     */
    public function reply(Request $request)
    {
        $message_to_reply = $request->message_id;
        Message::where('id', $message_to_reply)->update(['status' => Message::READED]);

        $request->merge(['sender_id' => session()->get('id')]);
        $request->merge(['status' => Message::REPLYED]);

        Message::create($request->input());

        return back()->with('message', ['success', 'Mensaje respondido']);

    }
}
