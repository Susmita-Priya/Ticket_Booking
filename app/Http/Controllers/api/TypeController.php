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
        $types = Type::all();

        if ($types->isEmpty()) {
            return response()->json([
                'message' => 'No types found.',
            ], 400);
        }else{

            foreach ($types as $type) {
                $type->company;
            }
            return response()->json([
                'message' => 'Check out types',
                'types' => $types, 
            ], 200);
        }
    }
}
