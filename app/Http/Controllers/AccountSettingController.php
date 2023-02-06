<?php

namespace App\Http\Controllers;

use App\User;
use App\Configuration;
use App\AccountSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class AccountSettingController extends Controller
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $configurations = Configuration::all();


        if ($configurations) {
            foreach ($configurations as $configuration) {
                $accountSettingComputedVal = 0;
                $accountsettingsVal = AccountSetting::where(
                    [
                        ['configuration_id', '=', $configuration->id],
                        ['user_id', '=', Auth::user()->id]
                    ])->first();
                $accountSettingComputedVal = $accountsettingsVal ? $accountsettingsVal->configuration_value : 0;
                $configuration->user_value = $accountSettingComputedVal;
            }
            return view('accountsettings.view', compact('configurations'));
        } else {
            return redirect('/')->with('errors', 'Invalid page to view!');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $inputs = $request->except('_method', '_token');

        if (empty($inputs)) {
            return redirect('/accountsetting')->with('error', 'Please select configurations');
        }

        foreach ($inputs as $key => $value) {
            $configuration = Configuration::where('id', $key)->first();
            if ($configuration) {
                $accountSetting = AccountSetting::where([['configuration_id', '=', $key],['user_id', '=', Auth::user()->id]])->first();
                if ($accountSetting) {
                    //Update
                    $accountSetting->configuration_value = $value;
                    $accountSetting->save();
                } else {
                    //Insert
                    $accountSetting = new AccountSetting([
                        'user_id' => Auth::user()->id,
                        'configuration_id' => $key,
                        'configuration_value' => $value
                    ]);
                    $accountSetting->save();
                }
            }
        }
        return redirect('/accountsetting')->with('success', 'Account Settings updated successfully!');
    }
}
