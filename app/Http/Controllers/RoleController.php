<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use App\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RoleController extends Controller
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
        $roles = Role::orderBy('id', 'desc')->paginate(4);
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $permissions = Permission::orderBy('id', 'asc')->pluck('name', 'id');
        $role = new \stdClass();
        $role->allpermissions = $permissions;
        return view('roles.create', compact('role'));
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
            'name'=> ['required', 'string', 'max:255', 'unique:roles']
        ]);

        if ($validator->fails()) {
            return redirect('roles/create')->withErrors($validator)->withInput();
        }

        $role = new Role([
            'name' => $request->get('name'),
            'slug' => Str::slug($request->get('name'), '-')
        ]);
        $role->save();
        
        $role->permissions()->sync(Permission::whereIn('id', ($request['permission_ids']) ?? [])->get());
        
        return redirect('/roles')->with('success', 'Role saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        if ($role) {
            $permissions = Permission::orderBy('id', 'asc')->pluck('name', 'id');
            $role->allpermissions = $permissions;
            return view('roles.edit', compact('role'));   
        } else {
            return redirect('/roles')->with('errors', 'Invalid role to edit!');
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
        $role = Role::find($id);
        $validator = Validator::make($request->all(), [
            'name'=>'required|string|max:255|unique:roles,slug,'.$role->id
        ]);

        if ($validator->fails()) {
            return redirect('roles/'.$id.'/edit')->withErrors($validator)->withInput();
        }
        
        $role->name =  $request->get('name');
        $role->slug = strtolower($request->get('name'));
        $role->save();
        
        $role->permissions()->sync(Permission::whereIn('id', ($request['permission_ids']) ?? [])->get());
        
        return redirect('/roles')->with('success', 'Role updated!');
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
        
        $role = Role::find($id);
        if ($role) {
            $role->delete();
            return redirect('/roles')->with('success', 'Role deleted!');  
        } else {
            return redirect('/roles')->with('errors', 'Invalid role to delete!');
        }
    }
}
