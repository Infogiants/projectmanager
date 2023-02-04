<?php

namespace App\Http\Controllers;

use App\ProjectEnvironment;
use App\Environment;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProjectEnvironmentController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $projectId = $request->get('project_id');
        $validator = Validator::make($request->all(), [
            'project_id' => 'required|'.Rule::in(Project::where('user_id', '=', Auth::user()->id)->pluck('id')->toArray()),
            'environment_id' => 'required|'.Rule::in(Environment::all()->pluck('id')->toArray()),
            'url'=> 'required|url|string|max:255',
            'username'=> 'required|string|max:255',
            'password'=> 'required|string|max:255',
            'summary' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('projects/'.$projectId)->withErrors($validator)->withInput();
        }

        $projectEnvironment = new ProjectEnvironment([
            'user_id' => Auth::user()->id,
            'project_id' => $request->get('project_id'),
            'environment_id' => $request->get('environment_id'),
            'url' => $request->get('url'),
            'username' => $request->get('username'),
            'password' => $request->get('password'),
            'summary' => $request->get('summary') ?? ''
        ]);
        $projectEnvironment->save();

        return redirect('projects/'.$projectId)->with('success', 'Environment Instance saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProjectEnvironment  $projectEnvironment
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectEnvironment $projectEnvironment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProjectEnvironment  $projectEnvironment
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectEnvironment $projectEnvironment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProjectEnvironment  $projectEnvironment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProjectEnvironment $projectEnvironment)
    {
        $projectEnvironment = ProjectEnvironment::find($projectEnvironment->id);
        $validator = Validator::make($request->all(), [
            'project_id' => 'required|'.Rule::in(Project::where('id', '<>', Auth::user()->id)->pluck('id')->toArray()),
            'environment_id' => 'required|'.Rule::in(Environment::all()->pluck('id')->toArray()),
            'url'=> 'required|url|string|max:255',
            'username'=> 'required|string|max:255',
            'password'=> 'required|string|max:255',
            'summary' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect('projects/'.$projectEnvironment->project_id)->withErrors($validator)->withInput();
        }

        $projectEnvironment->environment_id =  $request->get('environment_id');
        $projectEnvironment->url =  $request->get('url');
        $projectEnvironment->username = $request->get('username');
        $projectEnvironment->password = $request->get('password');
        $projectEnvironment->summary = $request->get('summary');
        $projectEnvironment->save();

        return redirect('/projects/'.$projectEnvironment->project_id)->with('success', 'Project Environment Instance updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProjectEnvironment  $projectEnvironment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $projectEnvironment = ProjectEnvironment::find($id);
        $projectId = $projectEnvironment->project_id;
        if ($projectEnvironment) {
            $projectEnvironment->delete();
            return redirect('projects/'.$projectId)->with('success', 'Project Environment Instance deleted!');
        } else {
            return redirect('projects/'.$projectId)->with('errors', 'Invalid Project Environment Instance to delete!');
        }
    }
}
