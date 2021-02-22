<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Session;
use DataTables;

use App\Models\Attendance;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$attendances = Attendance::orderBy('created_at','desc')->paginate(1);
        //$attendances = Attendance::orderBy('created_at','desc')->get();
        $attendances = Attendance::all();

        if($request->ajax()) {
            //$attendances = Attendance::all();
            return DataTables::of($attendances)
                /*->addColumn('workhour', function($data){
                    return $data->created_at . ' - (' . $data->created_at->diffForHumans() . ')';
                })
                ->rawColumns(['workhour'])*/
                ->make(true);
                // ->toJson();
        }
        return view('attendance.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        //
    }
    public function checkin()
    {
        $user_id = Auth::id();
        $attendance = Attendance::where('user_id', $user_id)->where('checkin_at', date('Y-m-d'))->get();
        if ($attendance->count()) {            
            Session::flash('error', 'You have already checked in for working.');
            return redirect()->back();
        }
        Attendance::create([
            'user_id' => Auth::id(),
            'checkin_at' => date('Y-m-d'),
            'intime' => date('Y-m-d H:i:s'),
        ]);
        Session::flash('success', 'You have checked in for working.');
        return redirect()->back();
    }
    public function checkout()
    {
        $user_id = Auth::id();
        $attendance = Attendance::where('user_id', $user_id)->where('checkin_at', date('Y-m-d'))->orderBy('id','DESC')->first();
        if (!$attendance->outtime) {
            $attendance->outtime = date('Y-m-d H:i:s');
            $attendance->workhour = 8*60*60;
            $attendance->save();
            Session::flash('success', 'You have checked out for today.');
        }
        return redirect()->back();
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
