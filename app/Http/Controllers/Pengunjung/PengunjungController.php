<?php

namespace App\Http\Controllers\Pengunjung;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Pengunjung;
use Illuminate\Http\Request;

class PengunjungController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengunjung::with('anggota');

        // Filter Nama
        if ($request->filled('nama')) {
            $query->where('nama', 'like', '%' . $request->nama . '%');
        }

        // Filter Tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_kunjungan', $request->tanggal);
        }

        // Filter Jenis Pengunjung
        if ($request->filled('status')) {

            if ($request->status == 'Anggota') {
                $query->where('jenis_pengunjung', 'anggota');
            }

            if ($request->status == 'Umum') {
                $query->where('jenis_pengunjung', 'non_anggota');
            }
        }

        $pengunjungs = $query
            ->latest()
            ->get();

        $totalPengunjung = Pengunjung::count();

        $pengunjungHariIni = Pengunjung::whereDate(
            'tanggal_kunjungan',
            today()
        )->count();

        $nonAnggota = Pengunjung::where(
            'jenis_pengunjung',
            'non_anggota'
        )->count();

        $anggotas = Anggota::where(
            'status',
            'Aktif'
        )->get();

        return view(
            'pengunjung.index',
            compact(
                'pengunjungs',
                'anggotas',
                'totalPengunjung',
                'pengunjungHariIni',
                'nonAnggota'
            )
        );
    }

    public function store(Request $request)
    {
        if ($request->jenis_pengunjung == 'anggota') {

            $anggota = Anggota::findOrFail(
                $request->id_anggota
            );

            Pengunjung::create([
                'id_anggota'         => $anggota->id_anggota,
                'jenis_pengunjung'   => 'anggota',
                'nama'               => ucfirst(strtolower(trim($anggota->nama))),
                'alamat'             => ucfirst(strtolower(trim($anggota->alamat))),
                'jenis_kelamin'      => $anggota->jenis_kelamin,

                // otomatis ambil status anggota
                'status_pengunjung'  => $anggota->status,
                'tujuan'             => ucfirst(strtolower(trim($request->tujuan))),
                'umur'               => $anggota->umur,
                'keterangan'         => $request->filled('keterangan')
                    ? ucfirst(strtolower(trim($request->keterangan)))
                    : null,
                'tanggal_kunjungan'  => now(),
            ]);

        } else {

            $request->validate([
                'nama'            => 'required',
                'alamat'          => 'required',
                'jenis_kelamin'   => 'required',
                'tujuan'          => 'required',
            ]);

            Pengunjung::create([
                'jenis_pengunjung'   => 'non_anggota',
                'nama'               => ucfirst(strtolower(trim($request->nama))),
                'alamat'             => ucfirst(strtolower(trim($request->alamat))),
                'umur'               => $request->umur,
                'jenis_kelamin'      => $request->jenis_kelamin,
                'status_pengunjung'  => $request->status_pengunjung,
                'tujuan'             => ucfirst(strtolower(trim($request->tujuan))),
                'keterangan'         => $request->filled('keterangan')
                    ? ucfirst(strtolower(trim($request->keterangan)))
                    : null,
                'tanggal_kunjungan'  => now(),
            ]);
        }

        return redirect()
            ->back()
            ->with(
                'success',
                'Data pengunjung berhasil ditambahkan.'
            );
    }

    public function update(Request $request, $id)
    {
        $pengunjung = Pengunjung::findOrFail($id);
        $request->validate([
            'nama' => 'required',
            'jenis_kelamin' => 'required|in:L,P',
            'tujuan' => 'required',
        ]);

        $pengunjung->update([
            'nama' => ucfirst(strtolower(trim($request->nama))),
            'jenis_kelamin' => $request->jenis_kelamin,
            'alamat' => ucfirst(strtolower(trim($request->alamat))),
            'tujuan' => ucfirst(strtolower(trim($request->tujuan))),
            'status_pengunjung' => $request->status_pengunjung,
            'keterangan' => $request->filled('keterangan')
                ? ucfirst(strtolower(trim($request->keterangan)))
                : null,
        ]);

        return redirect()
            ->back()
            ->with('success', 'Data pengunjung berhasil diperbarui.');
    }

    public function destroy($id)
    {
        try {
            $pengunjung = Pengunjung::findOrFail($id);
            $nama = $pengunjung->nama;
            $pengunjung->delete();
            return redirect()
                ->route('pengunjung.index')
                ->with('success', "Data pengunjung {$nama} telah berhasil dihapus.");

        } catch (\Exception $e) {
            return redirect()
                ->route('pengunjung.index')
                ->with('error', 'Data pengunjung gagal dihapus.');
        }
    }

}