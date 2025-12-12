<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function showHomepage()
    {
        return "Chào mừng bạn đến với PHT Chương 6 - Laravel!";
    }
}
