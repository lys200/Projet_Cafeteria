<?php

namespace App\Http\Controllers;
use App\Models\Plat;
use App\Models\Client;
use App\Models\Ventes;


use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function index()
    {
        $plats = Plat::where('disponible_jour', true)->get();
        
        return view('pages.home', compact('plats'));
    }
}
