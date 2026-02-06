<?php

namespace App\Http\Controllers;
use App\Models\Disposisi;
use App\Models\SuratMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class InboxController extends Controller
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
        $user = Auth::user()->id;
        $disposisi = Disposisi::with('suratMasuk') // ini penting buat eager load
            ->where('user_id', $user)
            ->whereHas('suratMasuk', function ($query) {
                $query->where('status', 'didisposisi');
            })
            ->get();
        return view('inbox.index', compact('disposisi'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

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
        $suratMasuk = SuratMasuk::findOrFail($id);
        $suratMasuk->status = 'ditindaklanjuti';
        $suratMasuk->save();
        Alert::success('Berhasil DitindakLanjuti.');
        return redirect()->route('inbox.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function arsip()
    {
        $user = Auth::user()->id;
        $disposisi = Disposisi::with('suratMasuk') // ini penting buat eager load
            ->where('user_id', $user)
            ->whereHas('suratMasuk', function ($query) {
                $query->where('status', 'ditindaklanjuti');
            })
            ->get();
        return view('arsip.index', compact('disposisi'));
    }
}
