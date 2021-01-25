<?php

namespace App\Http\Controllers;

use App\Models\Mode;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function menu()
    {
        return view('menu');
    }
}
