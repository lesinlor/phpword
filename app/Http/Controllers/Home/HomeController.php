<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index(){
        return 'hello world';
    }


    public function table(){
        return 'hello asd';
    }
}
