<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\User;
use App\Role;
use App\Contact;
use App\Permission;
use App\Store;
use App\Category;
use App\Project;
use App\Order;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware(['auth', 'verified']);
        $this->middleware('role:admin,user');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        if (in_array('admin', Auth::user()->roles->pluck('slug')->toArray())):
            $roles = Role::count();
            $users = User::count();
            $contacts = Contact::count();
            $permissions = Permission::count();
            $stores = Store::count();
            $categories = Category::count();
            $projects = Project::count();
            $store = Store::where('user_id', '<>', Auth::user()->id)->orderByDesc('id')->get()->first();
            return view(
                'adminhome',
                [
                    'timenow' => Carbon::now()->toFormattedDateString(),
                    'users' => $users,
                    'roles' => $roles,
                    'contacts' => $contacts,
                    'permissions' => $permissions,
                    'stores' => $stores,
                    'categories' => $categories,
                    'projects' => $projects,
                    'store' => (!empty($store) ? $store : '')
                ]
            );
        else:
            $projects = Project::where('client_user_id', Auth::user()->id)->orderByDesc('id')->count();
            $store = Store::where('user_id', '<>', Auth::user()->id)->orderByDesc('id')->get()->first();

            // dd($store);

            return view(
                'userhome',
                [
                    'projects' => $projects,
                    'store' => (!empty($store) ? $store : ''),
                ]
            );
        endif;
    }

}
