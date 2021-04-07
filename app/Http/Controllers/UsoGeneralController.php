<?php

namespace App\Http\Controllers;

use App\Models\CatalogoGases;
use Illuminate\Http\Request;

class UsoGeneralController extends Controller
{
    
    public function catalogo_gases(){

        $gases=CatalogoGases::all();
        return $gases;
    }
}
