<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResetController extends Controller
{
    protected $pageSizes = [
        25,50,100,200,500
    ];


    protected $ableStatus = [
       'enable' => [
          'name' => '启用',
          'class' => 'text-navy',
       ],
       'disable' => [
           'name' => '禁用',
           'class' => 'text-danger'
       ]
    ];


    public function __construct()
    {
        $this->middleware('auth');
    }

}
