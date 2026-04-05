<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rfid;
use App\Models\RfidTag;
 use Carbon\Carbon;
 use App\Models\Tenant;

class RfidController extends Controller
{
   public function form(){
    $rfid = \App\Models\Rfid::latest()->first(); // ambil scan terakhir

    return view('rfid_form', compact('rfid'));
}
    public function storeWeb(Request $request)
    {
        Rfid::create([
            'kode' => $request->kode,
            'nama' => $request->nama
        ]);

        return redirect('/rfid/form')->with('success', 'Data berhasil disimpan');
    }


   

public function formTag()
{
    $rfid = \App\Models\Rfid::where('updated_at', '>=', now()->subMinute())
                ->orderBy('updated_at', 'desc')
                ->first();

    return view('rfid_tag_form', compact('rfid'));
}

public function storeTag(Request $request)
{
    // 🔍 cek apakah kode sudah ada
    $existing = RfidTag::where('kode', $request->kode)->first();

    if ($existing) {
        return back()->with('error', 
            'Kode sudah didaftarkan sebagai: ' . $existing->nama
        );
    }

    // ✅ simpan baru
    RfidTag::create([
        'kode' => strtoupper($request->kode),
        'nama' => $request->nama,
        'tenant_id' => auth()->user()->tenant_id
    ]);

    // 🔥 update rfids juga
    Rfid::where('kode', $request->kode)->update([
        'nama' => $request->nama
    ]);

    return back()->with('success', 'Tag berhasil disimpan');
}


public function scan(Request $request)
{
    $apiKey = $request->header('Authorization');

$tenant = Tenant::where('api_key', $apiKey)->first();
$kode = strtoupper($request->query('rfid'));

if (!$tenant) {
    return response()->json([
        'status' => 'error',
        'message' => 'API KEY tidak valid'
    ], 401);
}

$tenant_id = $tenant->id;
    //$kode = $request->query('rfid');
    $tag = RfidTag::where('kode', $kode)->first();

    // 🔥 validasi kosong
    if (!$kode) {
        return response()->json([
            'status' => 'error',
            'message' => 'RFID kosong'
        ]);
    }

    // 🔥 validasi format (HEX 24 karakter)
    if (!preg_match('/^[A-F0-9]{24}$/', $kode)) {
        return response()->json([
            'status' => 'error',
            'message' => 'UID tidak valid'
        ]);
    }

    $rfid = Rfid::where('kode', $kode)->first();

    if ($rfid) {

        $lastTime = Carbon::parse($rfid->updated_at);
        $now = Carbon::now();

        $diff = $lastTime->diffInSeconds($now);

        // 🔥 anti double scan
        if ($diff < 60) {
            $sisa = 60 - $diff;

            return response()->json([
                'kode' => $kode,
                'status' => $rfid->status,
                'message' => 'Tunggu ' . $sisa . ' detik lagi'
            ]);
        }

        // 🔥 toggle status
        $rfid->status = ($rfid->status == 'MASUK') ? 'KELUAR' : 'MASUK';

if ($tag) {
    $rfid->nama = $tag->nama;
}

$rfid->tenant_id = $tenant_id;

// 🔥 paksa update timestamp
$rfid->touch();
$rfid->updated_at = now();
$rfid->save();


    } else {

       $rfid = Rfid::create([
    'kode' => $kode,
    'nama' => $tag->nama ?? null,
    'status' => 'MASUK',
    'tenant_id' => $tenant_id
]);
    }

    return response()->json([
        'kode' => $kode,
        'status' => $rfid->status,
        'message' => 'Berhasil scan'
    ]);
}

public function formTagByKode($kode)
{
    return view('rfid_tag_form', compact('kode'));
}
}



