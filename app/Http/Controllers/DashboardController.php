<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\gvgtop;
use App\Models\gvgmvp;
use App\Models\gvglog;
use App\Models\gvgshinma;
use App\Models\gvgmember;
use App\Models\gvgenemymember;
use DB;
use App\Models\weapimg;

use App\Models\allowed;
use App\Models\gvgshinmadetail;
use DataTables;
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!session('usern')) {

            $provider = new \Wohali\OAuth2\Client\Provider\Discord([
                'clientId'          => '658613502415470631',
                'clientSecret'      => 'D3XIPQD8dTHOm6scdmWS9pLkoW7fubtW',
                'redirectUri'       => 'http://localhost/kureha-log/public'
            ]);
            
            if (!isset($_GET['code'])) {
      
                // Step 1. Get authorization code
                $options = [
                    'state' => 'OPTIONAL_CUSTOM_CONFIGURED_STATE',
                    'scope' => ['identify'] // array or string
                ];
                
                $authUrl = $provider->getAuthorizationUrl($options);
                $request->session()->put('oauth2state', $provider->getState());
                return redirect()->away($authUrl);
    
            } elseif (empty($_GET['state']) || ($_GET['state'] !== session('oauth2state'))) {
                $request->session()->forget('oauth2state');
                return response()->json(['Invalid State']);
            
            } else {
                
                $token = $provider->getAccessToken('authorization_code', [
                    'code' => $_GET['code']
                ]);
               
                try {
            
                    $user = $provider->getResourceOwner($token);
            
                    $usersess = $user->getUsername().'#'. $user->getDiscriminator();
                    $isAllowed = allowed::where('username',$usersess)->first();
                    if($isAllowed){
                        $request->session()->put('usern', $usersess);
                        $a = gvgtop::all();
                        // return response()->json($a);
                        return view('dashboard')->with('guild',$a);
                    }
                    else{
                        return response()->json('your Discord accounts indicates that You are not allowed to see this content or you are not Astellia, please whitelist your discord by contacting Kureha');
    
                    }
    
            
                } catch (Exception $e) {
            
                    // Failed to get user details
                    return response()->json(['Please Login to Continue']);
            
                }
            }

        }

        else{
            $isAllowed = allowed::where('username',session('usern'))->first();
            if($isAllowed){
                // $request->session()->put('usern', $usersess);
                $a = gvgtop::orderBy('battleEndTime','Desc')->get();
                // return response()->json($a);
                return view('dashboard')->with('guild',$a);
            }
            else{
                return response()->json('your Discord accounts indicates that You are not allowed to see this content or you are not Astellia, please whitelist your discord by contacting Kureha');

            }
        }

        

    }



    public function log($id, Request $request)
    {

        $sess = session('usern');
        if(!isset($sess)){
            return redirect()->route('index');
        }

        else{
            $isAllowed = allowed::where('username',$sess)->first();
            if($isAllowed){
                $a = gvgtop::where('gvgDataId', $id)->get();
                $b = gvgshinma::where('gvgDataId', $id)->leftJoin('gvgshinmadetails', 'gvgshinmas.artMstId', '=', 'gvgshinmadetails.artMstId')->get();
                $p1 = gvgmvp::where('gvgDataId', $id)->where('typeMvp','Lifeforce')->orderBy('valueA','desc')->get();
                $p2 = gvgmvp::where('gvgDataId', $id)->where('typeMvp','Recover')->orderBy('valueA','desc')->get();
                $p3 = gvgmvp::where('gvgDataId', $id)->where('typeMvp','Ally ATK Support')->orderBy('valueA','desc')->get();
                $p4 = gvgmvp::where('gvgDataId', $id)->where('typeMvp','Ally DEF Support')->orderBy('valueA','desc')->get();
                $p5 = gvgmvp::where('gvgDataId', $id)->where('typeMvp','Enemy ATK Debuff')->orderBy('valueA','desc')->get();
                $p6 = gvgmvp::where('gvgDataId', $id)->where('typeMvp','Enemy DEF Debuff')->orderBy('valueA','desc')->get();
                $p7 = gvgmvp::where('gvgDataId', $id)->where('typeMvp','Combo')->orderBy('valueA','desc')->get();
                $ally = gvgmember::where('gvgDataId', $id)->get();
                $enemy = gvgenemymember::where('gvgDataId', $id)->get();
        
                // return response()->json($a);
                return view('log')->with('guild',$a)
                ->with('shinma',$b)
                ->with('p1',$p1)
                ->with('p2',$p2)
                ->with('p3',$p3)
                ->with('p4',$p4)
                ->with('p5',$p5)
                ->with('p6',$p6)
                ->with('p7',$p7)
                ->with('ide',$id)
                ->with('ally',$ally)
                ->with('enemy',$enemy);
                ;
            }
            else{
                return response()->json(['Not Astellians']);

            }
        }


    

    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function showGrid($userid, $idmatch, Request $request)
        {

            $sess = session('usern');
            if(!isset($sess)){
                return redirect()->route('index');
            }
    
            else{
                $isAllowed = allowed::where('username',$sess)->first();
                if($isAllowed){

                    $a = gvgtop::where('gvgDataId', $idmatch)->get();
                    $y = [];
                    $yb =[];
                    $img = [];
                    // $blog = TbBlog::find($id);
                    $grid = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)->where('readableText', 'not like', '%revive%')->where('readableText', 'not like', '%guildship%')->where('readableText', 'not like', '%10 mastery earned.%')->
                        where('readableText', 'not like', '%summon skill%')->orderBy('gvgHistoryId','asc')->LIMIT(20)->get();
                    foreach($grid as $g){
        
                        $thearr = explode("\n", $g->readableText);
                        if(preg_match('/combo.$/', $thearr[0])){
                            array_push($y, preg_replace('/activated.$/', '', $thearr[1]));
                        } 
                        else{
                            array_push($y, preg_replace('/activated.$/', '', $thearr[0]));
                        }
                        // .*\.ccf$
                    }
                    foreach($y as $ys){
                        // /^\d\d:\d\d$/;
                        // ^s.*s$
                        // $theq = preg_replace("/^Spear of Languor's/", '', $ys);
                        $query2 = $ys.'activated.';
                        $theq = explode("'s", $ys);
                  
                        // if(isset($theq[2])){
                        //     $regexq = $theq[0]."'s". $theq[1];
                           
                        // }
                        // else{
                        //     $regexq = $theq[0];
                            
                        // }
                        $regexq = $theq[0];
                        // print($regexq . '</br>');
                        $imgquery = weapimg::where('weapname', 'like','%'.$regexq.'%')->first();
                        if($imgquery){
                            array_push($img,$imgquery->weapurl);
                        }
                        $colosupport = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)
                        ->where('readableText', 'not like', '%revive%')->where('readableText', 'not like', '%guildship%')
                        ->where('readableText', 'not like', '%10 mastery earned.%')
                        ->where('readableText', 'not like', '%summon skill%')
                        ->where('readableText', 'not like', '%'. $query2 . '%')
                        ->where('readableText', 'like', '%'. $regexq . '%')
                        ->orderBy('gvgHistoryId','asc')->limit(1)->get();

                        
                        foreach($colosupport as $cs){
                            $cse = explode("\n", $cs->readableText);
                            $cskill = preg_grep("/^".$regexq . "/", $cse);
                            $cskill2 = implode("",$cskill);
                            // print($cskill2 . '</br>');
                            array_push($yb, preg_replace('/also activated.$/', '', $cskill2));
                        }

                        

                    }
                    // dd($img);return;
                    // $finres =[];
                    // dd($y,$yb);return;
                    // for($i=0;$i<count($y);$i++){
                    //     // array_push($finres, "Colo Skill : " .$y[$i]."\n Colo Support : ".$yb[$i]);
                    //     $finres[$i]['coloskill'] = $y[$i];
                    //     $finres[$i]['colosupp'] = $yb[$i];

                    // }
                                
                    if($grid[0]->isOwnGuild == 1){ 
                        $guildenemy = $a[0]->guildDataNameB;
                    }
                    else{ $guildenemy = $a[0]->guildDataNameA;}
        
                    // return response()->json($y);
                    return view('grid')->with('gridlist',$y)->with('imglist',$img)->with('cololist',$yb)->with('username',$grid[0]->userName)->with('guildenemy',$guildenemy);
        

                }
                else{
                    return response()->json(['Not Astellians']);
    
                }
            }
    
    }

    public function getLog($id, Request $request){

        $sess = session('usern');
            if(!isset($sess)){
                return redirect()->route('index');
            }
    
            else{
                $isAllowed = allowed::where('username',$sess)->first();
                if($isAllowed){

                        ## Read value
                        $draw = $request->get('draw');
                        $start = $request->get("start");
                        $rowperpage = $request->get("length"); // Rows display per page

                        $columnIndex_arr = $request->get('order');
                        $columnName_arr = $request->get('columns');
                        $order_arr = $request->get('order');
                        $search_arr = $request->get('search');

                        $columnIndex = $columnIndex_arr[0]['column']; // Column index
                        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
                        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
                        $searchValue = $search_arr['value']; // Search value
                        
                        // Total records
                        $totalRecords = gvglog::select('count(*) as allcount')->where('gvgDataId', $id)->count();
                        $totalRecordswithFilter = gvglog::select('count(*) as allcount')->where('gvgDataId', $id)->where('userName', 'like', '%' .$searchValue . '%')->orWhere('gvgDataId', $id)->Where('gvglogs.readableText', 'like', '%' .$searchValue . '%')
                        ->count();

                        // Fetch records
                        $records = gvglog::orderBy($columnName,$columnSortOrder)
                        ->where('gvgDataId', $id)
                        ->where('gvglogs.userName', 'like', '%' .$searchValue . '%')
                        //   ->orWhere('gvgDataId', $id)
                        //   ->Where('gvglogs.readableText', 'like', '%' .$searchValue . '%')
                        ->select('gvglogs.*')
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();

                        $data_arr = array();
                        
                        foreach($records as $record){
                        $id = $record->gvgHistoryId;
                        $actTime = $record->actTime;
                        $username = $record->userName;
                        $isenemy = $record->isOwnGuild;
                        $text = $record->readableText;

                        $data_arr[] = array(
                            "id" => $id,
                            "actTime" => $actTime,
                            "username" => $username,
                            "isenemy" => ($isenemy)?'Ally':'Enemy',
                            "text" => $text,
                        );
                        }

                        $response = array(
                        "draw" => intval($draw),
                        "iTotalRecords" => $totalRecords,
                        "iTotalDisplayRecords" => $totalRecordswithFilter,
                        "aaData" => $data_arr
                        );

                        return json_encode($response);

                }
                else{
                    return response()->json(['Not Astellians']);
    
                }
            }


      }

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
}
