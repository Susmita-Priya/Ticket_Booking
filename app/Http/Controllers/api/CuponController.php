<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Cupon;
use Illuminate\Http\Request;

class CuponController extends Controller
{
    public function cupon()
    {
       $cupons = Cupon::all();

        if ($cupons->isEmpty()) {
            return response()->json([
                'error' => 'No cupons found.',
            ], 400);
        }else{

        return response()->json([
            'message' => 'Check out cupons',
            'cupons' => $cupons, // Optionally return data
        ], 200);
    }
    }
}
