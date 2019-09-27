<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProxyController extends Controller
{

    public function index(Request $request)
    {
        sleep(1);
        dump(getallheaders());exit;
        dump($request);
    }
}
