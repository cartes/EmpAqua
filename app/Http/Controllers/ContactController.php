<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Mail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class ContactController extends Controller
{
    public function getContactPage()
    {
        return view('contact.contact');
    }

    public function saveContact(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'subject' => 'required',
            'message_user' => 'required'
        ]);

        $contact = new Contact();

        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->phone = $request->phone;
        $contact->subject = $request->subject;
        $contact->message = $request->message_user;

        $contact->save();
        try {
            $mail = new PHPMailer(true);
            $mail->SMTPDebug = false;
            $mail->isSMTP();
            $mail->isHTML(true);
            $mail->Host = "zmail.editec.cl";
            $mail->SMTPAuth = true;
            $mail->Username = "empleosaqua@empleosaqua.cl";
            $mail->Password = "SkpC!r!w67%R&An)H@)0Ok5^";
            $mail->Port = 25;

            $mail->SMTPSecure = false;
            $mail->SMTPAutoTLS = false;

            $to = "empleosaqua@empleosaqua.cl";
            $subject = $request->get('subject');

            $message = '<td class="esd-stripe" style="background-color: #ffa73b;" esd-custom-block-id="6340" bgcolor="#ffa73b" align="center">';
            $message .= '<table class="es-content-body" style="background-color: transparent;" width="600" cellspacing="0" cellpadding="0" align="center">';
            $message .= '<tbody>';
            $message .= '<tr>';
            $message .= '<td class="esd-structure" align = "left" >';
            $message .= '<table width = "100%" cellspacing = "0" cellpadding = "0" >';
            $message .= '<tbody >';
            $message .= '<tr >';
            $message .= '<td class="esd-container-frame" width = "600" valign = "top" align = "center" >';
            $message .= '<table style = "background-color: #ffffff; border-radius: 4px; border-collapse: separate;" width = "100%" cellspacing = "0" cellpadding = "0" bgcolor = "#ffffff" >';
            $message .= '<tbody >';
            $message .= '<tr >';
            $message .= '<td class="esd-block-text es-p35t es-p5b es-p30r es-p30l" align = "center" >';
            $message .= '<h1 > Tienes un contacto <br></h1 >';
            $message .= '<h3 > De:' . $request->get("email") . '<br></h3 >';
            $message .= '<h3 > Tel&eacute;fono:' . $request->get("phone") . '<br></h3 >';
            $message .= '<h4 > Asunto:' . $request->get("subject") . '<br></h4 >';
            $message .= '<h4 > Mensaje:' . $request->get("message_user") . '<br></h4 >';
            $message .= '</td >';
            $message .= '</tr >';
            $message .= '<tr >';
            $message .= '<td class="esd-block-spacer es-p5t es-p5b es-p20r es-p20l" style = "font-size:0" bgcolor = "#ffffff" align = "center" >';
            $message .= '<table width = "100%" height = "100%" cellspacing = "0" cellpadding = "0" border = "0" >';
            $message .= '<tbody >';
            $message .= '<tr >';
            $message .= '<td style = "border-bottom: 1px solid #ffffff; background: rgba(0, 0, 0, 0) none repeat scroll 0% 0%; height: 1px; width: 100%; margin: 0px;" ></td >';
            $message .= '</tr >';
            $message .= '</tbody >';
            $message .= '</table >';
            $message .= '</td >';
            $message .= ' </tr >';
            $message .= '</tbody >';
            $message .= '</table >';
            $message .= '</td >';
            $message .= '</tr >';
            $message .= '</tbody >';
            $message .= '</table >';
            $message .= '</td >';
            $message .= '</tr >';
            $message .= '</tbody >';
            $message .= '</table >';
            $message .= '</td >';

            $header = "From:" . $request->get("email") . "\r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";

            $mail->addAddress($to);
            $mail->From = $to;
            $mail->Subject = $request->get("subject");
            $mail->Body = $message;

            $mail->send();
            return back()->with('message', ['success', 'Hemos recibido su tu correo']);

        } catch (phpmailerException $e) {
            echo $e;
        }
        ;

    }

}
