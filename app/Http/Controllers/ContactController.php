<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Storage;

class ContactController extends Controller
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
        if(in_array('admin', Auth::user()->roles->pluck('slug')->toArray())):
            $contacts = Contact::orderByDesc('id')->paginate(4);
        else:
            $contacts = Contact::where('user_id', Auth::user()->id)->orderByDesc('id')->paginate(4);
        endif;
        return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('image');
        $validator = Validator::make($request->all(), [
            'first_name'=>'required|string|max:255',
            'last_name'=>'required|string|max:255',
            'about'=>'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:contacts',
            'phone'=>'string|max:255'
        ]);

        if (!empty($file)) {
            $validator = Validator::make($request->all(), [
                'image' => 'required|image|max:2000',
                'first_name'=>'required|string|max:255',
                'last_name'=>'required|string|max:255',
                'about'=>'required|string|max:255',
                'email'=>'required|string|email|max:255|unique:contacts',
                'phone'=>'string|max:255'
            ]);
        }

        if ($validator->fails()) {
            return redirect('contacts/create')->withErrors($validator)->withInput();
        }

        if (!empty($file)) {
            $request->file('image')->store('public/contact_images');
            $fileName = $request->file('image')->hashName();
        } else {
            $fileName = '';
        }

        $contact = new Contact([
            'user_id' => Auth::user()->id,
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'about' => $request->get('about'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'image' => $fileName,
        ]);
        $contact->save();
        return redirect('/contacts')->with('success', 'Contact saved!');
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
        $contact = Contact::find($id);

        if ($contact) {
            if (in_array('admin', Auth::user()->roles->pluck('slug')->toArray())):
                return view('contacts.edit', compact('contact'));
            else:
                if ($contact->user_id == Auth::user()->id):
                    return view('contacts.edit', compact('contact'));
                else:
                    return redirect('/contacts')->with('errors', 'Invalid contact to edit!');
                endif;
            endif;
        } else {
            return redirect('/contacts')->with('errors', 'Invalid contact to edit!');
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
        $contact = Contact::find($id);
        $file = $request->file('image');
        $validator = Validator::make($request->all(), [
            'first_name'=>'required|string|max:255',
            'last_name'=>'required|string|max:255',
            'about'=>'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:contacts,email,'.$contact->id,
            'phone'=>'string|max:255'
        ]);

        if (!empty($file)) {
            $validator = Validator::make($request->all(), [
                'first_name'=>'required|string|max:255',
                'last_name'=>'required|string|max:255',
                'about'=>'required|string|max:255',
                'email'=>'required|string|email|max:255|unique:contacts,email,'.$contact->id,
                'phone'=>'string|max:255',
                'image' => 'required|image|max:2000'
            ]);
        }

        if ($validator->fails()) {
            return redirect('contacts/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        if (!empty($file)) {
            //Delete old file
            Storage::delete('/public/contact_images/' . $contact->image);
            $request->file('image')->store('public/contact_images');
            $fileName = $request->file('image')->hashName();
        } else {
            $fileName = $contact->image;
        }

        $contact->first_name =  $request->get('first_name');
        $contact->last_name = $request->get('last_name');
        $contact->about = $request->get('about');
        $contact->email = $request->get('email');
        $contact->phone = $request->get('phone');
        $contact->image =  $fileName;
        $contact->save();
        return redirect('/contacts')->with('success', 'Contact updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = Contact::find($id);
        if ($contact) {
            Storage::delete('/public/contact_images/' . $contact->image);
            $contact->delete();
            return redirect('/contacts')->with('success', 'Contact deleted!');
        } else {
            return redirect('/contacts')->with('errors', 'Invalid contact to delete!');
        }
    }
}
