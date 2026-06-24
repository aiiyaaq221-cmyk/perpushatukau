<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggotas = Anggota::latest()->get();

        $totalAnggota = Anggota::count();

        $anggotaAktif = Anggota::where(
            'status',
            'Aktif'
        )->count();

        return view(
            'master.anggota.index',
            compact(
                'anggotas',
                'totalAnggota',
                'anggotaAktif'
            ));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama'            => 'required',
            'jenis_kelamin'   => 'required',
            'umur'            => 'required',
            'alamat'          => 'required',
            'tanggal_daftar'  => 'required',
            'kode_anggota'    => 'nullable|unique:anggotas,kode_anggota',
            'no_telp'         => 'nullable',
            'email'           => 'nullable|email',
            'status'          => 'required',
        ]);

        Anggota::create([
            'kode_anggota'   => $request->kode_anggota,
            'nama'           => $request->nama,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'umur'           => $request->umur,
            'alamat'         => $request->alamat,
            'no_telp'        => $request->no_telp,
            'email'          => $request->email,
            'tanggal_daftar' => $request->tanggal_daftar,
            'status'         => $request->status,
        ]);

        return redirect()
            ->back()
            ->with(
                'success',
                'Data anggota berhasil ditambahkan'
            );
    }

    public function update(Request $request, $id)
    {
        $anggota = Anggota::findOrFail($id);

        $request->validate([
            'nama'           => 'required',
            'jenis_kelamin'  => 'required',
            'umur'           => 'required',
            'alamat'         => 'required',
            'tanggal_daftar' => 'required',
            'status'         => 'required',

            'kode_anggota'   => 'nullable|unique:anggotas,kode_anggota,' . $id . ',id_anggota',
            'no_telp'        => 'nullable',
            'email'          => 'nullable|email',
        ]);

        $anggota->update([
            'kode_anggota'   => $request->kode_anggota,
            'nama'           => $request->nama,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'umur'           => $request->umur,
            'alamat'         => $request->alamat,
            'no_telp'        => $request->no_telp,
            'email'          => $request->email,
            'tanggal_daftar' => $request->tanggal_daftar,
            'status'         => $request->status,
        ]);

        return redirect()
            ->back()
            ->with(
                'success',
                'Data anggota berhasil diperbarui'
            );
    }


    public function destroy($id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->delete();

        return redirect()
            ->back()
            ->with('success', 'Data anggota berhasil dihapus');
    }
}