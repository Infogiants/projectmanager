<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Category;
use Illuminate\Support\Facades\Auth;
use Storage;

class CategoryController extends Controller
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
            $categories = Category::orderBy('id', 'desc')->paginate(4);
        else:
            $categories = Category::where('user_id', Auth::user()->id)->orderByDesc('id')->paginate(4);
        endif;
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        return view('categories.create');
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
            'name'=> 'required|string|max:255|unique:categories,name',
        ]);

        if (!empty($file)) {
            $validator = Validator::make($request->all(), [
                'image' => 'required|image|max:2000',
                'name'=> 'required|string|max:255|unique:categories,name',
            ]);
        }

        if ($validator->fails()) {
            return redirect('categories/create')->withErrors($validator)->withInput();
        }

        if (!empty($file)) {
            $request->file('image')->store('public/category_images');
            $fileName = $request->file('image')->hashName();    
        } else {
            $fileName = '';
        }

        $category = new Category([
            'user_id' => Auth::user()->id,
            'name' => $request->get('name'),
            'slug' => Str::slug($request->get('name'), '-'),
            'image' => $fileName,
        ]);
        $category->save();
        
        return redirect('/categories')->with('success', 'Category saved!');
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
        $category = Category::find($id);
        if ($category) {
            return view('categories.edit', compact('category'));   
        } else {
            return redirect('/categories')->with('errors', 'Invalid category to edit!');
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
        $category = Category::find($id);
        $file = $request->file('image');
        $validator = Validator::make($request->all(), [
            'name'=> 'required|string|max:255|unique:categories,name,'.$category->id,
            
        ]);
        
        if (!empty($file)) {
            $validator = Validator::make($request->all(), [
                'name'=> 'required|string|max:255|unique:categories,name,'.$category->id,
                'image' => 'required|image|max:2000'
            ]);
        }

        if ($validator->fails()) {
            return redirect('categories/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        if (!empty($file)) {
            //Delete old file
            Storage::delete('/public/category_images/' . $category->image);
            $request->file('image')->store('public/category_images');
            $fileName = $request->file('image')->hashName();    
        } else {
            $fileName = $category->image;
        }
        
        $category->name =  $request->get('name');
        $category->slug = strtolower($request->get('name'));
        $category->image =  $fileName;
        $category->save();
        
        return redirect('/categories')->with('success', 'Category updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        if ($category) {
            Storage::delete('/public/category_images/' . $category->image);
            $category->delete();
            return redirect('/categories')->with('success', 'Category deleted!');  
        } else {
            return redirect('/categories')->with('errors', 'Invalid category to delete!');
        }
    }
}
