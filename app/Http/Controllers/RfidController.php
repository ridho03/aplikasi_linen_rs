<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rfid;
use App\Models\RfidTag;
use App\Models\Tenant;
use Carbon\Carbon;

class RfidController extends Controller
{
    // =========================
    // 📋 FORM LABEL
    // =========================
    public function formTag()
{
    $rfid = Rfid::whereNull('nama')
                ->latest()
                ->first();

    return view('rfid_tag_form', compact('rfid'));
}

    // =========================
    // 💾 SIMPAN LABEL
    // =========================
//     public function storeTag(Request $request)
// {
//     $request->validate([
//         'kode' => 'required',
//         'nama' => 'required'
//     ]);

//     $kode = strtoupper(trim($request->kode));

//     // 🔥 🔥 INI KUNCI (PAKAI KONSEP 1)
//     Rfid::where('kode', $kode)
//         ->update([
//             'nama' => $request->nama
//         ]);

//     // 🔥 ambil terakhir (optional biar konsisten UI kamu)
//     $rfid = Rfid::where('kode', $kode)->latest()->first();

//     if ($rfid) {
//         $rfid->update([
//             'nama' => $request->nama
//         ]);
//     }

//     // 🔥 simpan / update master
//     RfidTag::updateOrCreate(
//         ['kode' => $kode],
//         [
//             'nama' => $request->nama,
//             'tenant_id' => auth()->user()->tenant_id
//         ]
//     );

//     return back()->with('success', 'Label berhasil disimpan & sinkron');
// }

public function storeTag(Request $request)
{
    $request->validate([
        'kode' => 'required',
        'nama' => 'required'
    ]);

    $kode = trim($request->kode);

    // 🔥 SUPER FIX (ANTI CASE SENSITIVE)
    $updated = Rfid::whereRaw('LOWER(kode) = ?', [strtolower($kode)])
        ->update([
            'nama' => $request->nama
        ]);

    if ($updated == 0) {
        return back()->with('error', 'RFID tidak ditemukan di database');
    }

    // 🔥 master
    RfidTag::updateOrCreate(
        ['kode' => strtoupper($kode)],
        [
            'nama' => $request->nama,
            'tenant_id' => auth()->user()->tenant_id
        ]
    );

    return back()->with('success', 'Label berhasil & nama sudah masuk');
}

    // =========================
    // 📡 SCAN
    // =========================
public function scan(Request $request)
{
    try {

        $apiKey = $request->header('Authorization');
        $tenant = Tenant::where('api_key', $apiKey)->first();

        if (!$tenant) {
            return response()->json([
                'status' => 'error',
                'message' => 'API KEY tidak valid'
            ], 401);
        }

        $kode = strtoupper($request->query('rfid'));

        if (!$kode) {
            return response()->json([
                'status' => 'error',
                'message' => 'RFID kosong'
            ]);
        }

        $tenant_id = $tenant->id;

        // 🔍 cek label
        $tag = RfidTag::where('kode', $kode)->first();

        // =========================
        // 🔴 BELUM LABEL
        // =========================
        if (!$tag) {

            // hanya buat 1 pending
            $pending = Rfid::where('kode', $kode)->first();

            if (!$pending) {
                Rfid::create([
                    'kode' => $kode,
                    'nama' => null,
                    'status' => 'PENDING',
                    'tenant_id' => $tenant_id
                ]);
            }

            return response()->json([
                'kode' => $kode,
                'status' => 'PENDING',
                'message' => 'RFID belum dilabel'
            ]);
        }

        // =========================
        // 🟢 SUDAH LABEL
        // =========================
        $rfid = Rfid::where('kode', $kode)->first();

        // 🔥 kalau belum ada → buat
        if (!$rfid) {
            Rfid::create([
                'kode' => $kode,
                'nama' => $tag->nama,
                'status' => 'MASUK',
                'tenant_id' => $tenant_id,
                'waktu_masuk' => now()
            ]);

            return response()->json([
                'kode' => $kode,
                'status' => 'MASUK',
                'message' => 'Scan pertama'
            ]);
        }

        // 🔥 delay 60 detik
        $diff = Carbon::parse($rfid->updated_at)->diffInSeconds(now());

        if ($diff < 60) {
            return response()->json([
                'kode' => $kode,
                'status' => $rfid->status,
                'message' => 'Tunggu ' . (60 - $diff) . ' detik'
            ]);
        }

        // 🔄 toggle status
        // 🔄 toggle status
        $status = ($rfid->status == 'MASUK') ? 'KELUAR' : 'MASUK';

        $dataUpdate = [
            'status' => $status,
            'nama' => $tag->nama,
        ];

        if ($status === 'MASUK') {
            $dataUpdate['waktu_masuk'] = now();
            $dataUpdate['waktu_keluar'] = null; // 🔥 RESET
        } else {
            $dataUpdate['waktu_keluar'] = now();
        }

        $rfid->update($dataUpdate);

        return response()->json([
            'kode' => $kode,
            'status' => $status,
            'message' => 'Scan berhasil'
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
}

    // =========================
    // 🔄 REALTIME UID
    // =========================
    public function getLatestRfid()
{
    $rfid = Rfid::whereNull('nama') // 🔥 belum dilabel
                ->latest()
                ->first();

    return response()->json([
        'kode' => $rfid->kode ?? null
    ]);
}

public function realtime()
{
    $data = \App\Models\Rfid::latest()->take(10)->get();

    return response()->json($data);
}

}