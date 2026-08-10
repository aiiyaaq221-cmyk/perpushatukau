<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     * Tangani pendaftaran anggota sekaligus pembuatan akun.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'tanggal_lahir' => [
                'required',
                'date',
                'before:today',
            ],

            'jenis_kelamin' => [
                'required',
                'in:L,P',
            ],

            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users,email',
                'unique:anggotas,email',
            ],

            'no_telp' => [
                'required',
                'string',
                'digits_between:1,12',
                'regex:/^[0-9]+$/',
                'unique:anggotas,no_telp',
            ],

            'alamat' => [
                'required',
                'string',
                'max:500',
            ],

            'password' => [
                'required',
                'confirmed',
                Password::defaults(),
            ],
        ], [
            'nama.required' => 'Nama lengkap wajib diisi.',

            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Tanggal lahir tidak valid.',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini.',

            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid.',

            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',

            'no_telp.required' => 'Nomor telepon wajib diisi.',
            'no_telp.digits_between' => 'Nomor telepon maksimal 12 digit.',
            'no_telp.regex' => 'Nomor telepon hanya boleh berisi angka.',
            'no_telp.unique' => 'Nomor telepon sudah terdaftar.',

            'alamat.required' => 'Alamat wajib diisi.',

            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
        ]);

        DB::beginTransaction();

        try {

            /*
            |--------------------------------------------------------------------------
            | Generate kode anggota otomatis
            |--------------------------------------------------------------------------
            */

            $lastAnggota = Anggota::orderBy(
                'id_anggota',
                'desc'
            )->first();

            $nomorUrut = $lastAnggota
                ? (int) substr($lastAnggota->kode_anggota, 3) + 1
                : 1;

            $kodeAnggota = 'AGT' . str_pad(
                $nomorUrut,
                3,
                '0',
                STR_PAD_LEFT
            );

            /*
            |--------------------------------------------------------------------------
            | Buat data anggota
            |--------------------------------------------------------------------------
            */

            $anggota = Anggota::create([
                'kode_anggota' => $kodeAnggota,
                'nama' => ucwords(strtolower($request->nama)),
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'alamat' => ucwords(strtolower($request->alamat)),
                'no_telp' => $request->no_telp,
                'email' => $request->email,
                'tanggal_daftar' => now(),
                'status' => 'Aktif',
            ]);

            /*
            |--------------------------------------------------------------------------
            | Buat akun login
            |--------------------------------------------------------------------------
            */

            $user = User::create([
                'id_anggota' => $anggota->id_anggota,
                'name' => $anggota->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'user',
            ]);

            DB::commit();

            event(new Registered($user));

            return redirect()
                ->route('login')
                ->with(
                    'success',
                    'Registrasi berhasil! Nomor anggota Anda adalah ' .
                    $kodeAnggota .
                    '. Silakan login.'
                );

       } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->withErrors([
                    'email' => $e->getMessage(),
                ]);
        }
    }
}
