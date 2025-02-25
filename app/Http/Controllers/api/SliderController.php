<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function index()
    {
        try {
            $slider = Slider::latest()->get();
            if($slider->isEmpty()){
                return response()->json(['message' => 'No slider found.'], 400);
            }else{
                return response()->json(['message' => 'Check out slider', 'slider' => $slider], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}
