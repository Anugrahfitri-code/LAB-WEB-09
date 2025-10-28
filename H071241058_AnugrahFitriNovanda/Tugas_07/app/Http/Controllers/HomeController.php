<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View; 

class HomeController extends Controller
{
    public function home(): View
    {
        return view('home'); 
    }

    public function destinasi(): View
    {
        return view('destinasi');
    }

    public function kuliner(): View
    {
        return view('kuliner'); 
    }

    public function galeri(): View
    {
        return view('galeri');
    }

    public function kontak(): View
    {
        return view('kontak'); 
    }

    public function agenda(): View
    {
        return view('agenda'); 
    }
}