<?php

namespace App\Http\Controllers;

use App\Billing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Storage;

class BillingController extends Controller
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
        $messages = [
            'mimes' => 'Supported file format for :attribute are jpeg,png,jpg,pdf,docx,doc',
        ];
        $file = $request->file('file');
        $validator = Validator::make($request->all(), [
            'amount'=>'required|numeric|min:0',
            'summary' => 'required|string|max:255',
            'file' => 'required|file|max:5000|mimes:jpeg,png,jpg,pdf,docx,doc'
        ], $messages);

        // if ($request->get('amount') > $request->get('pending_hours')) {
        //     // Empty data and rules
        //     $vd = Validator::make([], []);
        //     $validator->errors()->add('amount', 'Invalid settlement amount');
        //     return redirect('projects/'.$request->get('project_id'))->withErrors($validator);
        // }

        if ($validator->fails()) {
            return redirect('projects/'.$request->get('project_id'))->withErrors($validator);
        }

        $request->file('file')->store('public/documents');
        $fileName = $request->file('file')->hashName();

        Billing::create([
            'user_id' => Auth::user()->id,
            'project_id' => $request->get('project_id'),
            'amount' => $request->get('amount'),
            'summary' => $request->get('summary'),
            'doc_name' => $file->getClientOriginalName(),
            'doc_type' => $file->getClientMimeType(),
            'doc_size' => $file->getSize(),
            'doc_url' => $fileName,
        ]);

        return redirect('/projects/'.$request->get('project_id'))->with('success', 'Billing settlement added successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Billing  $billing
     * @return \Illuminate\Http\Response
     */
    public function show(Billing $billing)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Billing  $billing
     * @return \Illuminate\Http\Response
     */
    public function edit(Billing $billing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Billing  $billing
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Billing $billing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Billing  $billing
     * @return \Illuminate\Http\Response
     */
    public function destroy(Billing $billing)
    {
        if (($billing->user_id == Auth::user()->id)) {
            $billing = Billing::find($billing->id);
            $projectId = $billing->project_id;
            if ($billing) {
                Storage::delete('/public/documents/' . $billing->doc_url);
                $billing->delete();
                return redirect('/projects/'.$projectId)->with('success', 'Billing settlement deleted successfully!');
            } else {
                return redirect('/projects/'.$projectId)->with('errors', 'Invalid billing settlement to delete!');
            }
        }
        return redirect('/projects/'.$projectId)->with('errors', 'Unauthorized Action!');
    }
}
