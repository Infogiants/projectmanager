<?php

namespace App\Http\Controllers;

use App\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Storage;

class DocumentController extends Controller
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
        return view('documents.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'mimes' => 'Supported file format for :attribute are jpeg,png,jpg,pdf,docx,doc,txt',
        ];
        $file = $request->file('file');
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|max:5000|mimes:jpeg,png,jpg,pdf,docx,doc,txt'
        ], $messages);

        if ($validator->fails()) {
            if(empty($request->get('task_id'))) {
                return redirect('projects/'.$request->get('project_id'))->withErrors($validator);
            } else {
                return redirect('tasks/'.$request->get('task_id'))->withErrors($validator);
            }
        }

        $request->file('file')->store('public/documents');
        $fileName = $request->file('file')->hashName();

        Document::create([
            'project_id' => $request->get('project_id'),
            'task_id' => $request->get('task_id') ? $request->get('task_id') : null,
            'name' => $file->getClientOriginalName(),
            'type' => $file->getClientMimeType(),
            'size' => $file->getSize(),
            'url' => $fileName,
            'user_id' => Auth::user()->id
        ]);

        if(empty($request->get('task_id'))) {
            return redirect('/projects/'.$request->get('project_id'))->with('success', 'Document uploaded successfully!');
        } else {
            return redirect('/tasks/'.$request->get('task_id'))->with('success', 'Document uploaded successfully!');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function destroy(Document $document)
    {
        if (($document->user_id == Auth::user()->id)) {
            $document = Document::find($document->id);
            $projectId = $document->project_id;
            $taskId = $document->task_id;
            if ($document) {
                Storage::delete('/public/documents/' . $document->url);
                $document->delete();
                if(empty($taskId)) {
                    return redirect('/projects/'.$projectId)->with('success', 'Document deleted successfully!');
                } else {
                    return redirect('/tasks/'.$taskId)->with('success', 'Document deleted successfully!');
                }
            } else {
                if(empty($taskId)) {
                    return redirect('/projects/'.$projectId)->with('errors', 'Invalid Document to delete!');
                } else {
                    return redirect('/tasks/'.$taskId)->with('errors', 'Invalid Document to delete!');
                }
            }
        }
        return redirect('/projects/'.$projectId)->with('errors', 'Unauthorized Action!');
    }
}
