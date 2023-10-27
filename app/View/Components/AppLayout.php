<?php

namespace App\View\Components;

use App\Models\TaGroup;
use App\Models\TmUnitkerja;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        $routename=Route::current()->getName();
        $data=[];
        if($routename=="usulan-tender"){
            //$data['tm_unitkerja']=(new TmUnitkerja())->getSortedUnitKerja();

        }
        return view('layouts.app',$data);
    }
}
