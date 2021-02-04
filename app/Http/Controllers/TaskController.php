<?php

namespace App\Http\Controllers;

use App\Task;
use App\Document;
use App\Comment;
use App\User;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Storage;

class TaskController extends Controller
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
        $this->status = ['0', '1', '2'];
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
        return view('tasks.create');
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
            'title'=>'required|string|max:255',
            'description' => 'required|string|max:255',
            'project_id' => 'required|'.Rule::in(Project::where('id', '<>', 0)->pluck('id')->toArray()),
            'status'=>'required|string|max:255|'.Rule::in($this->status),
        ]);
        
        if ($validator->fails()) {
            return redirect('projects/'.$request->get('project_id'))->withErrors($validator)->withInput();
        }
        
        $task = new Task([
            'title' => $request->get('title'),
            'description' => $request->get('description') ?? '',
            'user_id' => Auth::user()->id,
            'project_id' => $request->get('project_id'),
            'status' => $request->get('status'),
        ]);
        $task->save();
        return redirect('/projects/'.$request->get('project_id'))->with('success', 'Task Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {   
        $task = Task::find($task->id);
        if ($task) {
            $comments = Comment::where('task_id', $task->id)->orderBy('id', 'asc')->paginate(10,['*'],'commentpage');
            $commentscount = Comment::where('task_id', $task->id)->count();
            $documents = Document::where('task_id', $task->id)->orderByDesc('id')->paginate(4,['*'],'documentpage');
            $documentscount = Document::where('task_id', $task->id)->count();
            return view('tasks.view', compact('task', 'comments', 'documents', 'documentscount', 'commentscount'));   
        } else {
            return redirect('/projects')->with('errors', 'Invalid task to view!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $task = Task::find($task->id);
        if ($task) {
            return view('tasks.edit', compact('task'));   
        } else {
            return redirect('/projects')->with('errors', 'Invalid task to edit!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $task = Task::find($task->id);
        $validator = Validator::make($request->all(), [
            'title'=>'required|string|max:255',
            'description' => 'required|string|max:255',
            'status'=>'required|string|max:255|'.Rule::in($this->status),
        ]);
        
        if ($validator->fails()) {
            return redirect('tasks/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        $task->title =  $request->get('title');
        $task->description = $request->get('description');
        $task->status = $request->get('status');
        $task->save();
        
        return redirect('/projects/'.$task->project_id)->with('success', 'Task updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task = Task::find($task->id);
        $projectId = $task->project_id;
        $documents = Document::where('task_id', $task->id)->get();
        foreach($documents as $document) {
            Storage::delete('/public/documents/' . $document->url);
            $document->delete();
        }
        if ($task) {
            $task->delete();
            return redirect('/projects/'.$projectId)->with('success', 'Task deleted!'); 
        } else {
            return redirect('/projects/'.$projectId)->with('errors', 'Invalid Task to delete!');
        }
    }
}
