<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class CheckoutController extends BaseController
{
    public function index()
    {
        return view('checkout');
    }
}
