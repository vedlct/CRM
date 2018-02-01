<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    public function __construct()
    {
        //its just a dummy data object.
        $sharing ="I am Sharing";

        // Sharing is caring
        View::share('sharing', $sharing);
    }
}
