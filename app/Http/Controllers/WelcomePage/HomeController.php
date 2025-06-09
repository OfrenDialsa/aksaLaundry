<?php

namespace App\Http\Controllers\WelcomePage;

class HomeController 
{
    public function index()
    {
        return view('welcome.home');
    }
}