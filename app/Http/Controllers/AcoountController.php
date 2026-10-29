<?php

namespace App\Http\Controllers;

use App\Business;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class AcoountController extends Controller
{
    public function resetPassword(Request $request)
    {
        $user = DB::table('aquabe_users')->where('email', '=', $request->email)->first();

        if (!$user) {
            return back()->with('message', ['danger', 'Usuario no existe']);
        }
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => Str::random(60),
            'created_at' => Carbon::now()
        ]);

        $tokenData = DB::table('password_resets')->where('email', $request->email)->first();

        if ($this->sendResetEmail($request->email, $tokenData->token)) {
            return back()->with('message', ['success', 'Email enviado']);
        } else {
            return back()->with('message', ['danger', 'Error en el envio']);
        }
    }

    public function resetBusinessPassword(Request $request)
    {
        $user = DB::table('aquabe_business')->where('email_user', '=', $request->email)->first();

        if (!$user) {
            return back()->with('message', ['danger', 'Usuario no existe']);
        }

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => Str::random(60),
            'created_at' => Carbon::now()
        ]);

        $tokenData = DB::table('password_resets')->where('email', $request->email)->first();

        if ($this->sendResetBusinessEmail($request->email, $tokenData->token)) {
            return back()->with('message', ['success', 'Email enviado']);
        } else {
            return back()->with('message', ['danger', 'Error en el envio']);
        }
    }

    public function showForm($token, Request $request)
    {
        return view('user.changePassForm')->with([
            'email' => $request->email,
            'token' => $token
        ]);
    }

    public function showBusinessForm($token, Request $request)
    {
        return view('business.changePassForm')->with([
            'email' => $request->email,
            'token' => $token
        ]);
    }

    public function changePassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed'
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate);
        }

        $token = DB::table('password_resets')->where([
            "email" => $request->email,
            "token" => $request->token
        ])->first();
        if ($token) {
            $hash = \Hash::make($request->password);
            $user = User::where('email', $request->email)->first();

            User::whereId($user->id)->update([
                'password' => $hash
            ]);

            DB::table('password_resets')->where([
                "email" => $request->email,
                "token" => $request->token
            ])->delete();

            return back()->with('message', ['success', 'Clave cambiada']);
        } else {
            return back()->with('message', ['danger', 'No tienes un token de acceso']);
        }
    }

    public function changeBusinessPassword(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'password' => 'required|min:6|confirmed'
        ]);
        if ($validate->fails()) {
            return back()->withErrors($validate);
        }

        $token = DB::table('password_resets')->where([
            "email" => $request->email,
            "token" => $request->token
        ])->first();
        if ($token) {
            $hash = \Hash::make($request->password);
            $user = Business::where('email_user', $request->email)->first();

            Business::whereId($user->id)->update([
                'password' => $hash
            ]);

            DB::table('password_resets')->where([
                "email" => $request->email,
                "token" => $request->token
            ])->delete();

            return back()->with('message', ['success', 'Clave cambiada']);
        } else {
            return back()->with('message', ['danger', 'No tienes un token de acceso']);
        }
    }

    private function sendResetEmail($email, $token)
    {
        $link = 'http://www.empleosaqua.cl/password/reset/' . $token . "?email=" . urlencode($email);

        try {
            $mail = new PHPMailer(true);
            $mail->SMTPDebug = false;
            $mail->isSMTP();
            $mail->isHTML(true);
            $mail->Host = "mail.editec.cl";
            $mail->SMTPAuth = true;
            $mail->Username = "empleosaqua@empleosaqua.cl";
            $mail->Password = 'SkpC!r!w67%R&An)H@)0Ok5^';
            $mail->Port = 25;

            $mail->SMTPSecure = false;
            $mail->SMTPAutoTLS = false;

            $to = $email;
            $subject = "Clave reseteada";
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
            $message .= '<h1 > Has solicitado cambio de clave <br></h1 >';
            $message .= '<br><br><p> Has click en el siguiente link</p><p><a href=" ' . $link . '">Cambiar Clave</a></p>';
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


            $header = "From: empleosaqua@empleosaqua.cl \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";

            $mail->addAddress($to);
            $mail->From = "empleosaqua@empleosaqua.cl";
            $mail->Subject = $subject;
            $mail->Body = $message;

            $mail->send();
            return back()->with('message', ['success', 'Hemos enviado un correo']);
        } catch (Exception $e) {
            echo "Catched: " . $e->getMessage();
        }
        ;
    }

    private function sendResetBusinessEmail($email, $token)
    {
        $link = 'http://www.empleosaqua.cl/passwordBusiness/reset/' . $token . "?email=" . urlencode($email);

        try {
            $mail = new PHPMailer(true);
            $mail->SMTPDebug = false;
            $mail->isSMTP();
            $mail->isHTML(true);
            $mail->Host = "mail.editec.cl";
            $mail->SMTPAuth = true;
            $mail->Username = "empleosaqua@empleosaqua.cl";
            $mail->Password = 'SkpC!r!w67%R&An)H@)0Ok5^';
            $mail->Port = 25;

            $mail->SMTPSecure = false;
            $mail->SMTPAutoTLS = false;

            $to = $email;
            $subject = "Clave reseteada";
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
            $message .= '<h1 > Has solicitado cambio de clave <br></h1 >';
            $message .= '<br><br><p> Has click en el siguiente link</p><p><a href=" ' . $link . '">Cambiar Clave</a></p>';
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


            $header = "From: empleosaqua@empleosaqua.cl \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";

            $mail->addAddress($to);
            $mail->From = "empleosaqua@empleosaqua.cl";
            $mail->Subject = $subject;
            $mail->Body = $message;

            $mail->send();
            return back()->with('message', ['success', 'Hemos enviado un correo']);
        } catch (phpmailerException $e) {
            echo "Catched" . $e->getMessage();
        }
        ;
    }
}
