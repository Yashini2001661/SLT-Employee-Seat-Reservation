<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DateController extends Controller
{
    public function GotoDate()
    {
        return view('date');
    }
}
