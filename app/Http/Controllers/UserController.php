<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        if (Auth::user()->hasRole('Super Admin')) {
            $data = User::latest()->get();
        } elseif (Auth::user()->hasRole('Company')) {
            $data = User::where('id', Auth::user()->id)
                        ->orWhere('is_registration_by', Auth::user()->id)
                        ->latest()->get();
        } elseif (Auth::user()->hasRole('User')) {
            $data = User::where('id', Auth::user()->id)
                        ->orWhere('id', Auth::user()->is_registration_by)
                        ->latest()->get();
        } else {
            $data = collect(); // Empty collection if no roles match
        }

        return view('users.index',compact('data'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function create(): View
    {
        if (Auth::user()->hasRole('Super Admin')) {
            $roles = Role::pluck('name', 'name')->all();
        } elseif (Auth::user()->hasRole('Company')) {
            $roles = Role::where('name', 'User')->pluck('name', 'name')->all();
        } else {
            $roles = [];
        }
        // $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['is_registration_by'] = Auth::user()->id;
        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success','User created successfully');
    }

    public function show($id): View
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }

    public function fetch($id)
{
    $user = User::find($id);
    if ($user) {
        return response()->json(['username' => $user->name]); // Return username or other data
    }
    return response()->json(['error' => 'User not found'], 404);
}

    public function edit($id): View
    {
        $user = User::find($id);
        if (Auth::user()->hasRole('Super Admin')) {
            $roles = Role::pluck('name', 'name')->all();
        } elseif (Auth::user()->hasRole('Company')) {
            $roles = Role::where('name', 'User')->pluck('name', 'name')->all();
        } else {
            $roles = [];
        }
        // $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();

        return view('users.edit',compact('user','roles','userRole'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if(!empty($input['password'])){
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = Arr::except($input,array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success','User updated successfully');
    }

    public function destroy($id): RedirectResponse
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success','User deleted successfully');
    }

}
