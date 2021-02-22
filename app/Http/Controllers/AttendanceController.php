<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $attendances = DB::table('attendances')
            ->join('users', 'users.id', '=', 'attendances.user_id')
            ->select('attendances.*', 'users.email')
            ->get();

        if($request->ajax()) {
            //$attendances = Attendance::all();
            return DataTables::of($attendances)
                ->addColumn('user_id', function($attendances){
                    return $attendances->email;
                })
                ->addColumn('workhour', function($attendances){
                    return number_format($attendances->workhour/60,2);
                })
                //->rawColumns(['workhour'])
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
        return view('attendance.create');
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
            
            $origin = date_create($attendance->intime);
            $target = date_create($attendance->outtime);
            $interval = date_diff($origin, $target);
            
            $attendance->workhour = $interval->d * 24 * 60 + $interval->h * 60 + $interval->i;
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
