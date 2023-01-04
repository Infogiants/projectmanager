<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('id', 'desc')->paginate(4);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::orderBy('id', 'asc')->pluck('name', 'id');
        $user = new \stdClass();
        $user->allroles = $roles;
        return view('users.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'=> ['required', 'string', 'max:255'],
            'email'=> ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed']
        ]);

        if ($validator->fails()) {
            return redirect('users/create')->withErrors($validator)->withInput();
        }

        $user = new User([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password'))
        ]);
        $user->save();

        $user->roles()->sync(Role::whereIn('id', ($request['role_ids']) ?? [])->get());

        return redirect('/users')->with('success', 'User saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if ($user) {
            return view('users.view', compact('user'));
        } else {
            return redirect('/users')->with('errors', 'Invalid user to view!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        if ($user) {
            $roles = Role::orderBy('id', 'asc')->pluck('name', 'id');
            $user->allroles = $roles;
            return view('users.edit', compact('user'));
        } else {
            return redirect('/users')->with('errors', 'Invalid user to edit!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $validator = Validator::make($request->all(), [
            'name'=>'required|string|max:255',
            'email'=>'required|string|max:255|unique:users,email,'.$user->id
        ]);

        if ($validator->fails()) {
            return redirect('users/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        //Check existing password
        $currentPassword = $request->input('current_password');
        if (!empty($currentPassword) && !Hash::check($currentPassword, auth()->user()->password)) {
            return redirect('users/'.$id.'/edit')->with('errors', 'Invalid current password!')->withInput();
        }

        //new password
        $newPassword = $request->input('password');
        if (!empty($newPassword)) {
            $validator = Validator::make($request->all(), [
                'password' => ['required', 'string', 'min:8', 'confirmed']
            ]);

            if ($validator->fails()) {
                return redirect('users/'.$id.'/edit')->withErrors($validator)->withInput();
            }
        }

        $user->name =  $request->get('name');
        $user->email =  $request->get('email');
        if (!empty($newPassword)) {
            $user->password =  Hash::make($request->get('password'));
        }
        $user->save();

        $user->roles()->sync(Role::whereIn('id', ($request['role_ids']) ?? [])->get());

        return redirect('/users')->with('success', 'User updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Allow admin role to delete only
        if (!in_array('admin', Auth::user()->roles->pluck('slug')->toArray())):
            return redirect('/stores')->with('errors', 'Access denied!');
        endif;

        $user = User::find($id);
        if ($user) {
            $user->delete();
            return redirect('/users')->with('success', 'User deleted!');
        } else {
            return redirect('/users')->with('errors', 'Invalid user to delete!');
        }
    }
}
