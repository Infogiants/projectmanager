<?php

namespace App\Http\Controllers;

use App\Environment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class EnvironmentController extends Controller
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
        if(in_array('admin', Auth::user()->roles->pluck('slug')->toArray())):
            $environments = Environment::orderBy('id', 'desc')->paginate(4);
        else:
            $environments = Environment::where('user_id', Auth::user()->id)->orderByDesc('id')->paginate(4);
        endif;
        return view('environments.index', compact('environments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('environments.create');
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
            'name'=> 'required|string|max:255|unique:environments,name',
            'summary' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('environments/create')->withErrors($validator)->withInput();
        }

        $environment = new Environment([
            'user_id' => Auth::user()->id,
            'name' => $request->get('name'),
            'summary' => $request->get('summary') ?? ''
        ]);
        $environment->save();

        return redirect('/environments')->with('success', 'Environment saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Environment  $environment
     * @return \Illuminate\Http\Response
     */
    public function show(Environment $environment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Environment  $environment
     * @return \Illuminate\Http\Response
     */
    public function edit(Environment $environment)
    {
        $environment = Environment::find($id);
        if ($environment) {
            return view('environments.edit', compact('environment'));
        } else {
            return redirect('/environments')->with('errors', 'Invalid environment to edit!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Environment  $environment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Environment $environment)
    {
        $environment = Environment::find($id);
        $validator = Validator::make($request->all(), [
            'name'=> 'required|string|max:255|unique:environments,name,'.$environment->id,
            'summary' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect('environments/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        $environment->name =  $request->get('name');
        $environment->summary = $request->get('summary') ?? '';
        $environment->save();

        return redirect('/environments')->with('success', 'Environment updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Environment  $environment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $environment = Environment::find($id);
        if ($environment) {
            $environment->delete();
            return redirect('/environments')->with('success', 'Environment deleted!');
        } else {
            return redirect('/environments')->with('errors', 'Invalid environment to delete!');
        }
    }
}
