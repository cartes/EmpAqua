<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Services\Mailer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function getContactPage(): View
    {
        return view('contact.contact');
    }

    public function saveContact(Request $request, Mailer $mailer): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'subject' => ['required', 'string', 'max:255'],
            'message_user' => ['required', 'string'],
        ]);

        Contact::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'subject' => $data['subject'],
            'message' => $data['message_user'],
        ]);

        $sent = $mailer->send(
            config('mail.contact_to'),
            $data['subject'],
            view('emails.notice', [
                'title' => 'Tienes un contacto',
                'lines' => [
                    'De' => $data['email'],
                    'Teléfono' => $data['phone'],
                    'Asunto' => $data['subject'],
                    'Mensaje' => $data['message_user'],
                ],
            ])->render()
        );

        // El contacto ya quedó guardado en la base de datos aunque el correo falle.
        return back()->with('message', ['success', $sent ? 'Hemos recibido tu correo' : 'Hemos recibido tu mensaje']);
    }
}
