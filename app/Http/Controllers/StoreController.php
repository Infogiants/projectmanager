<?php

namespace App\Http\Controllers;

use App\Store;
use App\Configuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Storage;


class StoreController extends Controller
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
        if (in_array('admin', Auth::user()->roles->pluck('slug')->toArray())):
            $stores = Store::orderByDesc('id')->paginate(4);
        else:
            $stores = Store::where('user_id', Auth::user()->id)->orderByDesc('id')->paginate(4);
        endif;
        return view('stores.index', compact('stores'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {  
       $stores = Store::where('user_id', Auth::user()->id)->orderByDesc('id')->paginate(4);
       
       if(count($stores) > 0) {
        return redirect('/stores');
       } else {
        return view('stores.create');    
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
        $store = Store::find($id);
        
        if ($store) {
            if ($store->user_id == Auth::user()->id):
                return view('stores.edit', compact('store'));
            else:
                return redirect('/stores')->with('errors', 'Invalid store to edit!');
            endif;
        } else {
            return redirect('/stores')->with('errors', 'Invalid store to edit!');
        }
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('store_logo');
        $validator = Validator::make($request->all(), [
            'store_name' => 'required|alpha|max:255|unique:stores,store_name',
            'store_contact_no' => 'required|string|max:255'
        ]);

        if (!empty($file)) {
            $validator = Validator::make($request->all(), [
                'store_logo' => 'required|image|max:2000',
            ]);
        }

        if ($validator->fails()) {
            return redirect('stores/create')->withErrors($validator)->withInput();
        }
        
        if (!empty($file)) {
            $request->file('store_logo')->store('public');
            $fileName = $request->file('store_logo')->hashName();    
        } else {
            $fileName = '';
        }
        
        $store = new Store([
            'user_id' => Auth::user()->id,
            'store_logo' => $fileName ?? '',
            'store_name' => $request->get('store_name'),
            'store_description' => $request->get('store_description') ?? '',
            'store_address' => $request->get('store_address') ?? '',
            'store_contact_no' => $request->get('store_contact_no') ?? '',
            'store_status' => '1',
            'store_closed_message' => 'Our store is closed now.',
            'store_website' => $request->get('store_website') ?? '',
        ]);
        $store->save();

        //Add required system shipping configurations
        Configuration::where('user_id', Auth::user()->id)->delete();
        $configuration = new Configuration([
            'user_id' => Auth::user()->id,
            'name' => 'Delivery Charge Amount',
            'path' => 'delivery_charge_amount',
            'value' => 10
        ]);
        $configuration->save();
        
        $configuration = new Configuration([
            'user_id' => Auth::user()->id,
            'name' => 'Free Delivery Above Order Total',
            'path' => 'delivery_free_amount',
            'value' => 100
        ]);
        $configuration->save();
        
        return redirect('/stores')->with('success', 'Store saved!');
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
        $store = Store::find($id);
        $file = $request->file('store_logo');
        $validator = Validator::make($request->all(), [
            'store_name'=> 'required|alpha|max:255|unique:stores,store_name,'.$store->id,
            'store_status'=> 'required|string|max:255|'.Rule::in(['0', '1']),
            'store_contact_no' => 'required|string|max:255',
            'store_closed_message' => 'required|string|max:255'
        ]);

        if (!empty($file)) {
            $validator = Validator::make($request->all(), [
                'store_logo' => 'required|image|max:2000',
            ]);
        }

        if ($validator->fails()) {
            return redirect('stores/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        //Restrict application controller names from store Name
        if (in_array(
            $request->get('store_name'),
            [
                'home',
                'users',
                'roles',
                'permissions',
                'contacts',
                'stores',
                'categories',
                'products',
                'orders',
                'search',
                'contact',
                'features',
                'pricing',
                'blog',
                'blogsingle',
            ])
        ) {
            return redirect('stores/'.$store->id.'/edit')->withErrors('Please choose another store name.');
        }


        if (!empty($file)) {
            //Delete old file
            Storage::delete('/public/' . $store->store_logo);
            $request->file('store_logo')->store('public');
            $fileName = $request->file('store_logo')->hashName();    
        } else {
            $fileName = $store->store_logo;
        }

        $store->store_name =  $request->get('store_name');
        $store->store_logo = $fileName ?? '';
        $store->store_description = $request->get('store_description') ?? '';
        $store->store_address = $request->get('store_address') ?? '';
        $store->store_contact_no = $request->get('store_contact_no') ?? $store->store_contact_no;
        $store->store_status = $request->get('store_status') ?? $store->store_status;
        $store->store_closed_message = $request->get('store_closed_message') ?? $store->store_closed_message;
        $store->store_website = $request->get('store_website') ?? $store->store_website;
        $store->save();
        return redirect('/stores')->with('success', 'Store updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        //Allow admin role to delete only
        if (!in_array('admin', Auth::user()->roles->pluck('slug')->toArray())):
            return redirect('/stores')->with('errors', 'Access denied!');
        endif;    

        $store = Store::find($id);
        if ($store) {
            Storage::delete('/public/' . $store->store_logo);
            $store->delete();
            return redirect('/stores')->with('success', 'Store deleted!');  
        } else {
            return redirect('/stores')->with('errors', 'Invalid store to delete!');
        }
    }
}
