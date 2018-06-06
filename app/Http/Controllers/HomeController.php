<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('home');
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
