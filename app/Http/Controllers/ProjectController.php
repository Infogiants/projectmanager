<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use App\Category;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Storage;

class ProjectController extends Controller
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
        $this->status = ['0', '1'];
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(in_array('admin', Auth::user()->roles->pluck('slug')->toArray())):
            $projects = Project::orderByDesc('id')->paginate(4);
            $all = Project::all()->count();
            $inprogress = Project::where('project_status', '1')->count();
            $completed = Project::where('project_status', '0')->count();
        else:
            $projects = Project::where('client_user_id', Auth::user()->id)->orderByDesc('id')->paginate(4);
            $all = Project::where('client_user_id', Auth::user()->id)->count();
            $inprogress = Project::where([['client_user_id', '=', Auth::user()->id],['project_status', '=', '1']])->count();
            $completed = Project::where([['client_user_id', '=', Auth::user()->id],['project_status', '=', '0']])->count();
        endif;
        return view('projects.index', compact('projects', 'all', 'inprogress', 'completed'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $categories = Category::where('user_id', Auth::user()->id)->orderByDesc('id')->get();
        $users = User::where('id', '<>', Auth::user()->id)->orderByDesc('id')->get();
        return view('projects.create', compact('categories', 'users'));
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
            'project_category_id'=>'required|string|max:255'.Rule::in(Category::where('user_id', Auth::user()->id)->pluck('id')->toArray()),
            'project_name'=>'required|string|max:255',
            'project_price'=>'required|numeric|min:0',
            'project_type'=>'required|string|max:255|'.Rule::in($this->status),
            'project_status'=>'required|string|max:255|'.Rule::in($this->status),
            'project_description' => 'required|string|max:255',
            'client_user_id' => 'required|'.Rule::in(User::where('id', '<>', Auth::user()->id)->pluck('id')->toArray())
        ]);
        
        if ($validator->fails()) {
            return redirect('projects/create')->withErrors($validator)->withInput();
        }
        
        $project = new Project([
            'user_id' => Auth::user()->id,
            'project_category_id' => $request->get('project_category_id'),
            'project_name' => $request->get('project_name'),
            'project_type' => $request->get('project_type'),
            'project_price' => $request->get('project_price'),
            'project_description' => $request->get('project_description') ?? '',
            'project_status' => $request->get('project_status'),
            'project_start_date' => $request->get('project_start_date'),
            'project_end_date' => $request->get('project_end_date'),
            'client_user_id' => $request->get('client_user_id'),
        ]);
        $project->save();
        return redirect('/projects')->with('success', 'Project saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::find($id);
        if ($project) {
            $tasks = Task::where('project_id', $project->id)->orderByDesc('id')->paginate(4,['*'],'taskpage');
            $all = Task::where('project_id', $project->id)->count();
            $todo = Task::where([['project_id', '=', $project->id],['status', '=', '0']])->count();
            $inprogress = Task::where([['project_id', '=', $project->id],['status', '=', '1']])->count();
            $completed = Task::where([['project_id', '=', $project->id],['status', '=', '2']])->count();
            return view('projects.view', compact('project', 'tasks', 'all', 'todo', 'inprogress', 'completed'));   
        } else {
            return redirect('/projects')->with('errors', 'Invalid project to view!');
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
        $project = Project::find($id);
        
        if ($project) {
            if (in_array('admin', Auth::user()->roles->pluck('slug')->toArray())):
                $categories = Category::where('user_id', $project->user_id)->orderByDesc('id')->get();
                $users = User::where('id', '<>', Auth::user()->id)->orderByDesc('id')->get();
                return view('projects.edit', ['project' => $project, 'categories' => $categories, 'users' => $users]);
            else:
                if ($project->user_id == Auth::user()->id):
                    $categories = Category::where('user_id', Auth::user()->id)->orderByDesc('id')->get();
                    return view('projects.edit', ['project' => $project, 'categories' => $categories]);
                else:
                    return redirect('/projects')->with('errors', 'Invalid Project to edit!');
                endif;    
            endif;
        } else {
            return redirect('/projects')->with('errors', 'Invalid Project to edit!');
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
        $project = Project::find($id);
        $validator = Validator::make($request->all(), [
            'project_category_id'=>'required|string|max:255|'.Rule::in(Category::where('user_id', Auth::user()->id)->pluck('id')->toArray()),
            'project_name'=>'required|string|max:255',
            'project_type'=>'required|string|max:255|'.Rule::in($this->status),
            'project_price'=>'required|numeric|min:0',
            'project_status'=>'required|string|max:255|'.Rule::in($this->status),
            'project_description' => 'required|string|max:255',
            'client_user_id' => 'required|'.Rule::in(User::where('id', '<>', Auth::user()->id)->pluck('id')->toArray())
        ]);

        if ($validator->fails()) {
            return redirect('projects/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        $project->project_category_id = $request->get('project_category_id');
        $project->project_name = $request->get('project_name');
        $project->project_type = $request->get('project_type');
        $project->project_price = $request->get('project_price');
        $project->project_description = $request->get('project_description');
        $project->project_status = $request->get('project_status');
        $project->project_start_date = $request->get('project_start_date');
        $project->project_end_date = $request->get('project_end_date');
        $project->client_user_id = $request->get('client_user_id');
        $project->save();
        return redirect('/projects')->with('success', 'Project updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::find($id);
        if ($project) {
            $project->delete();
            return redirect('/projects')->with('success', 'Project deleted!');  
        } else {
            return redirect('/projects')->with('errors', 'Invalid Project to delete!');
        }
    }
}
