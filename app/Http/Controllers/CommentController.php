<?php

namespace App\Http\Controllers;

use App\Task;
use App\Comment;
use App\User;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CommentController extends Controller
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
        $validator = Validator::make($request->all(), [
            'task_id'=>'required|'.Rule::in(Task::where('id', '<>', 0)->pluck('id')->toArray()),
            'project_id' => 'required|'.Rule::in(Project::where('id', '<>', 0)->pluck('id')->toArray()),
            'description' => 'required|string|max:255'
        ]);
        
        if ($validator->fails()) {
            return redirect('tasks/'.$request->get('task_id'))->withErrors($validator)->withInput();
        }
        
        $task = new Comment([
            'description' => $request->get('description') ?? '',
            'user_id' => Auth::user()->id,
            'task_id' => $request->get('task_id'),
            'project_id' => $request->get('project_id')
        ]);
        $task->save();
        return redirect('/tasks/'.$request->get('task_id'))->with('success', 'Comment Added Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment = Comment::find($comment->id);
        $taskId = $comment->task_id;
        if ($comment) {
            $comment->delete();
            return redirect('/tasks/'.$taskId)->with('success', 'Comment deleted!'); 
        } else {
            return redirect('/tasks/'.$taskId)->with('errors', 'Invalid Comment to delete!');
        }
    }
}
