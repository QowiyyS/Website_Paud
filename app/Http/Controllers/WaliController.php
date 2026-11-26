<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaliController extends Controller
{
    /**
     * Dashboard Utama Wali Murid.
     */
    public function index()
    {
        /** @var \App\Models\Pengguna $wali */
        $wali = Auth::user();
        $anakList = $wali->anak()->with(['rapor' => function ($query) {
            $query->with('periode')->latest('id_rapor');
        }])->get();

        return view('wali.dashboard', compact('wali', 'anakList'));
    }
}
