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
use App\Models\gvgshinmadetail;
use DataTables;
class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $a = gvgtop::all();
        // return response()->json($a);
        return view('dashboard')->with('guild',$a);
    }



    public function log($id, Request $request)
    {
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function showGrid($userid, $idmatch, Request $request)
        {
            $a = gvgtop::where('gvgDataId', $idmatch)->get();
            $y = [];
            // $blog = TbBlog::find($id);
            $grid = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)->where('readableText', 'not like', '%revive%')->where('readableText', 'not like', '%guildship%')->where('readableText', 'not like', '%10 mastery earned.%')->
where('readableText', 'not like', '%summon skill%')->
orderBy('gvgHistoryId','asc')->LIMIT(20)->get();
         foreach($grid as $g){

                $thearr = explode("\n", $g->readableText);
                if(preg_match('/combo.$/', $thearr[0])){
                    array_push($y, preg_replace('/activated.$/', '', $thearr[1]));
                } 
                else{
                    array_push($y, preg_replace('/activated.$/', '', $thearr[0]));
                }

            }
            if($grid[0]->isOwnGuild == 1){ 
                $guildenemy = $a[0]->guildDataNameB;
            }
            else{ $guildenemy = $a[0]->guildDataNameA;}

            // return response()->json($y);
            return view('grid')->with('gridlist',$y)->with('username',$grid[0]->userName)->with('guildenemy',$guildenemy);
        }

    public function getLog($id, Request $request){

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
