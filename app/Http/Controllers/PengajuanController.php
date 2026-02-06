<?php

namespace App\Http\Controllers;
use App\Models\PengajuanSurat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(Auth::user()->role == 'admin'){
            $pengajuan = PengajuanSurat::where('status', 'menunggu')->latest()->get();
            return view('pengajuan.index', compact('pengajuan'));
        } else {
            $pengajuan = PengajuanSurat::latest()->get();
            return view('pengajuan.index', compact('pengajuan'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = User::all();
        return view('pengajuan.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required',
            'tujuan' => 'required|string',
            'perihal' => 'required|string',
            'file_surat' => 'required',
        ]);

        $path = $request->file('file_surat')->store('pengajuan', 'public');
        $user_id = Auth::user()->id;
        $pengajuan = new PengajuanSurat();
        $pengajuan->file_surat = $path;
        $pengajuan->user_id = Auth::user()->id;
        $pengajuan->tujuan_surat = $request->tujuan;
        $pengajuan->perihal = $request->perihal;
        $pengajuan->status = 'menunggu';
        $pengajuan->save();

        return redirect()->route('pengajuan.index')->with('success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pengajuan = PengajuanSurat::findOrFail($id);
        $pengajuan->status = $request->status;   
        $pengajuan->save();
        toast('Berhasil mengupdate status', 'success');
        if(Auth::user()->role == 'admin'){
            $pengajuan = PengajuanSurat::where('status', 'menunggu')->latest()->get();
            return redirect()->route('admin.pengajuan.index');
        } else {
            $pengajuan = PengajuanSurat::latest()->get();
            return redirect()->route('pengajuan.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function download($id)
    {
        $surat = PengajuanSurat::findOrFail($id);

        // validasi: apakah user emang dapat disposisi surat ini
        $user_id = Auth::user()->id;
        $isAuthorized = PengajuanSurat::where('user_id', $user_id)->where('id', $id)->exists();

        if (!$isAuthorized) {
            abort(403, 'Lu bukan yang ditugasin, diem aja bro 💀');
        }

        return response()->download(storage_path('app/public/' . $surat->file_surat));
    }
}
