<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function dashboard(): View
    {
        $data=[
            "title"=>"Dashboard"
        ];
        return view('app.dashboard',$data);
    }
}
