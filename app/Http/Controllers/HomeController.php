<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notice;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $notices = Notice::latest()->limit(8)->get(); 
        return view('home', ['notices' => $notices]);
    }

    public function migrateTables(Request $request)
    {
        //$tenant = session('tenant');
        if($request->ajax())
        {
            return 'yes';
        }
        /*
        if($request->ajax())
        {
            Schema::connection('mysql')->create('downloads', function(Blueprint $table){

            });
        
        }
        */
    }
   
}
