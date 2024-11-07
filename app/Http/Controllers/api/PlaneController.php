<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Plane;
use Illuminate\Http\Request;

class PlaneController extends Controller
{
    public function getinfo()
    {
       $planes = Plane::all();

        return response()->json([
            'message' => 'Check out Planes',
            'planes' => $planes, // Optionally return data
        ], 200);
    }
}
