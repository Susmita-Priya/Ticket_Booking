<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    //
    public function type()
    {
        $user_id = auth()->user()->id;
        $types = Type::where('company_id', $user_id)->get();

        if ($types->isEmpty()) {
            return response()->json([
                'message' => 'No types found.',
            ], 400);
        }else{
            return response()->json([
                'message' => 'Check out types',
                'types' => $types, 
            ], 200);
        }
    }
}
