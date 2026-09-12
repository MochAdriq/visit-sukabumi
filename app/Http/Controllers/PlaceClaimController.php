<?php

namespace App\Http\Controllers;

use App\Models\Place;
use App\Models\PlaceClaim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PlaceClaimController extends Controller
{
    /**
     * Tampilkan form pengajuan klaim untuk sebuah tempat.
     */
    public function create(Place $place)
    {
        // Pastikan tempat belum diklaim oleh orang lain
        if ($place->is_claimed && $place->owner_id !== Auth::id()) {
            return redirect()->route('place.show', $place->slug)
                ->with('error', 'Destinasi ini sudah diklaim oleh pengelola lain.');
        }

        // Pastikan user belum punya klaim pending atau approved untuk tempat ini
        $existingClaim = Auth::user()->claims()
            ->where('place_id', $place->id)
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existingClaim) {
            return redirect()->route('profile.show')
                ->with('info', 'Anda sudah mengajukan klaim untuk destinasi ini.');
        }

        return view('profile.claim-form', compact('place'));
    }

    /**
     * Simpan pengajuan klaim.
     */
    public function store(Request $request)
    {
        $request->validate([
            'place_id'       => ['required', 'exists:places,id'],
            'applicant_phone'=> ['required', 'string', 'max:20'],
            'ktp'            => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:5120'],
            'surat'          => ['required', 'file', 'mimes:jpeg,png,jpg,pdf', 'max:10240'],
        ], [
            'ktp.required'   => 'Foto KTP wajib dilampirkan.',
            'surat.required' => 'Surat pengelola wajib dilampirkan.',
            'ktp.max'        => 'Ukuran foto KTP maksimal 5 MB.',
            'surat.max'      => 'Ukuran surat pengelola maksimal 10 MB.',
        ]);

        $place = Place::findOrFail($request->place_id);

        // Cegah duplikat pengajuan
        $existingClaim = Auth::user()->claims()
            ->where('place_id', $place->id)
            ->whereIn('status', ['pending', 'approved'])
            ->exists();

        if ($existingClaim) {
            return back()->with('error', 'Anda sudah memiliki pengajuan klaim aktif untuk destinasi ini.');
        }

        // Upload dokumen
        $ktpPath   = $request->file('ktp')->store('claims/ktp', 'public');
        $suratPath = $request->file('surat')->store('claims/surat', 'public');

        PlaceClaim::create([
            'user_id'        => Auth::id(),
            'place_id'       => $place->id,
            'applicant_phone'=> $request->applicant_phone,
            'ktp_path'       => $ktpPath,
            'surat_path'     => $suratPath,
            'status'         => 'pending',
        ]);

        return redirect()->route('profile.show')
            ->with('success', 'Pengajuan klaim Anda telah dikirim! Tim Visit Sukabumi akan meninjau berkas Anda dalam 1x24 jam.');
    }

    /**
     * Batalkan pengajuan klaim (hanya jika masih pending).
     */
    public function destroy(PlaceClaim $claim)
    {
        // Pastikan klaim milik user yang sedang login
        if ($claim->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!$claim->isPending()) {
            return back()->with('error', 'Hanya klaim dengan status menunggu yang bisa dibatalkan.');
        }

        // Hapus file dokumen
        Storage::disk('public')->delete([$claim->ktp_path, $claim->surat_path]);

        $claim->delete();

        return redirect()->route('profile.show')
            ->with('success', 'Pengajuan klaim berhasil dibatalkan.');
    }
}
