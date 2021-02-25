<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
use DataTables;

use App\Models\Attendance;
use App\Models\User;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $arr = [];
        $users = User::all();
        if ($request->date) {
            //02/01/2021 - 03/28/2021
            $arr = explode(' to ', $request->date);
        }
        //$attendances = Attendance::orderBy('created_at','desc')->paginate(1);
        //$attendances = Attendance::orderBy('created_at','desc')->get();
        //$attendances = Attendance::all();
        if (sizeof($arr)>1){
            $attendances = DB::table('attendances')
                ->whereBetween('checkin_at', array($arr[0], $arr[1]))
                ->join('users', 'users.id', '=', 'attendances.user_id')
                ->select('attendances.*', 'users.email')
                ->get();
        } else {
            $attendances = DB::table('attendances')
                ->join('users', 'users.id', '=', 'attendances.user_id')
                ->select('attendances.*', 'users.email')
                ->get();
            
        }
        if($request->ajax()) {
            //$attendances = Attendance::all();
            return DataTables::of($attendances)
                ->addColumn('user_id', function($attendances){
                    return '<div class="d-flex justify-content-between with-action"><span clas="email">' . $attendances->email . '</span><span class="action-controls smooth"><a href="#" class="text-warning edit-button-modal" data-id="'.$attendances->id.'"><i class="fa fa-edit"></i></a><a href="'.route('attendance.destroy', ['id'=>$attendances->id]).'" data-id="'.$attendances->id.'"  class="text-danger delete-button-modal"><i class="fa fa-trash"></i></a><a href="'.route('attendance.destroy', ['id'=>$attendances->id]).'" data-id="'.$attendances->id.'" class="text-danger note-button-modal"><i class="fa fa-file-alt"></i></a></span></div>';
                })
                ->addColumn('workhour', function($attendances){
                    return number_format($attendances->workhour/60,2);
                })
                ->rawColumns(['user_id'])
                ->make(true);
                // ->toJson();
        }
        return view('attendance.index', compact('users'));
    }
    public function byuser(Request $request)
    {
        $users = User::all();
        $arr = [];
        if ($request->date) {
            //02/01/2021 - 03/28/2021
            $arr = explode(' to ', $request->date);
        }
        if (sizeof($arr)>1){
            $attendances = DB::table('attendances')
                ->leftJoin('users as U','U.id','=','attendances.user_id')
                ->leftJoin('profiles as P', 'P.user_id', '=', 'attendances.user_id')
                ->select(
                    'attendances.user_id',
                    'U.name',
                    'U.email',
                    DB::raw("CASE P.meta_key WHEN 'designation' THEN P.meta_value END designation"),
                    DB::raw("COUNT(attendances.checkin_at) AS days"),
                    DB::raw("SUM(attendances.workhour) AS hours")
                )
                ->whereBetween('checkin_at', [$arr[0], $arr[1]])
                ->groupBy('attendances.user_id')
                ->get();
        } else {
            $attendances = DB::table('attendances')
                ->leftJoin('users as U','U.id','=','attendances.user_id')
                ->leftJoin('profiles as P', 'P.user_id', '=', 'attendances.user_id')
                ->select(
                    'attendances.user_id',
                    'U.name',
                    'U.email',
                    DB::raw("CASE P.meta_key WHEN 'designation' THEN P.meta_value END designation"),
                    DB::raw("COUNT(attendances.checkin_at) AS days"),
                    DB::raw("SUM(attendances.workhour) AS hours")
                )
                ->groupBy('attendances.user_id')
                ->get();
            
        }

        if($request->ajax()) {
            //$attendances = Attendance::all();
            return DataTables::of($attendances)
                ->addColumn('workhour', function($attendances){
                    return number_format($attendances->hours/60,2);
                })
                //->rawColumns(['workhour'])
                ->make(true);
                // ->toJson();
        }
        return view('attendance.byuser', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('attendance.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $workhour = 0;
        $this->validate($request, [
            'user_id' => array('required', 'string'),
            'checkin_at' => array('required', 'string'),
            'intime' => array('required', 'string'),
            'outtime' => array('nullable', 'string'),
        ]);
        $attendance = Attendance::where('checkin_at', $request->checkin_at)->where('user_id', $request->user_id)->first();
        if (!$attendance){
            if ($request->outtime) {
                $origin = date_create($request->intime);
                $target = date_create($request->outtime);
                $diff = date_diff($origin, $target);
                $workhour = $diff->d * 24 * 60 + $diff->h * 60 + $diff->i;
            }
            Attendance::create([
                'user_id' => $request->user_id,
                'checkin_at' => $request->checkin_at,
                'intime' => $request->intime,
                'outtime' => $request->outtime,
                'workhour' => $workhour,
            ]);
            Session::flash('success', 'Attendance added successfully.');
        } else {
            Session::flash('error', 'Attendance have added before.');
        }
        return redirect()->back();
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
    public function ajaxsingle(Request $request, $id)
    {
        //dd($request->all());
        //$attendance = Attendance::find($id);
        
        $attendance = DB::table('attendances')
            ->join('users', 'users.id', '=', 'attendances.user_id')
            ->select('attendances.*', 'users.email')
            ->where('attendances.id', $id)
            ->first();
        return response()->json($attendance);
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
        $workhour = 0;
        $this->validate($request, [
            'user_id' => array('required', 'string'),
            'checkin_at' => array('required', 'string'),
            'intime' => array('required', 'string'),
            'outtime' => array('nullable', 'string'),
        ]);
        if ($request->outtime) {
            $origin = date_create($request->intime);
            $target = date_create($request->outtime);
            $diff = date_diff($origin, $target);
            $workhour = $diff->d * 24 * 60 + $diff->h * 60 + $diff->i;
        }
        $attendance = Attendance::findOrFail($request->id);
        $attendance->user_id = $request->user_id;
        $attendance->checkin_at = $request->checkin_at;
        $attendance->intime = $request->intime;
        $attendance->outtime = $request->outtime;
        $attendance->workhour = $workhour;
        $attendance->save();
        Session::flash('success', 'Attendance has been updated.');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        //dd($request->id);
        Attendance::destroy($request->id);
        Session::flash('success', 'Attendance has been deleted.');
        return redirect()->back();        
    }
}
