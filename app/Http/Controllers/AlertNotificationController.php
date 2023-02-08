<?php

namespace App\Http\Controllers;

use App\AlertNotification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AlertNotificationController extends Controller
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
        $types = AlertNotification::getTypes();
        if (in_array('admin', Auth::user()->roles->pluck('slug')->toArray())):
            $alertnotifications = AlertNotification::orderByDesc('id')->paginate(4);
        else:
            $alertnotifications = AlertNotification::where('user_id', '=', Auth::user()->id)->orderByDesc('id')->paginate(4);
        endif;
        return view('alertnotifications.index', compact('alertnotifications', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = AlertNotification::getTypes();
        $users = User::all();
        return view('alertnotifications.create', compact('types', 'users'));
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
            'user_id'=> 'required|'.Rule::in(User::where('id', '<>', Auth::user()->id)->pluck('id')->toArray()),
            'type' => 'required|string|max:255',
            'title'=>'required|string|max:255',
            'summary'=>'required|string|max:255',
            'url'=>'string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect('alertnotifications/create')->withErrors($validator)->withInput();
        }

        $alertnotification = new AlertNotification([
            'user_id' => $request->get('user_id'),
            'type' => $request->get('type'),
            'title' => $request->get('title'),
            'summary' => $request->get('summary'),
            'url' => $request->get('url')
        ]);
        $alertnotification->save();
        return redirect('/alertnotifications')->with('success', 'Alert Notifications saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AlertNotification  $alertNotification
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $alertNotification = AlertNotification::find($id);
        $alertNotification->read = 1;
        $alertNotification->save();
        return redirect('/alertnotifications')->with('success', 'Alert Notification updated!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AlertNotification  $alertNotification
     * @return \Illuminate\Http\Response
     */
    public function edit(AlertNotification $alertNotification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AlertNotification  $alertNotification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AlertNotification $alertNotification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AlertNotification  $alertNotification
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $alertNotification = AlertNotification::find($id);
        if ($alertNotification) {
            $alertNotification->delete();
            return redirect('/alertnotifications')->with('success', 'Alert Notification deleted!');
        } else {
            return redirect('/alertnotifications')->with('errors', 'Invalid Alert Notification to delete!');
        }
    }
}
