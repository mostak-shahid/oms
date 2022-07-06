<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function general(){
        $settings = Setting::all();
        $timeZones = array(
            'Africa' => array(
                "Africa/Abidjan"=>"Abidjan",
                "Africa/Accra"=>"Accra",
                "Africa/Addis_Ababa"=>"Addis Ababa",
                "Africa/Algiers"=>"Algiers",
                "Africa/Asmara"=>"Asmara",
                "Africa/Bamako"=>"Bamako",
                "Africa/Bangui"=>"Bangui",
                "Africa/Banjul"=>"Banjul",
                "Africa/Bissau"=>"Bissau",
                "Africa/Blantyre"=>"Blantyre",
                "Africa/Brazzaville"=>"Brazzaville",
                "Africa/Bujumbura"=>"Bujumbura",
                "Africa/Cairo"=>"Cairo",
                "Africa/Casablanca"=>"Casablanca",
                "Africa/Ceuta"=>"Ceuta",
                "Africa/Conakry"=>"Conakry",
                "Africa/Dakar"=>"Dakar",
                "Africa/Dar_es_Salaam"=>"Dar es Salaam",
                "Africa/Djibouti"=>"Djibouti",
                "Africa/Douala"=>"Douala",
                "Africa/El_Aaiun"=>"El Aaiun",
                "Africa/Freetown"=>"Freetown",
                "Africa/Gaborone"=>"Gaborone",
                "Africa/Harare"=>"Harare",
                "Africa/Johannesburg"=>"Johannesburg",
                "Africa/Juba"=>"Juba",
                "Africa/Kampala"=>"Kampala",
                "Africa/Khartoum"=>"Khartoum",
                "Africa/Kigali"=>"Kigali",
                "Africa/Kinshasa"=>"Kinshasa",
                "Africa/Lagos"=>"Lagos",
                "Africa/Libreville"=>"Libreville",
                "Africa/Lome"=>"Lome",
                "Africa/Luanda"=>"Luanda",
                "Africa/Lubumbashi"=>"Lubumbashi",
                "Africa/Lusaka"=>"Lusaka",
                "Africa/Malabo"=>"Malabo",
                "Africa/Maputo"=>"Maputo",
                "Africa/Maseru"=>"Maseru",
                "Africa/Mbabane"=>"Mbabane",
                "Africa/Mogadishu"=>"Mogadishu",
                "Africa/Monrovia"=>"Monrovia",
                "Africa/Nairobi"=>"Nairobi",
                "Africa/Ndjamena"=>"Ndjamena",
                "Africa/Niamey"=>"Niamey",
                "Africa/Nouakchott"=>"Nouakchott",
                "Africa/Ouagadougou"=>"Ouagadougou",
                "Africa/Porto-Novo"=>"Porto-Novo",
                "Africa/Sao_Tome"=>"Sao Tome",
                "Africa/Tripoli"=>"Tripoli",
                "Africa/Tunis"=>"Tunis",
                "Africa/Windhoek"=>"Windhoek",
            ),
        );
        return view('settings.general', compact('settings'));
    }
}
