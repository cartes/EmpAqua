<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\User;
use App\Services\Mailer;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * Recuperación de clave para candidatos y empresas.
 */
class AccountController extends Controller
{
    public function resetPassword(Request $request, Mailer $mailer): RedirectResponse
    {
        return $this->sendResetLink($request, $mailer, 'aquabe_users', 'email', '/password/reset/');
    }

    public function resetBusinessPassword(Request $request, Mailer $mailer): RedirectResponse
    {
        return $this->sendResetLink($request, $mailer, 'aquabe_business', 'email_user', '/passwordBusiness/reset/');
    }

    public function showForm(string $token, Request $request): View
    {
        return view('user.changePassForm', ['email' => $request->email, 'token' => $token]);
    }

    public function showBusinessForm(string $token, Request $request): View
    {
        return view('business.changePassForm', ['email' => $request->email, 'token' => $token]);
    }

    public function changePassword(Request $request): RedirectResponse
    {
        return $this->updatePassword($request, User::query(), 'email');
    }

    public function changeBusinessPassword(Request $request): RedirectResponse
    {
        return $this->updatePassword($request, Business::query(), 'email_user');
    }

    private function sendResetLink(Request $request, Mailer $mailer, string $table, string $emailColumn, string $path): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        if (! DB::table($table)->where($emailColumn, $request->email)->exists()) {
            return back()->with('message', ['danger', 'Usuario no existe']);
        }

        $token = Str::random(60);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        $sent = $mailer->send(
            $request->email,
            'Clave reseteada',
            view('emails.notice', [
                'title' => 'Has solicitado cambio de clave',
                'link' => url($path . $token) . '?email=' . urlencode($request->email),
                'linkText' => 'Cambiar Clave',
            ])->render()
        );

        return back()->with('message', $sent ? ['success', 'Email enviado'] : ['danger', 'Error en el envio']);
    }

    private function updatePassword(Request $request, $query, string $emailColumn): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
            'token' => ['required', 'string'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        $reset = DB::table('password_resets')
            ->where(['email' => $request->email, 'token' => $request->token]);

        $account = $query->where($emailColumn, $request->email)->first();

        if (! $reset->exists() || ! $account instanceof Model) {
            return back()->with('message', ['danger', 'No tienes un token de acceso']);
        }

        $account->update(['password' => Hash::make($request->password)]);
        $reset->delete();

        return back()->with('message', ['success', 'Clave cambiada']);
    }
}
