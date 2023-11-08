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
        if (in_array($routename, 
            [
                "new-usulan-tender", 
                "new-usulan-tender-seleksi",
                "new-usulan-tender-dikecualikan",
                "edit-usulan-tender",
                "edit-usulan-tender-seleksi",
                "edit-usulan-tender-dikecualikan",
            ]
        )) {
            $data['btn_save_usulan']=true;
        }
        return view('layouts.app',$data);
    }
}
