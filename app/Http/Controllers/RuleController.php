<?php

namespace App\Http\Controllers;

use App\Rule;

class RuleController extends Controller
{
    public function index()
    { 
        sleep(1);
        $rules = Rule::with('penyakit', 'gejala')->get();
        return response()->json($rules->map(function($q){
            $q->bobot = strval($q->bobot);
            return $q;
        }));
    }

    public function requestShit()
    {
        return [
            'penyakit_code' => request('penyakit'),
            'gejala_code' => request('gejala'),
            'bobot' => request('bobot'),
        ];
    }

    public function store() {
        $rule = Rule::create($this->requestShit());
        return $rule;
    }

    public function show(Rule $rule)
    {
        return $rule;
    }

    public function update(Rule $rule)
    {
        $rule->update($this->requestShit());
        return response()->json(['message' => 'Rule was updated.']);
    }

    public function destroy(Rule $rule)
    {
        $rule->delete();
        return response()->json(['message' => 'Rule was deleted']);
    }
}
