<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attendance;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $intimehours = ['09:00:00', '08:30:00', '09:05:00', '09:30:00', '11:00:00', '10:30:00'];
        $outtimehours = ['18:00:00', '17:30:00', '19:05:00', '19:30:00', '15:00:00', '20:30:00'];

        $start_date = date('Y-m-d', strtotime('first day of last month'));
        $end_date = date('Y-m-d', strtotime('last day of last month'));
        
        $origin = date_create($start_date);
        $target = date_create($end_date);
        $diff = date_diff($origin, $target); 
        
        for($x=0; $x<$diff->d; $x++) {
            $day_name = strtolower(date("l", strtotime($start_date)));
            if(($day_name != "saturday" ) && ($day_name != "sunday")){
                $intime = $start_date . ' ' . $intimehours[rand(0,5)];
                $outtime = $start_date . ' ' . $outtimehours[rand(0,5)];
                $origin = date_create($intime);
                $target = date_create($outtime);
                $interval = date_diff($origin, $target);            
                $workhour = $interval->d * 24 * 60 + $interval->h * 60 + $interval->i;
                
                Attendance::create([
                    'user_id' => 1,
                    'checkin_at' => $start_date,
                    'intime' => $intime,
                    'outtime' => $outtime,
                    'workhour' => $workhour
                ]);

                $intime = $start_date . ' ' . $intimehours[rand(0,5)];
                $outtime = $start_date . ' ' . $outtimehours[rand(0,5)];
                $origin = date_create($intime);
                $target = date_create($outtime);
                $interval = date_diff($origin, $target);
                $workhour = $interval->d * 24 * 60 + $interval->h * 60 + $interval->i;
                
                Attendance::create([
                    'user_id' => 2,
                    'checkin_at' => $start_date,
                    'intime' => $intime,
                    'outtime' => $outtime,
                    'workhour' => $workhour
                ]);
            }
            $start_date = date('Y-m-d', strtotime('+1 day', strtotime($start_date)));
        }
        
        
    }
}
