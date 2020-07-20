<?php

namespace App\Http\Controllers;

use App\Gejala;
use App\HasilDiagnosa;
use App\Penyakit;
use Illuminate\Auth\EloquentUserProvider;

class HasilDiagnosaController extends Controller
{
    public function store(){
        $gejalaValue = collect(request()->gejala);
        $gejalas = Gejala::orderBy('kode','asc')->get();
        $gejalaYangDipilih = [];
        $hasil = "";
        
        foreach($gejalaValue as $key => $value){
            if($value == 'true'){
                $gejalaYangDipilih[] = $gejalas[$key];
            }
        }

        $gejalaYangDipilih = collect($gejalaYangDipilih);

        $penyakits = Penyakit::with(['rules' => function($rules) use ($gejalaYangDipilih){
            $rules->whereIn('gejala_code', $gejalaYangDipilih->pluck('kode'));
        }])->get()->map(function($penyakit){
            $rules = $penyakit->rules;
            $gCount = count($rules);
            $hasil = 0;
            if($gCount < 1){
                $hasil = 0;
            }else if($gCount == 1){
                $bobot = $rules[0]->bobot;
                $hasil = round($bobot * ( 1 - (0.6) ),3);
            }else if($gCount == 2){
                $hasil = 0;
                $b1 = $rules[0]->bobot;
                $b2 = $rules[1]->bobot;
                $hasil = round($b1 + $b2 * (1 - (0.6)),3);
            }else if($gCount > 2){
                $hasil = 0;
                foreach($rules as $ruleKey => $ruleValue){
                    $bobot = $ruleValue->bobot;
                    if($ruleKey == 0){
                        $hasil = $bobot + $rules[1]->bobot * (1 - (0.6));
                    }else if($ruleKey > 1){
                        $hasil = $hasil + $bobot * (1 - $hasil);
                    }
                }
            }
            $penyakit->hasil = $hasil;
            return $penyakit;
        });

        $result = $penyakits->sortByDesc('hasil')->values()->first();

        $interpretasi = "";
        if($result->hasil >=  1){
            $interpretasi = "Pasti";
        }else if($result->hasil >=  0.8){
            $interpretasi = "Hampir Pasti";
        }else if($result->hasil >=  0.6){
            $interpretasi = "Kemungkinan Besar";
        }else if($result->hasil >=  0.4){
            $interpretasi = "Mungkin";
        }else if($result->hasil >=  0.2){
            $interpretasi = "Tidak Tahu";
        }else if($result->hasil >=  -0.4){
            $interpretasi = "Mungkin Tidak";
        }else if($result->hasil >=  -0.6){
            $interpretasi = "Kemungkinan Besar Tidak";
        }else if($result->hasil >=  -0.8){
            $interpretasi = "Hampir Pasti Tidak";
        }else if($result->hasil >= -1){
            $interpretasi = "Pasti Tidak";
        }else {
            $interpretasi = "";
        }

        HasilDiagnosa::create([
            'gejala' => json_encode($gejalaYangDipilih->pluck('kode')),
            'nama' => request()->nama,
            'jenis_kelamin' => request()->jenisKelamin,
            'hasil' => $result->hasil,
        ]);

        $response = [
            'nama' => request()->nama,
            'jenisKelamin' => request()->jenisKelamin,
            'hasil' => "Berdasarkan proses perhitungan yang telah dilakukan dengan metode Certainty Factor dapat disimpulkan bahwa penderita mengalami penyakit ".$result->nama." dengan nilai CF ".$result->hasil." atau ".($result->hasil * 100)." % $interpretasi.",
        ];

        return response()->json($response);
    }
}
