<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        return view('dashboard.location.index');
    }

    // public function create()
    // {
    //     return view('dashboard.orders.create');
    // }

    // public function store(Request $request)
    // {
    //     // Validate and save
    // }

    // Add more methods as needed (edit, update, destroy...)
}