<?php

namespace App\Http\Controllers;

use App\Http\Resources\PenyakitResource;
use App\Penyakit;
use App\User;

use Illuminate\Http\Request;

class PenyakitController extends Controller
{
    public function index()
    { 
        sleep(1);
        $penyakits = Penyakit::orderBy('kode', 'ASC')->get();
        return PenyakitResource::collection($penyakits);
    }

    public function requestShit()
    {
        return [
            'kode' => request('kode'),
            'nama' => request('nama'),
        ];
    }

    public function store() {
        $penyakit = Penyakit::create($this->requestShit());
        return PenyakitResource::make($penyakit);
    }

    public function show(Penyakit $penyakit)
    {
        return new PenyakitResource($penyakit);
    }

    public function update(Penyakit $penyakit)
    {
        $penyakit->update([
            'kode' => request('kode'),
            'nama' => request('nama'),
        ]);
        return response()->json(['message' => 'Penyakit was updated.']);
    }

    public function destroy(Penyakit $penyakit)
    {
        $penyakit->delete();
        return response()->json(['message' => 'Penyakit was deleted']);
    }
}
