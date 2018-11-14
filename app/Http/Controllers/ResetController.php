<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResetController extends Controller
{
    protected $pageSizes = [
        25,50,100,200,500
    ];

    public function __construct()
    {
        $this->middleware('auth');
    }

}
