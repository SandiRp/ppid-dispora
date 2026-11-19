<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;

class AuthController extends Controller
{
    // Menampilkan halaman form login
    public function login()
    {
        return view('auth.login');
    }

    // Memproses data login
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            \App\Models\AuditLog::record('LOGIN', 'auth', 'Petugas berhasil login ke sistem');

            // Jika sukses, arahkan ke dashboard admin
            return redirect()->intended(route('admin.dashboard'))->with('success', 'Selamat datang kembali, ' . Auth::user()->name . '!');
        }

        // Jika gagal, kembalikan ke halaman login dengan pesan error
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // Memproses logout
    public function logout(Request $request)
    {
        \App\Models\AuditLog::record('LOGOUT', 'auth', 'Petugas logout dari sistem');

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Anda telah berhasil logout.');
    }

    // --- FITUR LUPA & RESET PASSWORD PETUGAS ---
    public function forgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format alamat email tidak valid.',
        ]);

        $email = trim($request->input('email'));
        $user = User::where('email', $email)->first();

        if ($user) {
            $token = Str::random(64);

            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $user->email],
                [
                    'token' => Hash::make($token),
                    'created_at' => now(),
                ]
            );

            $resetUrl = route('password.reset', ['token' => $token, 'email' => $user->email]);
            $namaAman = e($user->name);
            $urlAman = e($resetUrl);

            try {
                $htmlBody = "
                    <div style='font-family: Arial, sans-serif; max-width: 560px; margin: 0 auto; padding: 24px; border: 1px solid #e5e7eb; border-radius: 12px;'>
                        <h2 style='color: #0d9488; margin-top: 0;'>Reset Password Admin PPID Dispora Jatim</h2>
                        <p>Halo <strong>{$namaAman}</strong>,</p>
                        <p>Kami menerima permintaan untuk mengatur ulang kata sandi akun petugas PPID Anda. Klik tombol di bawah ini untuk membuat kata sandi baru (tautan berlaku selama 60 menit):</p>
                        <p style='text-align: center; margin: 28px 0;'>
                            <a href='{$urlAman}' style='background-color: #0d9488; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: bold; display: inline-block;'>Atur Ulang Password</a>
                        </p>
                        <p style='font-size: 12px; color: #6b7280;'>Jika tombol tidak berfungsi, salin tautan berikut ke peramban Anda:<br>{$urlAman}</p>
                        <hr style='border: none; border-top: 1px solid #e5e7eb; margin: 20px 0;'>
                        <p style='font-size: 12px; color: #9ca3af;'>Abaikan email ini jika Anda tidak merasa meminta reset kata sandi.</p>
                    </div>
                ";

                Mail::html($htmlBody, function ($message) use ($user) {
                    $message->to($user->email, $user->name)
                        ->subject('Tautan Reset Password - Admin PPID Dispora Jatim');
                });
            } catch (\Throwable $e) {
                Log::error('Gagal mengirim email reset password: ' . $e->getMessage());
            }

            \App\Models\AuditLog::record('PASSWORD_RESET_REQUEST', 'auth', "Permintaan reset password untuk email: {$user->email}");
        }

        return back()->with('status', 'Jika email terdaftar di sistem kami, tautan pengaturan ulang kata sandi telah dikirimkan ke email Anda.');
    }

    public function resetPasswordForm(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email', ''),
        ]);
    }

    public function resetPasswordHandler(Request $request)
    {
        $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $record = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$record) {
            return back()->withErrors(['email' => 'Token reset password tidak ditemukan atau sudah digunakan.'])->withInput(['email' => $request->email]);
        }

        $createdAt = Carbon::parse($record->created_at);
        if ($createdAt->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'Token reset password telah kedaluwarsa (lebih dari 60 menit). Silakan ajukan permintaan ulang.']);
        }

        if (!Hash::check($request->token, $record->token)) {
            return back()->withErrors(['email' => 'Token reset password tidak valid.']);
        }

        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors(['email' => 'Akun pengguna tidak ditemukan.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        \App\Models\AuditLog::record('PASSWORD_RESET_SUCCESS', 'auth', "Berhasil mengatur ulang password akun: {$user->email}", (string) $user->id);

        return redirect()->route('login')->with('status', 'Kata sandi Anda berhasil diperbarui! Silakan login dengan kata sandi baru.');
    }
}
