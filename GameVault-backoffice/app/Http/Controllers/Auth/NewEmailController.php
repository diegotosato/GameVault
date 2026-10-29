<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailChangeVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class NewEmailController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            //  email (formato valido) e unique:users per assicurarsi che non sia già usata da un altro utente.
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
        ]);

        // Str::random(64) — genera un token casuale di 64 caratteri crittograficamente sicuro
        $token = Str::random(64);

        /* Cache::put('email_change_' . $token, [...], now()->addMinutes(60));
        salva in cache un array con l'user_id dell'utente autenticato e la new_email richiesta;
        il prefisso email_change_ evita collisioni con altre chiavi in cache; scade dopo 60 minuti */
        Cache::put('email_change_' . $token, [
            'user_id'   => $request->user()->id,
            'new_email' => $request->email,
        ], now()->addMinutes(60));

        // route('email.change.verify', ['token' => $token]) — costruisce l'URL del link di verifica usando il nome della route che abbiamo definito in auth.php,
        // passando il token come parametro
        $verifyUrl = route('email.change.verify', ['token' => $token]);

        // Mail::to($email)->queue(new EmailChangeVerification($verifyUrl)) — aggiunge l'email alla coda e ritorna immediatamente, senza aspettare l'invio
        // La risposta HTTP arriva all'utente in pochi ms; l'email viene processata in background dal queue worker
        Mail::to($request->email)->queue(new EmailChangeVerification($verifyUrl));

        return response()->json([
            'success' => 200,
            'message' => 'Email di verifica inviata.'
        ]);
    }

    public function verify(string $token)
    {
        // Cache::get('email_change_' . $token) — cerca in cache i dati associati al token; se non esiste (scaduto o mai esistito) restituisce null
        $data = Cache::get('email_change_' . $token);

        // Controllo if (!$data) — risponde 422 con messaggio d'errore; questo previene qualsiasi abuso di token inventati o scaduti
        if (!$data) {
            return redirect(config('app.frontend_url') . '/email-changed?success=false');
        }

        // User::findOrFail($data['user_id']) — recupera l'utente; se per qualche motivo non esiste più lancia un 404 automaticamente
        $user = User::findOrFail($data['user_id']);
        $user->email = $data['new_email'];
        // $user->email_verified_at = null — resetta la verifica email: la nuova email non è ancora verificata,
        // l'utente dovrà ri-verificarla tramite il normale flusso di verifica email di Laravel
        $user->email_verified_at = null;
        $user->save();

        // Cache::forget(...) — fondamentale per la sicurezza: invalida il token subito dopo l'uso, così non può essere riusato
        Cache::forget('email_change_' . $token);

        return redirect(config('app.frontend_url') . '/landing-page');
    }
}
