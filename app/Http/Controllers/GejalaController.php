<?php

namespace App\Http\Controllers;

use App\Gejala;
use App\Http\Resources\GejalaResource;
use App\User;

use Illuminate\Http\Request;

class GejalaController extends Controller
{
    public function index()
    { 
        sleep(1);
        $gejalas = Gejala::orderBy('kode', 'ASC')->get();
        return GejalaResource::collection($gejalas);
    }

    public function requestShit()
    {
        return [
            'kode' => request('kode'),
            'nama' => request('nama'),
            'bobot' => request('bobot'),
        ];
    }

    public function store() {
        $gejala = Gejala::create($this->requestShit());
        return GejalaResource::make($gejala);
    }

    public function show(Gejala $gejala)
    {
        return new GejalaResource($gejala);
    }

    public function update(Gejala $gejala)
    {
        $gejala->update([
            'kode' => request('kode'),
            'nama' => request('nama'),
            'bobot' => request('bobot'),
        ]);
        return response()->json(['message' => 'Gejala was updated.']);
    }

    public function destroy(Gejala $gejala)
    {
        $gejala->delete();
        return response()->json(['message' => 'Gejala was deleted']);
    }
}
