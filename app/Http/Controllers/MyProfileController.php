<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class MyProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('role:admin,user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $user = User::find(Auth::user()->id);
        if ($user) {
            $roles = Role::orderBy('id', 'asc')->pluck('name', 'id');
            $user->allroles = $roles;
            return view('myprofile.view', compact('user'));
        } else {
            return redirect('/myprofile')->with('errors', 'Invalid user profile to view!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = User::find(Auth::user()->id);

        $validator = Validator::make($request->all(), [
            'name'=>'required|string|max:255',
            'email'=>'required|string|max:255|unique:users,email,'.$user->id
        ]);

        if ($validator->fails()) {
            return redirect('/myprofile')->withErrors($validator)->withInput();
        }

        //Check existing password
        $currentPassword = $request->input('current_password');
        if (!empty($currentPassword) && !Hash::check($currentPassword, auth()->user()->password)) {
            return redirect('/myprofile')->with('errors', 'Invalid current password!')->withInput();
        }

        //new password
        $newPassword = $request->input('password');
        if (!empty($newPassword)) {
            $validator = Validator::make($request->all(), [
                'password' => ['required', 'string', 'min:8', 'confirmed']
            ]);

            if ($validator->fails()) {
                return redirect('/myprofile')->withErrors($validator)->withInput();
            }
        }

        $user->name =  $request->get('name');
        $user->email =  $request->get('email');
        if (!empty($newPassword)) {
            $user->password =  Hash::make($request->get('password'));
        }
        $user->save();

        return redirect('/myprofile')->with('success', 'User profile updated successfully!');
    }
}
