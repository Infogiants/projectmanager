<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use App\Document;
use App\Category;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Storage;

class ProjectController extends Controller
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
        $this->status = ['0', '1', '2'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(in_array('admin', Auth::user()->roles->pluck('slug')->toArray())):
            $projects = Project::orderByDesc('id')->paginate(4);
            $all = Project::all()->count();
            $todo = Project::where('project_status', '0')->count();
            $inprogress = Project::where('project_status', '1')->count();
            $completed = Project::where('project_status', '2')->count();
        else:
            $projects = Project::where('client_user_id', Auth::user()->id)->orderByDesc('id')->paginate(4);
            $all = Project::where('client_user_id', Auth::user()->id)->count();
            $todo = Project::where([['client_user_id', '=', Auth::user()->id],['project_status', '=', '0']])->count();
            $inprogress = Project::where([['client_user_id', '=', Auth::user()->id],['project_status', '=', '1']])->count();
            $completed = Project::where([['client_user_id', '=', Auth::user()->id],['project_status', '=', '2']])->count();
        endif;
        return view('projects.index', compact('projects', 'all', 'todo', 'inprogress', 'completed'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (in_array('admin', Auth::user()->roles->pluck('slug')->toArray())):
            $categories = Category::where('user_id', Auth::user()->id)->orderByDesc('id')->get();
            $users = User::where('id', '<>', Auth::user()->id)->orderByDesc('id')->get();
            $countries = $this->getCountryList();
            return view('projects.create', compact('categories', 'users', 'countries'));
        else:
            return redirect('/projects')->with('errors', 'Invaid request!');
        endif;
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
            'project_category_id'=>'required|string|max:255'.Rule::in(Category::where('user_id', Auth::user()->id)->pluck('id')->toArray()),
            'project_name'=>'required|string|max:255',
            'project_price'=>'required|numeric|min:0',
            'project_type'=>'required|string|max:255|'.Rule::in($this->status),
            'project_status'=>'required|string|max:255|'.Rule::in($this->status),
            'project_description' => 'required|string|max:255',
            'client_user_id' => 'required|'.Rule::in(User::where('id', '<>', Auth::user()->id)->pluck('id')->toArray()),
            'project_currency' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect('projects/create')->withErrors($validator)->withInput();
        }

        $project = new Project([
            'user_id' => Auth::user()->id,
            'project_category_id' => $request->get('project_category_id'),
            'project_name' => $request->get('project_name'),
            'project_type' => $request->get('project_type'),
            'project_price' => $request->get('project_price'),
            'project_description' => $request->get('project_description') ?? '',
            'project_status' => $request->get('project_status'),
            'project_start_date' => $request->get('project_start_date'),
            'project_end_date' => $request->get('project_end_date'),
            'client_user_id' => $request->get('client_user_id'),
            'project_currency' => $request->get('project_currency')
        ]);
        $project->save();
        return redirect('/projects')->with('success', 'Project saved!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = Project::find($id);
        if ($project) {
            //tasks
            $tasks = Task::where('project_id', $project->id)->orderByDesc('id')->paginate(4,['*'],'taskpage');
            $all = Task::where('project_id', $project->id)->count();
            $todo = Task::where([['project_id', '=', $project->id],['status', '=', '0']])->count();
            $inprogress = Task::where([['project_id', '=', $project->id],['status', '=', '1']])->count();
            $completed = Task::where([['project_id', '=', $project->id],['status', '=', '2']])->count();
            //documents
            $documents = Document::where([['project_id', '=', $project->id],['task_id', '=', null]])->orderByDesc('id')->paginate(4,['*'],'documentpage');
            $alldocuments = Document::where([['project_id', '=', $project->id],['task_id', '=', null]])->count();
            return view('projects.view', compact('project', 'tasks', 'all', 'todo', 'inprogress', 'completed', 'documents', 'alldocuments'));
        } else {
            return redirect('/projects')->with('errors', 'Invalid project to view!');
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
        $project = Project::find($id);

        if ($project) {
            $countries = $this->getCountryList();
            if (in_array('admin', Auth::user()->roles->pluck('slug')->toArray())):
                $categories = Category::where('user_id', $project->user_id)->orderByDesc('id')->get();
                $users = User::where('id', '<>', Auth::user()->id)->orderByDesc('id')->get();
                return view('projects.edit', ['project' => $project, 'categories' => $categories, 'users' => $users, 'countries' => $countries]);
            else:
                return redirect('/projects')->with('errors', 'Invalid request!');
            endif;
        } else {
            return redirect('/projects')->with('errors', 'Invalid Project to edit!');
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
        $project = Project::find($id);
        $validator = Validator::make($request->all(), [
            'project_category_id'=>'required|string|max:255|'.Rule::in(Category::where('user_id', Auth::user()->id)->pluck('id')->toArray()),
            'project_name'=>'required|string|max:255',
            'project_type'=>'required|string|max:255|'.Rule::in($this->status),
            'project_price'=>'required|numeric|min:0',
            'project_status'=>'required|string|max:255|'.Rule::in($this->status),
            'project_description' => 'required|string|max:255',
            'client_user_id' => 'required|'.Rule::in(User::where('id', '<>', Auth::user()->id)->pluck('id')->toArray()),
            'project_currency' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect('projects/'.$id.'/edit')->withErrors($validator)->withInput();
        }

        $project->project_category_id = $request->get('project_category_id');
        $project->project_name = $request->get('project_name');
        $project->project_type = $request->get('project_type');
        $project->project_price = $request->get('project_price');
        $project->project_description = $request->get('project_description');
        $project->project_status = $request->get('project_status');
        $project->project_start_date = $request->get('project_start_date');
        $project->project_end_date = $request->get('project_end_date');
        $project->client_user_id = $request->get('client_user_id');
        $project->project_currency = $request->get('project_currency');
        $project->save();
        return redirect('/projects')->with('success', 'Project updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::find($id);
        $documents = Document::where('project_id', $project->id)->get();
        foreach($documents as $document) {
            Storage::delete('/public/documents/' . $document->url);
            $document->delete();
        }
        if ($project) {
            $project->delete();
            return redirect('/projects')->with('success', 'Project deleted!');
        } else {
            return redirect('/projects')->with('errors', 'Invalid Project to delete!');
        }
    }

    /**
     * Country Currnecies
     */
    protected function getCountryList()
    {
        return [
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/albania.png",
                "CountryName" => "Albania",
                "Currency" => "Lek",
                "Code" => "ALL",
                "Symbol" => "Lek",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/afghanistan.png",
                "CountryName" => "Afghanistan",
                "Currency" => "Afghani",
                "Code" => "AFN",
                "Symbol" => "؋",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/argentina.png",
                "CountryName" => "Argentina",
                "Currency" => "Peso",
                "Code" => "ARS",
                "Symbol" => "$",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/aruba.png",
                "CountryName" => "Aruba",
                "Currency" => "Guilder",
                "Code" => "AWG",
                "Symbol" => "ƒ",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/australia.png",
                "CountryName" => "Australia",
                "Currency" => "Dollar",
                "Code" => "AUD",
                "Symbol" => "$",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/azerbaijan.png",
                "CountryName" => "Azerbaijan",
                "Currency" => "Manat",
                "Code" => "AZN",
                "Symbol" => "₼",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/bahamas.png",
                "CountryName" => "Bahamas",
                "Currency" => "Dollar",
                "Code" => "BSD",
                "Symbol" => "$",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/barbados.png",
                "CountryName" => "Barbados",
                "Currency" => "Dollar",
                "Code" => "BBD",
                "Symbol" => "$",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/belarus.png",
                "CountryName" => "Belarus",
                "Currency" => "Ruble",
                "Code" => "BYR",
                "Symbol" => "p.",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/belize.png",
                "CountryName" => "Belize",
                "Currency" => "Dollar",
                "Code" => "BZD",
                "Symbol" => "BZ$",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/bermuda.png",
                "CountryName" => "Bermuda",
                "Currency" => "Dollar",
                "Code" => "BMD",
                "Symbol" => "$",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/bolivia.png",
                "CountryName" => "Bolivia",
                "Currency" => "Boliviano",
                "Code" => "BOB",
                "Symbol" => "BOB",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/Bosnia_and_Herzegovina.png",
                "CountryName" => "Bosnia and Herzegovina",
                "Currency" => "Convertible Marka",
                "Code" => "BAM",
                "Symbol" => "KM",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/botswana.png",
                "CountryName" => "Botswana",
                "Currency" => "Pula",
                "Code" => "BWP",
                "Symbol" => "P",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/bulgaria.png",
                "CountryName" => "Bulgaria",
                "Currency" => "Lev",
                "Code" => "BGN",
                "Symbol" => "лв",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/brazil.png",
                "CountryName" => "Brazil",
                "Currency" => "Real",
                "Code" => "BRL",
                "Symbol" => "R$",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/brunei.png",
                "CountryName" => "Brunei",
                "Currency" => "Darussalam Dollar",
                "Code" => "BND",
                "Symbol" => "$",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/cambodia.png",
                "CountryName" => "Cambodia",
                "Currency" => "Riel",
                "Code" => "KHR",
                "Symbol" => "៛",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/canada.png",
                "CountryName" => "Canada",
                "Currency" => "Dollar",
                "Code" => "CAD",
                "Symbol" => "$",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/Cayman_Islands.png",
                "CountryName" => "Cayman",
                "Currency" => "Dollar",
                "Code" => "KYD",
                "Symbol" => "$",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/chile.png",
                "CountryName" => "Chile",
                "Currency" => "Peso",
                "Code" => "CLP",
                "Symbol" => "$",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/china.png",
                "CountryName" => "China",
                "Currency" => "Yuan Renminbi",
                "Code" => "CNY",
                "Symbol" => "¥",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/colombia.png",
                "CountryName" => "Colombia",
                "Currency" => "Peso",
                "Code" => "COP",
                "Symbol" => "$",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/costarica.png",
                "CountryName" => "Costa Rica",
                "Currency" => "Colon",
                "Code" => "CRC",
                "Symbol" => "₡",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/croatia.png",
                "CountryName" => "Croatia",
                "Currency" => "Kuna",
                "Code" => "HRK",
                "Symbol" => "kn",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/cuba.png",
                "CountryName" => "Cuba",
                "Currency" => "Peso",
                "Code" => "CUP",
                "Symbol" => "₱",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/czechrepublic.png",
                "CountryName" => "Czech Republic",
                "Currency" => "Koruna",
                "Code" => "CZK",
                "Symbol" => "Kč",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/denmark.png",
                "CountryName" => "Denmark",
                "Currency" => "Krone",
                "Code" => "DKK",
                "Symbol" => "kr",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/dominicanrepublic.png",
                "CountryName" => "Dominican Republic",
                "Currency" => "Peso",
                "Code" => "DOP",
                "Symbol" => "RD$",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/egypt.png",
                "CountryName" => "Egypt",
                "Currency" => "Pound",
                "Code" => "EGP",
                "Symbol" => "£",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/elsalvador.png",
                "CountryName" => "El Salvador",
                "Currency" => "Colon",
                "Code" => "SVC",
                "Symbol" => "$",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/estonia.png",
                "CountryName" => "Estonia",
                "Currency" => "Kroon",
                "Code" => "EEK",
                "Symbol" => "kr",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/euro.png",
                "CountryName" => "Euro Member",
                "Currency" => "Euro",
                "Code" => "EUR",
                "Symbol" => "€",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/falklandislands.png",
                "CountryName" => "Falkland Islands",
                "Currency" => "Pound",
                "Code" => "FKP",
                "Symbol" => "£",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/fiji.png",
                "CountryName" => "Fiji",
                "Currency" => "Dollar",
                "Code" => "FJD",
                "Symbol" => "$",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/georgia.png",
                "CountryName" => "Georgia",
                "Currency" => "Lari",
                "Code" => "GEL",
                "Symbol" => "₾",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/ghana.png",
                "CountryName" => "Ghana",
                "Currency" => "Cedis",
                "Code" => "GHC",
                "Symbol" => "¢",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/gibraltar.png",
                "CountryName" => "Gibraltar",
                "Currency" => "Pound",
                "Code" => "GIP",
                "Symbol" => "£",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/guatemala.png",
                "CountryName" => "Guatemala",
                "Currency" => "Quetzal",
                "Code" => "GTQ",
                "Symbol" => "Q",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/guernsey.png",
                "CountryName" => "Guernsey",
                "Currency" => "Pound",
                "Code" => "GGP",
                "Symbol" => "£",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/guyana.png",
                "CountryName" => "Guyana",
                "Currency" => "Dollar",
                "Code" => "GYD",
                "Symbol" => "$",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/honduras.png",
                "CountryName" => "Honduras",
                "Currency" => "Lempira",
                "Code" => "HNL",
                "Symbol" => "L",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/hongkong.png",
                "CountryName" => "Hong Kong",
                "Currency" => "Dollar",
                "Code" => "HKD",
                "Symbol" => "$",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/hungary.png",
                "CountryName" => "Hungary",
                "Currency" => "Forint",
                "Code" => "HUF",
                "Symbol" => "Ft",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/iceland.png",
                "CountryName" => "Iceland",
                "Currency" => "Krona",
                "Code" => "ISK",
                "Symbol" => "kr",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/india.png",
                "CountryName" => "India",
                "Currency" => "Rupee",
                "Code" => "INR",
                "Symbol" => "₹",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/indonesia.png",
                "CountryName" => "Indonesia",
                "Currency" => "Rupiah",
                "Code" => "IDR",
                "Symbol" => "Rp",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/iran.png",
                "CountryName" => "Iran",
                "Currency" => "Rial",
                "Code" => "IRR",
                "Symbol" => "﷼",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/isleofman.png",
                "CountryName" => "Isle of Man",
                "Currency" => "Pound",
                "Code" => "IMP",
                "Symbol" => "£",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/israel.png",
                "CountryName" => "Israel",
                "Currency" => "Shekel",
                "Code" => "ILS",
                "Symbol" => "₪",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/jamaica.png",
                "CountryName" => "Jamaica",
                "Currency" => "Dollar",
                "Code" => "JMD",
                "Symbol" => "J$",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/japan.png",
                "CountryName" => "Japan",
                "Currency" => "Yen",
                "Code" => "JPY",
                "Symbol" => "¥",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/jersey.png",
                "CountryName" => "Jersey",
                "Currency" => "Pound",
                "Code" => "JEP",
                "Symbol" => "£",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/kazakhstan.png",
                "CountryName" => "Kazakhstan",
                "Currency" => "Tenge",
                "Code" => "KZT",
                "Symbol" => "лв",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/northkorea.png",
                "CountryName" => "Korea (North)",
                "Currency" => "Won",
                "Code" => "KPW",
                "Symbol" => "₩",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/southkorea.png",
                "CountryName" => "Korea (South)",
                "Currency" => "Won",
                "Code" => "KRW",
                "Symbol" => "₩",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/kyrgyzstan.png",
                "CountryName" => "Kyrgyzstan",
                "Currency" => "Som",
                "Code" => "KGS",
                "Symbol" => "лв",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/laos.png",
                "CountryName" => "Laos",
                "Currency" => "Kip",
                "Code" => "LAK",
                "Symbol" => "₭",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/latvia.png",
                "CountryName" => "Latvia",
                "Currency" => "Lat",
                "Code" => "LVL",
                "Symbol" => "Ls",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/lebanon.png",
                "CountryName" => "Lebanon",
                "Currency" => "Pound",
                "Code" => "LBP",
                "Symbol" => "£",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/liberia.png",
                "CountryName" => "Liberia",
                "Currency" => "Dollar",
                "Code" => "LRD",
                "Symbol" => "$",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/lithuania.png",
                "CountryName" => "Lithuania",
                "Currency" => "Litas",
                "Code" => "LTL",
                "Symbol" => "Lt",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/macedonia.png",
                "CountryName" => "Macedonia",
                "Currency" => "Denar",
                "Code" => "MKD",
                "Symbol" => "ден",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/malaysia.png",
                "CountryName" => "Malaysia",
                "Currency" => "Ringgit",
                "Code" => "MYR",
                "Symbol" => "RM",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/mauritius.png",
                "CountryName" => "Mauritius",
                "Currency" => "Rupee",
                "Code" => "MUR",
                "Symbol" => "₨",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/mexico.png",
                "CountryName" => "Mexico",
                "Currency" => "Peso",
                "Code" => "MXN",
                "Symbol" => "$",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/mongolia.png",
                "CountryName" => "Mongolia",
                "Currency" => "Tughrik",
                "Code" => "MNT",
                "Symbol" => "₮",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/mozambique.png",
                "CountryName" => "Mozambique",
                "Currency" => "Metical",
                "Code" => "MZN",
                "Symbol" => "MT",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/namibia.png",
                "CountryName" => "Namibia",
                "Currency" => "Dollar",
                "Code" => "NAD",
                "Symbol" => "$",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/nepal.png",
                "CountryName" => "Nepal",
                "Currency" => "Rupee",
                "Code" => "NPR",
                "Symbol" => "₨",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/netherlands.png",
                "CountryName" => "Netherlands",
                "Currency" => "Antilles Guilder",
                "Code" => "ANG",
                "Symbol" => "ƒ",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/newzealand.png",
                "CountryName" => "New Zealand",
                "Currency" => "Dollar",
                "Code" => "NZD",
                "Symbol" => "$",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/nicaragua.png",
                "CountryName" => "Nicaragua",
                "Currency" => "Cordoba",
                "Code" => "NIO",
                "Symbol" => "C$",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/nigeria.png",
                "CountryName" => "Nigeria",
                "Currency" => "Naira",
                "Code" => "NGN",
                "Symbol" => "₦",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/norway.png",
                "CountryName" => "Norway",
                "Currency" => "Krone",
                "Code" => "NOK",
                "Symbol" => "kr",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/oman.png",
                "CountryName" => "Oman",
                "Currency" => "Rial",
                "Code" => "OMR",
                "Symbol" => "﷼",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/pakistan.png",
                "CountryName" => "Pakistan",
                "Currency" => "Rupee",
                "Code" => "PKR",
                "Symbol" => "₨",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/panama.png",
                "CountryName" => "Panama",
                "Currency" => "Balboa",
                "Code" => "PAB",
                "Symbol" => "B/.",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/paraguay.png",
                "CountryName" => "Paraguay",
                "Currency" => "Guarani",
                "Code" => "PYG",
                "Symbol" => "Gs",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/peru.png",
                "CountryName" => "Peru",
                "Currency" => "Nuevo Sol",
                "Code" => "PEN",
                "Symbol" => "S/.",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/philippines.png",
                "CountryName" => "Philippines",
                "Currency" => "Peso",
                "Code" => "PHP",
                "Symbol" => "₱",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/poland.png",
                "CountryName" => "Poland",
                "Currency" => "Zloty",
                "Code" => "PLN",
                "Symbol" => "zł",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/qatar.png",
                "CountryName" => "Qatar",
                "Currency" => "Riyal",
                "Code" => "QAR",
                "Symbol" => "﷼",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/romania.png",
                "CountryName" => "Romania",
                "Currency" => "New Leu",
                "Code" => "RON",
                "Symbol" => "lei",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/russia.png",
                "CountryName" => "Russia",
                "Currency" => "Ruble",
                "Code" => "RUB",
                "Symbol" => "₽",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/sainthelena.png",
                "CountryName" => "Saint Helena",
                "Currency" => "Pound",
                "Code" => "SHP",
                "Symbol" => "£",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/saudiarabia.png",
                "CountryName" => "Saudi Arabia",
                "Currency" => "Riyal",
                "Code" => "SAR",
                "Symbol" => "﷼",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/serbia.png",
                "CountryName" => "Serbia",
                "Currency" => "Dinar",
                "Code" => "RSD",
                "Symbol" => "Дин.",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/seychelles.png",
                "CountryName" => "Seychelles",
                "Currency" => "Rupee",
                "Code" => "SCR",
                "Symbol" => "₨",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/singapore.png",
                "CountryName" => "Singapore",
                "Currency" => "Dollar",
                "Code" => "SGD",
                "Symbol" => "$",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/solomonislands.png",
                "CountryName" => "Solomon Islands",
                "Currency" => "Dollar",
                "Code" => "SBD",
                "Symbol" => "$",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/somalia.png",
                "CountryName" => "Somalia",
                "Currency" => "Shilling",
                "Code" => "SOS",
                "Symbol" => "S",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/southafrica.png",
                "CountryName" => "South Africa",
                "Currency" => "Rand",
                "Code" => "ZAR",
                "Symbol" => "R",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/srilanka.png",
                "CountryName" => "Sri Lanka",
                "Currency" => "Rupee",
                "Code" => "LKR",
                "Symbol" => "₨",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/sweden.png",
                "CountryName" => "Sweden",
                "Currency" => "Krona",
                "Code" => "SEK",
                "Symbol" => "kr",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/switzerland.png",
                "CountryName" => "Switzerland",
                "Currency" => "Franc",
                "Code" => "CHF",
                "Symbol" => "CHF",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/suriname.png",
                "CountryName" => "Suriname",
                "Currency" => "Dollar",
                "Code" => "SRD",
                "Symbol" => "$",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/syria.png",
                "CountryName" => "Syria",
                "Currency" => "Pound",
                "Code" => "SYP",
                "Symbol" => "£",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/taiwan.png",
                "CountryName" => "Taiwan",
                "Currency" => "New Dollar",
                "Code" => "TWD",
                "Symbol" => "NT$",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/thailand.png",
                "CountryName" => "Thailand",
                "Currency" => "Baht",
                "Code" => "THB",
                "Symbol" => "฿",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/trinidadandtobago.png",
                "CountryName" => "Trinidad and Tobago",
                "Currency" => "Dollar",
                "Code" => "TTD",
                "Symbol" => "TT$",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/turkey.png",
                "CountryName" => "Turkey",
                "Currency" => "Lira",
                "Code" => "TRL",
                "Symbol" => "₺",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/tuvalu.png",
                "CountryName" => "Tuvalu",
                "Currency" => "Dollar",
                "Code" => "TVD",
                "Symbol" => "$",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/ukraine.png",
                "CountryName" => "Ukraine",
                "Currency" => "Hryvna",
                "Code" => "UAH",
                "Symbol" => "₴",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/unitedkingdom.png",
                "CountryName" => "United Kingdom",
                "Currency" => "Pound",
                "Code" => "GBP",
                "Symbol" => "£",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/unitedstates.png",
                "CountryName" => "United States",
                "Currency" => "Dollar",
                "Code" => "USD",
                "Symbol" => "$",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/uruguay.png",
                "CountryName" => "Uruguay",
                "Currency" => "Peso",
                "Code" => "UYU",
                "Symbol" => "UYU",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/uzbekistan.png",
                "CountryName" => "Uzbekistan",
                "Currency" => "Som",
                "Code" => "UZS",
                "Symbol" => "лв",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/venezuela.png",
                "CountryName" => "Venezuela",
                "Currency" => "Bolivar Fuerte",
                "Code" => "VEF",
                "Symbol" => "Bs",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/vietnam.png",
                "CountryName" => "Viet Nam",
                "Currency" => "Dong",
                "Code" => "VND",
                "Symbol" => "₫",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/yemen.png",
                "CountryName" => "Yemen",
                "Currency" => "Rial",
                "Code" => "YER",
                "Symbol" => "﷼",
            ],
            [
                "Flag" =>
                    "https://www.currencyremitapp.com/wp-content/themes/currencyremitapp/images/countryimages/zimbabwe.png",
                "CountryName" => "Zimbabwe",
                "Currency" => "Dollar",
                "Code" => "ZWD",
                "Symbol" => "Z$",
            ],
        ];
    }
}
