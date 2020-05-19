<?php

namespace App\Http\Controllers;

use App\Bobot;
use App\Http\Resources\BobotResource;
use Illuminate\Http\Request;

class BobotController extends Controller
{
    public function index()
    { 
        sleep(1);
        $bobots = Bobot::orderBy('keterangan', 'ASC')->get();
        return BobotResource::collection($bobots);
        
    }

    public function requestShit()
    {
        return [
            'keterangan' => request('keterangan'),
            'bobotuser' => request('bobotuser'),
        ];
    }

    public function store() {
        $bobot = Bobot::create($this->requestShit());
        return BobotResource::make($bobot);
    }

    public function show(Bobot $bobot)
    {
        return new BobotResource($bobot);
    }

    public function update(Bobot $bobot)
    {
        $bobot->update([
            'keterangan' => request('keterangan'),
            'bobotuser' => request('bobotuser'),
        ]);
        return response()->json(['message' => 'Bobot User was updated.']);
    }

    public function destroy(Bobot $bobot)
    {
        $bobot->delete();
        return response()->json(['message' => 'Bobot User was deleted']);
    }
}
