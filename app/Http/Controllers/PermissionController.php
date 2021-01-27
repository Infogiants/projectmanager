<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PermissionController extends Controller
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
        $permissions = Permission::orderBy('id', 'desc')->paginate(4);
        return view('permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permissions.create');
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
            'name'=> ['required', 'string', 'max:255', 'unique:permissions']
        ]);

        if ($validator->fails()) {
            return redirect('permissions/create')->withErrors($validator)->withInput();
        }

        $permission = new Permission([
            'name' => $request->get('name'),
            'slug' => Str::slug($request->get('name'), '-')
        ]);
        $permission->save();
        return redirect('/permissions')->with('success', 'Permission saved!');
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
        $permission = Permission::find($id);
        if ($permission) {
            return view('permissions.edit', compact('permission'));   
        } else {
            return redirect('/permissions')->with('errors', 'Invalid permission to edit!');
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
        $permission = Permission::find($id);
        $validator = Validator::make($request->all(), [
            'name'=>'required|string|max:255|unique:permissions,slug,'.$permission->id
        ]);

        if ($validator->fails()) {
            return redirect('permissions/'.$id.'/edit')->withErrors($validator)->withInput();
        }
        
        $permission->name =  $request->get('name');
        $permission->slug = strtolower($request->get('name'));
        $permission->save();
        return redirect('/permissions')->with('success', 'Permission updated!');
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
        
        $permission = Permission::find($id);
        if ($permission) {
            $permission->delete();
            return redirect('/permissions')->with('success', 'Permission deleted!');  
        } else {
            return redirect('/permissions')->with('errors', 'Invalid permission to delete!');
        }
    }
}
