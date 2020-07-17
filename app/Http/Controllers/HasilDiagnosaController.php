<?php

namespace App\Http\Controllers;

use App\Gejala;
use App\HasilDiagnosa;

class HasilDiagnosaController extends Controller
{
    public function store(){
        $hasil = "babi";
        HasilDiagnosa::create([
            'gejala' => json_encode(request()->gejala),
            'nama' => request()->nama,
            'jenis_kelamin' => request()->jenisKelamin,
            'hasil' => $hasil,
        ]);
        $result = [
            'nama' => request()->nama,
            'jenisKelamin' => request()->jenisKelamin,
            'hasil' => $hasil,
        ];
        return response()->json($result);
    }
}
