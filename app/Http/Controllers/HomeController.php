<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use DataTables;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('starter');
    }
    public function users(Request $request){
        if($request->ajax()) {
            $data = User::all();
            return DataTables::of($data)
                /*->addColumn('user_id', function($data){
                    return \App\User::find($data->user_id)->email;
                })*/
                ->addColumn('created_at', function($data){
                    return $data->created_at->format('Y-m-d H:i:s');
                })
                //->rawColumns(['action'])
                ->make(true);
            // ->toJson();
        }
        return view('users');
    }
}
