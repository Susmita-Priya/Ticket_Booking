<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Passenger;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class PassengerController extends Controller
{
    public function storePassenger(Request $request)
    {

        // Validate input
        $this->validate($request, [
            'plane_id' => 'required',
            'passenger_name' => 'required|string|max:255',
            'passenger_age' => 'required|string|max:15',
       
        ]);
        $user = auth()->user()->id;

        try {
            // Create a new passenger
            $passenger = new Passenger();
            $passenger->user_id = $user;
            $passenger->plane_id = $request->plane_id;
            $passenger->passenger_name = $request->passenger_name;
            $passenger->passenger_age = $request->passenger_age;

            if ($request->hasfile('passport')) {
                $file = $request->file('passport');
                $filename = time() . '_passport.' . $file->getClientOriginalExtension();
                $path = 'uploads/passports';
                $file->move(public_path($path), $filename); // Move to 'public/uploads/images' directly
                $fullPath = $path . '/' . $filename;
                $passenger->passport = $fullPath;
            } else {
                $passenger->passport = null;
            }

            $passenger->save();
            return response()->json(['message' => 'Passenger created successfully'], 201);
        } catch (QueryException $e) {
            return response()->json(['message' => 'Failed to create passenger', 'error' => $e->errorInfo], 409);
        }
    }
}
