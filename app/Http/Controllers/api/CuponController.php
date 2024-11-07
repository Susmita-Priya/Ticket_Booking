<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Cupon;
use Illuminate\Http\Request;

class CuponController extends Controller
{
    public function getinfo()
    {
       $cupons = Cupon::all();

        return response()->json([
            'message' => 'Check out cupons',
            'cupons' => $cupons, // Optionally return data
        ], 200);
    }
}
