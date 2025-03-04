<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\LoginLog;
use App\Models\News;
use App\Models\Offer;
use App\Models\Project;
use App\Models\ProjectFile;
use App\Models\Showcase;
use App\Models\Team;
use App\Models\Training;
use App\Models\Venue;
use Illuminate\Http\Request;
use MongoDB\Driver\Server;

class AdminDashboardController extends Controller
{
    public function index()
    {
       $loginLog = LoginLog::orderBy('last_login','desc')->get();
       $totalOffer = Offer::count();
       return view('admin.dashboard', compact('loginLog','totalOffer'));
    }

    public function unauthorized()
    {
        return view('admin.unauthorized');
    }





}
