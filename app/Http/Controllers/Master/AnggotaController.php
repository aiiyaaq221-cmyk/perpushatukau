<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AnggotaController extends Controller
{
    public function index(Request $request)
    {
        $query = Anggota::query();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where(
                    'nama',
                    'like',
                    '%' . $request->search . '%'
                )
                ->orWhere(
                    'kode_anggota',
                    'like',
                    '%' . $request->search . '%'
                );
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        $anggotas = $query
            ->orderBy('kode_anggota', 'asc')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'master.anggota.index',
            compact('anggotas')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'           => 'required',
            'tanggal_lahir'  => 'required|date',
            'jenis_kelamin'  => 'required',
            'alamat'         => 'required',
            'tanggal_daftar' => 'required',
            'kode_anggota'   => 'nullable|unique:anggotas,kode_anggota',
            'email'          => 'nullable|email|unique:anggotas,email',
            'no_telp'        => 'nullable|digits_between:1,12|regex:/^[0-9]+$/|unique:anggotas,no_telp',
            'status'         => 'required',
        ], [
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date'     => 'Format tanggal lahir tidak valid.',
            'email.unique'           => 'Email sudah terdaftar.',
            'no_telp.unique'         => 'Nomor telepon sudah terdaftar.',
            'no_telp.regex'          => 'Nomor telepon hanya boleh berisi angka.',
        ]);

        try {

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

            Anggota::create([
                'kode_anggota'   => $kodeAnggota,
                'nama'           => Str::title(strtolower($request->nama)),
                'tanggal_lahir'  => $request->tanggal_lahir,
                'jenis_kelamin'  => $request->jenis_kelamin,
                'alamat'         => Str::title(strtolower($request->alamat)),
                'no_telp'        => $request->no_telp,
                'email'          => $request->email,
                'tanggal_daftar' => $request->tanggal_daftar,
                'status'         => $request->status,
            ]);

            return redirect()
                ->back()
                ->with(
                    'success',
                    'Data anggota berhasil ditambahkan.'
                );

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Terjadi kesalahan saat menambahkan data anggota.'
                );
        }
    }

    public function update(Request $request, $id)
    {
        $anggota = Anggota::findOrFail($id);

        $request->validate([
            'nama'           => 'required',
            'tanggal_lahir'  => 'required|date',
            'jenis_kelamin'  => 'required',
            'alamat'         => 'required',
            'tanggal_daftar' => 'required',
            'kode_anggota'   => 'nullable|unique:anggotas,kode_anggota,' . $id . ',id_anggota',
            'email'          => 'nullable|email|unique:anggotas,email,' . $id . ',id_anggota',
            'no_telp'        => 'nullable|digits_between:1,12|regex:/^[0-9]+$/|unique:anggotas,no_telp,' . $id . ',id_anggota',
            'status'         => 'required',
        ], [
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date'     => 'Format tanggal lahir tidak valid.',
            'email.unique'           => 'Email sudah terdaftar.',
            'no_telp.unique'         => 'Nomor telepon sudah terdaftar.',
            'no_telp.regex'          => 'Nomor telepon hanya boleh berisi angka.',
        ]);

        $anggota->update([
            'nama'           => Str::title(strtolower($request->nama)),
            'tanggal_lahir'  => $request->tanggal_lahir,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'alamat'         => Str::title(strtolower($request->alamat)),
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
            ->with(
                'success',
                'Data anggota berhasil dihapus'
            );
    }
}