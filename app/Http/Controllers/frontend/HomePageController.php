<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
    public function index()
    {
        return inertia('IndexPage');
    }

    public function about()
    {
        return inertia('AboutPage');
    }

    public function offer()
    {
        return inertia('OfferPage');
    }

    public function contact()
    {
        return inertia('ContactPage');
    }
}
