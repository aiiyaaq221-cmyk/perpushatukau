<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    public function index()
    {
        return view('profil.index');
    }

    
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $user = Auth::user();

        if($request->hasFile('foto')){

            if($user->foto){
                Storage::disk('public')->delete($user->foto);
            }

            $path = $request->file('foto')
                ->store('profile','public');

            $user->foto = $path;
        }

        $user->name = $request->name;
        $user->email = $request->email;

        $user->save();

        return back()->with(
            'success',
            'Profil berhasil diperbarui.'
        );
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => 'required',
            'password_baru' => 'required|min:8|confirmed'
        ]);

        $user = Auth::user();

        if(!Hash::check(
            $request->password_lama,
            $user->password
        )){
            return back()->withErrors([
                'password_lama' => 'Password lama tidak sesuai.'
            ]);
        }

        $user->password = Hash::make(
            $request->password_baru
        );

        $user->save();

        return back()->with(
            'success',
            'Password berhasil diperbarui.'
        );
    }
}
