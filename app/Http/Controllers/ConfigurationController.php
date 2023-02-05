<?php

namespace App\Http\Controllers;

use App\Configuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ConfigurationController extends Controller
{

    /**
     * Reserved Configurations
     * This stores the array of confgurations path that admin can not delete, these are used in webapp.
     * eg: ['delivery_charge_amount', 'delivery_free_amount']
     */
    public $reservedConfigurations;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('role:admin');
        /**
         * Reserved
         */
        $this->reservedConfigurations = [
            'alert_system_notification',
            'alert_email_notification'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservedConfigurations = $this->reservedConfigurations;
        if(in_array('admin', Auth::user()->roles->pluck('slug')->toArray())):
            $configurations = Configuration::orderByDesc('id')->paginate(4);
        else:
            $configurations = Configuration::where('user_id', Auth::user()->id)->orderByDesc('id')->paginate(4);
        endif;
        return view('configurations.index', ['configurations' => $configurations, 'reservedConfigurations' => $reservedConfigurations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('configurations.create');
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
            'name' => 'required|string|max:255',
            'value'=>'required|string|min:0'
        ]);

        if ($validator->fails()) {
            return redirect('configurations/create')->withErrors($validator)->withInput();
        }

        $path = Str::slug($request->get('name'), '_');

        $configuration = new configuration([
            'user_id' => Auth::user()->id,
            'name' => $request->get('name'),
            'path' => $path,
            'value' => $request->get('value')
        ]);

        try {
            $configuration->save();
        } catch(\Illuminate\Database\QueryException $e){
            //$e->getMessage(), duplicate path error, handle custom message
            return redirect('/configurations')->with('errors', 'Can not add new configuration, Duplicate configuration found: '.$path.', Please use a different configuration name to fix this error.');
        }

        return redirect('/configurations')->with('success', 'Configuration saved!');
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
        $configuration = Configuration::find($id);

        if ($configuration) {
            if (in_array('admin', Auth::user()->roles->pluck('slug')->toArray())):
                return view('configurations.edit', compact('configuration'));
            else:
                if ($configuration->user_id == Auth::user()->id):
                    return view('configurations.edit', compact('configuration'));
                else:
                    return redirect('/configurations')->with('errors', 'Invalid configuration to edit!');
                endif;
            endif;
        } else {
            return redirect('/configurations')->with('errors', 'Invalid configuration to edit!');
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
        $configuration = Configuration::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'value'=> 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect('configurations/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        $configuration->name = $request->get('name');
        $configuration->value = $request->get('value');
        $configuration->save();
        return redirect('/configurations')->with('success', 'Configuration updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $configuration = Configuration::find($id);
        if ($configuration) {
            if(in_array($configuration->path, $this->reservedConfigurations)) {
                return redirect('/configurations')->with('errors', 'System reserved configurations can not be deleted!');
            }
            $configuration->delete();
            return redirect('/configurations')->with('success', 'Configuration deleted!');
        } else {
            return redirect('/configurations')->with('errors', 'Invalid configuration to delete!');
        }
    }
}
