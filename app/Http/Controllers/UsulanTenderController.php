<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class UsulanTenderController extends Controller
{
    public function index():View{
        $data=[
            "title"=>"Usulan Tender"
        ];
        return view('app.usulantender',$data);
    }
}
