<?php

namespace App\Http\Controllers;

use App\Effort;
use App\Task;
use App\User;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EffortController extends Controller
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
        return view('efforts.create');
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
            'hour'=>'required|numeric|min:1',
            'project_id' => 'required|'.Rule::in(Project::where('id', '<>', 0)->pluck('id')->toArray()),
            'task_id' => 'required|'.Rule::in(Task::where('id', '<>', 0)->pluck('id')->toArray())
        ]);

        if ($validator->fails()) {
            return redirect('tasks/'.$request->get('task_id'))->withErrors($validator)->withInput();
        }

        $effort = new Effort([
            'hour' => $request->get('hour'),
            'user_id' => Auth::user()->id,
            'project_id' => $request->get('project_id'),
            'task_id' => $request->get('task_id')
        ]);
        $effort->save();
        return redirect('/tasks/'.$request->get('task_id'))->with('success', 'Efforts logged Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Effort  $effort
     * @return \Illuminate\Http\Response
     */
    public function show(Effort $effort)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Effort  $effort
     * @return \Illuminate\Http\Response
     */
    public function edit(Effort $effort)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Effort  $effort
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Effort $effort)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Effort  $effort
     * @return \Illuminate\Http\Response
     */
    public function destroy(Effort $effort)
    {
        $effort = Effort::find($effort->id);
        $taskId = $effort->task_id;
        if ($effort) {
            $effort->delete();
            return redirect('/tasks/'.$taskId)->with('success', 'Effort deleted successfully!');
        } else {
            return redirect('/tasks/'.$taskId)->with('errors', 'Invalid Effort to delete!');
        }
    }
}
