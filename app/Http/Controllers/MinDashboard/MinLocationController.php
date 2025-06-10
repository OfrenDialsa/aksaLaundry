<?php

namespace App\Http\Controllers\MinDashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MinLocationController extends Controller
{
    public function index()
    {
        return view('mindashboard.location.index');
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