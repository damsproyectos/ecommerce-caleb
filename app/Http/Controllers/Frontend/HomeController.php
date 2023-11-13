<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('status', 1)->orderBy('serial', 'asc')->get();
        //dd($slider); *** Nos sirve para hacer pruebas de volcamiento de datos - simular la base de datos, comprobar el controlador ****
        return view('frontend.home.home',
            compact(
                'sliders'
            ));
    }
}
