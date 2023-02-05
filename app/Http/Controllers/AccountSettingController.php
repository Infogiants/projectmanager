<?php

namespace App\Http\Controllers;

use App\User;
use App\Configuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class AccountSettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('role:admin');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $configurations = Configuration::all();
        if ($configurations) {
            return view('accountsettings.view', compact('configurations'));
        } else {
            return redirect('/')->with('errors', 'Invalid page to view!');
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

        dd($request->all());

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
