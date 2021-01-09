<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\gvgtop;
use App\Models\gvgmvp;
use App\Models\gvglog;
use App\Models\gvgnmlog;
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
                // 'redirectUri'       => 'http://ec2-18-212-84-193.compute-1.amazonaws.com'
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
                    
                    $usersess = $user->getId();
                    $inarr = [];
                    $isAllowed = allowed::where('username',$usersess)->get();
                    if($isAllowed){
                        foreach($isAllowed as $d){
                            array_push($inarr,$d->guildId);
                        }
                        $request->session()->put('usern', $usersess);
                        $a = gvgtop::whereIn('guildDataIdA', $inarr)->orderBy('battleEndTime','Desc')->get();
        
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
            $inarr = [];
            $isAllowed = allowed::where('username',session('usern'))->get();
            if($isAllowed){
                foreach($isAllowed as $d){
                    // dd($d->guildId);return;
                    array_push($inarr,$d->guildId);
                }

                $a = gvgtop::whereIn('guildDataIdA', $inarr)->orderBy('battleEndTime','Desc')->get();
    
                // $request->session()->put('usern', $usersess);
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
        $guildAAbuff = 0;
        $guildBAbuff = 0;
        $guildAAdebuff = 0;
        $guildBAdebuff = 0;
        $guildADbuff = 0;
        $guildBDbuff = 0;
        $guildADdebuff = 0;
        $guildBDdebuff = 0;
        $sess = session('usern');
        if(!isset($sess)){
            return redirect()->route('index');
        }

        else{
            
            $inarr = [];
            $simped = [];
            $esimped = [];
            $kiss = [];
            $ekiss = [];
            $isAllowed = allowed::where('username',$sess)->get();
            if($isAllowed){
                foreach($isAllowed as $d){
                    array_push($inarr,$d->guildId);
                }
                $a = gvgtop::where('gvgDataId', $id)->get();
                $amiallowed = $a[0]->guildDataIdA;
                if(!in_array($amiallowed,$inarr)){
                    return response()->json(['You are not allowed to see this log']);
                }
                $b = gvgshinma::where('gvgDataId', $id)->leftJoin('gvgshinmadetails', 'gvgshinmas.artMstId', '=', 'gvgshinmadetails.artMstId')->get();
                $p1 = gvgmvp::where('gvgDataId', $id)->where('typeMvp','Lifeforce')->orderBy('valueA','desc')->get();
                $p2 = gvgmvp::where('gvgDataId', $id)->where('typeMvp','Recover')->orderBy('valueA','desc')->get();
                $p3 = gvgmvp::where('gvgDataId', $id)->where('typeMvp','Ally ATK Support')->orderBy('valueA','desc')->get();
                $p4 = gvgmvp::where('gvgDataId', $id)->where('typeMvp','Ally DEF Support')->orderBy('valueA','desc')->get();
                $p5 = gvgmvp::where('gvgDataId', $id)->where('typeMvp','Enemy ATK Debuff')->orderBy('valueA','desc')->get();
                $p6 = gvgmvp::where('gvgDataId', $id)->where('typeMvp','Enemy DEF Debuff')->orderBy('valueA','desc')->get();
                $p7 = gvgmvp::where('gvgDataId', $id)->where('typeMvp','Combo')->orderBy('valueA','desc')->get();
                $enemykiss = gvglog::where('gvgDataId', $id)->where('isOwnGuild',1)->where('readableText', 'like' ,'%has fainted.%')->count();
                $ownkiss = gvglog::where('gvgDataId', $id)->where('isOwnGuild',0)->where('readableText', 'like' ,'%has fainted.%')->count();
                
                $ienemykiss = gvglog::where('gvgDataId', $id)->where('isOwnGuild',1)->where('readableText', 'like' ,'%has fainted.%')->get();
                $iownkiss = gvglog::where('gvgDataId', $id)->where('isOwnGuild',0)->where('readableText', 'like' ,'%has fainted.%')->get();

                
                $selfsimp = gvglog::where('gvgDataId', $id)->where('isOwnGuild',1)->where('readableText', 'like' ,'%ATK UP%')->where('readableText', 'like' ,'%DEF UP%')->get();
                $enemy = gvglog::where('gvgDataId', $id)->where('isOwnGuild',0)->where('readableText', 'like' ,'%ATK UP%')->where('readableText', 'like' ,'%DEF UP%')->get();

                $nml = gvgnmlog::where('gvgDataId', $id)->orderBy('gvgHistoryId','asc')->get();
                // $counter = 0;
                foreach($selfsimp as $cs){
                    $cse = explode("\n", $cs->readableText);
                    $cskill = preg_grep("/(ATK UP by (.*)|DEF UP by (.*))/", $cse);

                    foreach($cskill as $crv){
                        $csve = explode("'s", $crv);   
                        array_push($simped, $csve[0]);          
                        // $simped[$counter]['name'] = $csve[0];
                        // $counter++;
                    }
          
                }
                
                foreach($iownkiss as $cs){
                    $cse = explode("\n", $cs->readableText);
                    $cskill = preg_grep("/(.*)has fainted./", $cse);
                
                    foreach($cskill as $crv){
                        $csve = explode("has", $crv);   
                        array_push($kiss, $csve[0]);          
                        // $simped[$counter]['name'] = $csve[0];
                        // $counter++;
                    }
          
                }

                foreach($ienemykiss as $cs){
                    $cse = explode("\n", $cs->readableText);
                    $cskill = preg_grep("/(.*)has fainted./", $cse);
                
                    foreach($cskill as $crv){
                        $csve = explode("has", $crv);   
                        array_push($ekiss, $csve[0]);          
                        // $simped[$counter]['name'] = $csve[0];
                        // $counter++;
                    }
          
                }

              

                foreach($enemy as $cs){
                    $cse = explode("\n", $cs->readableText);
                    $cskill = preg_grep("/(ATK UP by (.*)|DEF UP by (.*))/", $cse);

                    foreach($cskill as $crv){
                        $csve = explode("'s", $crv);   
                        array_push($esimped, $csve[0]);          
                        // $simped[$counter]['name'] = $csve[0];
                        // $counter++;
                    }
          
                }

                // usort($simped, function($a, $b) {
                //     return $a['name'] <=> $b['name'];
                // });
                // usort($simped, function ($item1) {
                //     return $item1['price'] <=> $item2['price'];
                // });
                $sm = array_count_values($simped);
                arsort($sm);
                $sm = array_keys($sm);
                $mostsimped = $sm[0];

                $km = array_count_values($kiss);
                arsort($km);
                $km = array_keys($km);
                $mostkiss = $km[0];

                $kme = array_count_values($ekiss);
                arsort($kme);
                $kme = array_keys($kme);
                $emostkiss = $kme[0];

               

                $esm = array_count_values($esimped);
                arsort($esm);
                $esm = array_keys($esm);
                $emostsimped = $esm[0];
            
                foreach($p3 as $v3){
                    $guildAAbuff += $v3->valueA;
                    $guildBAbuff += $v3->valueB;
                }
                foreach($p4 as $v3){
                    $guildADbuff += $v3->valueA;
                    $guildBDbuff += $v3->valueB;
                }
                foreach($p5 as $v3){
                    $guildAAdebuff += $v3->valueA;
                    $guildBAdebuff += $v3->valueB;
                }
                foreach($p6 as $v3){
                    $guildADdebuff += $v3->valueA;
                    $guildBDdebuff += $v3->valueB;
                }

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
                ->with('enemy',$enemy)
                ->with('nml',$nml)
                ->with('enemykiss',$enemykiss)
                ->with('ownkiss',$ownkiss)
                ->with('mostkiss',$mostkiss)
                ->with('emostkiss',$emostkiss)
                ->with('mostsimped',$mostsimped)
                ->with('emostsimped',$emostsimped)
                ->with('guildAAbuff',$guildAAbuff)
                ->with('guildBAbuff',$guildBAbuff)
                ->with('guildADbuff',$guildADbuff)
                ->with('guildBDbuff',$guildBDbuff)
                ->with('guildAAdebuff',$guildAAdebuff)
                ->with('guildBAdebuff',$guildBAdebuff)
                ->with('guildADdebuff',$guildADdebuff)
                ->with('guildBDdebuff',$guildBDdebuff);
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
            $inarr = [];
            $isAllowed = allowed::where('username',$sess)->get();
            if($isAllowed){
                foreach($isAllowed as $d){
                    array_push($inarr,$d->guildId);
                }
                $a = gvgtop::where('gvgDataId', $idmatch)->get();
                $amiallowed = $a[0]->guildDataIdA;
                if(!in_array($amiallowed,$inarr)){
                    return response()->json(['You are not allowed to see this grid']);
                }

                    $y = [];
                    $yb =[];
                    $img = [];
                    $arrdebug = [];
                    $patkvalue=0;
                    $matkvalue=0;
                    $pdefvalue=0;
                    $mdefvalue=0;
                    $patkdvalue=0;
                    $matkdvalue=0;
                    $pdefdvalue=0;
                    $mdefdvalue=0;
                    $recovervalue=0;
                    $dc1rate = 0;
                    $sb1rate = 0;
                    $rs1rate = 0;
                    $dc2rate = 0;
                    $sb2rate = 0;
                    $sb3rate = 0;
                    $rs2rate = 0;
                    // $blog = TbBlog::find($id);
                    $grid = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)->where('readableText', 'not like', '%revive%')->where('readableText', 'not like', '%guildship%')->where('readableText', 'not like', '%10 mastery earned.%')->
                        where('readableText', 'not like', '%summon skill%')->where('readableText', 'not like', '%switched with%')->
                        orderBy('gvgHistoryId','asc')->LIMIT(20)->get();
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
                  
                        if(count($theq) > 3){
                            $regexq = $theq[0]."'s". $theq[1];
                           
                        }
                        else{
                            $regexq = $theq[0];
                            
                        }
                        // $regexq = $theq[0];
                        // print($regexq . '</br>');
                        $imgquery = weapimg::where('weapname', 'like',$regexq.'%')->first();
                        if($imgquery){
                            array_push($img,$imgquery->weapurl);
                        }
                        $colosupport = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)
                        ->where('readableText', 'not like', '%revive%')->where('readableText', 'not like', '%guildship%')
                        ->where('readableText', 'not like', '%10 mastery earned.%')
                        ->where('readableText', 'not like', '%switched with%')
                        ->where('readableText', 'not like', '%summon skill%')
                        ->where('readableText', 'not like', '%'. $query2 . '%')
                        ->where('readableText', 'like', '%'. $regexq . '%')
                        ->orderBy('gvgHistoryId','asc')->limit(1)->get();

                        if(isset($colosupport[0])){
                            foreach($colosupport as $cs){
                                $cse = explode("\n", $cs->readableText);
                                $cskill = preg_grep("/^".$regexq . "/", $cse);
                                $cskill2 = implode("",$cskill);
                                // print($cskill2 . '</br>');
                                array_push($yb, preg_replace('/also activated.$/', '', $cskill2));
                            }
                        }
                        else{
                            array_push($yb, 'not found');
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
                    $thequery = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch);
                    // ->where('readableText', 'not like', '%revive%')->where('readableText', 'not like', '%guildship%')
                    // ->where('readableText', 'not like', '%10 mastery earned.%')
                    // ->where('readableText', 'not like', '%summon skill%');
                    $apm = $thequery->count();

                    $recover = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)
                    ->where('readableText', 'like', '%HP recovered by%')->get();
        
                    
                    //recover
            //    $cn = 0;
                    if(isset($recover[0])){
                        foreach($recover as $cs){
                            $cse = explode("\n", $cs->readableText);
                            $cskill = preg_grep("/HP recovered by (.*)/", $cse);
                            // $cn++;
                            foreach($cskill as $crv){
                                $csve = explode("by", $crv);

                                $v = preg_replace('/[^0-9]/', '', $csve[1]);
                                // array_push($arrdebug, $csve);
                                $recovervalue += $v;
                            }
                            // print($cskill2 . '</br>');
                        }
                    }
// dd($arrdebug);return;

                    //eof recover
                    // $querybasic = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch);
                    //patk buff

                    $patk = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)->where('readableText', 'like', '%ATK UP by%')->get();
                    $pdef = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)->where('readableText', 'like', '%DEF UP by%')->get();
                    $patkd = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)->where('readableText', 'like', '%ATK DOWN by%')->get();
                    $pdefd = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)->where('readableText', 'like', '%DEF DOWN by%')->get();
                    $rs1 = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)->where('readableText', 'like', '%Recovery Support (I)%')->count();
                    $dc1 = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)->where('readableText', 'like', '%Dauntless Courage (I)%')->count();
                    $sb1 = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)->where('readableText', 'like', '%Support Boon (I)%')->count();
                    $rs2 = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)->where('readableText', 'like', '%Recovery Support (II)%')->count();
                    $dc2 = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)->where('readableText', 'like', '%Dauntless Courage (II)%')->count();
                    $sb2 = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)->where('readableText', 'like', '%Support Boon (II)%')->count();
                    $sb3 = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)->where('readableText', 'like', '%Assistance Support (III)%')->count();

                    if($dc1>0){
                        $dc1rate = $dc1 / $apm * 100;
                    }
                    if($dc2>0){
                        $dc2rate = $dc2 / $apm * 100;
                    }
                    if($sb1>0){
                        $sb1rate = $sb1 / $apm * 100;
                    }
                    if($sb2>0){
                        $sb2rate = $sb2 / $apm * 100;
                    }
                    if($sb3>0){
                        $sb3rate = $sb3 / $apm * 100;
                    }
                    if($rs1>0){
                        $rs1rate = $rs1 / $apm * 100;
                    }
                    if($rs2>0){
                        $rs2rate = $rs2 / $apm * 100;
                    }

                    if(isset($patk[0])){

                        foreach($patk as $cs){
                            $cse = explode("\n", $cs->readableText);
                            $cskill = preg_grep("/M.ATK UP by (.*)/", $cse);
                            
                            foreach($cskill as $crv){
                                $csve = explode("by", $crv);
                                $v = preg_replace('/[^0-9]/', '', $csve[1]);
                                $matkvalue += $v;
                            }
                  
                        }

                        foreach($patk as $cs){
                            $cse = explode("\n", $cs->readableText);
                            $cskill = preg_grep("/[^M.]ATK UP by (.*)/", $cse);

                            foreach($cskill as $crv){
                                $csve = explode("by", $crv);
                                $v = preg_replace('/[^0-9]/', '', $csve[1]);                
                                $patkvalue += $v;
                            }
                  
                        }
                    }


                    if(isset($pdef[0])){

                        foreach($pdef as $cs){
                            $cse = explode("\n", $cs->readableText);
                            $cskill = preg_grep("/M.DEF UP by (.*)/", $cse);

                            foreach($cskill as $crv){
                                $csve = explode("by", $crv);
                                $v = preg_replace('/[^0-9]/', '', $csve[1]);                
                                $mdefvalue += $v;
                            }
                  
                        }

                        foreach($pdef as $cs){
                            $cse = explode("\n", $cs->readableText);
                            $cskill = preg_grep("/[^M.]DEF UP by (.*)/", $cse);

                            foreach($cskill as $crv){
                                $csve = explode("by", $crv);
                                $v = preg_replace('/[^0-9]/', '', $csve[1]);                
                                $pdefvalue += $v;
                            }
                  
                        }
                    }

                    if(isset($patkd[0])){

                        foreach($patkd as $cs){
                            $cse = explode("\n", $cs->readableText);
                            $cskill = preg_grep("/M.ATK DOWN by (.*)/", $cse);

                            foreach($cskill as $crv){
                                $csve = explode("by", $crv);
                                $v = preg_replace('/[^0-9]/', '', $csve[1]);                
                                $matkdvalue += $v;
                            }
                  
                        }

                        foreach($patkd as $cs){
                            $cse = explode("\n", $cs->readableText);
                            $cskill = preg_grep("/[^M.]ATK DOWN by (.*)/", $cse);

                            foreach($cskill as $crv){
                                $csve = explode("by", $crv);
                                $v = preg_replace('/[^0-9]/', '', $csve[1]);                
                                $patkdvalue += $v;
                            }
                  
                        }
                    }

                    if(isset($pdefd[0])){
                       
                        foreach($pdefd as $cs){
                            $cse = explode("\n", $cs->readableText);
                            $cskill = preg_grep("/M.DEF DOWN by (.*)/", $cse);

                            foreach($cskill as $crv){
                                $csve = explode("by", $crv);
                                $v = preg_replace('/[^0-9]/', '', $csve[1]);                
                                $mdefdvalue += $v;
                            }
                  
                        }

                        foreach($pdefd as $cs){
                            $cse = explode("\n", $cs->readableText);
                            $cskill = preg_grep("/[^M.]DEF DOWN by (.*)/", $cse);

                            foreach($cskill as $crv){
                                $csve = explode("by", $crv);
                                $v = preg_replace('/[^0-9]/', '', $csve[1]);                
                                $pdefdvalue += $v;
                            }
                  
                        }
                    }
        


                    //eof patkbuff



                

                    // return response()->json($y);
                    return view('grid')
                    ->with('gridlist',$y)
                    ->with('imglist',$img)
                    ->with('cololist',$yb)
                    ->with('username',$grid[0]->userName)
                    ->with('guildenemy',$guildenemy)
                    ->with('uid',$userid)
                    ->with('ide',$idmatch)
                    ->with('apm',$apm)
                    ->with('recover',number_format($recovervalue))
                    ->with('patkbuff',number_format($patkvalue))
                    ->with('matkbuff',number_format($matkvalue))
                    ->with('pdefbuff',number_format($pdefvalue))
                    ->with('mdefbuff',number_format($mdefvalue))
                    ->with('patkdebuff',number_format($patkdvalue))
                    ->with('matkdebuff',number_format($matkdvalue))
                    ->with('pdefdebuff',number_format($pdefdvalue))
                    ->with('mdefdebuff',number_format($mdefdvalue))
                    ->with('dc1rate',number_format($dc1rate))
                    ->with('sb1rate',number_format($sb1rate))
                    ->with('rs1rate',number_format($rs1rate))
                    ->with('dc2rate',number_format($dc2rate))
                    ->with('sb2rate',number_format($sb2rate))
                    ->with('rs2rate',number_format($rs2rate))
                    ->with('sb3rate',number_format($sb3rate));

        

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

                $inarr = [];
                $isAllowed = allowed::where('username',$sess)->get();
                if($isAllowed){
                    foreach($isAllowed as $d){
                        array_push($inarr,$d->guildId);
                    }
                    $a = gvgtop::where('gvgDataId', $id)->first();
                    $amiallowed = $a->guildDataIdA;
                    if(!in_array($amiallowed,$inarr)){
                        return response()->json(['You are not allowed to see this grid']);
                    }
                    
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

    public function getLogz($id,$idm, Request $request){

        $sess = session('usern');
            if(!isset($sess)){
                return redirect()->route('index');
            }
    
            else{
                $inarr = [];
                $isAllowed = allowed::where('username',$sess)->get();
                if($isAllowed){
                    foreach($isAllowed as $d){
                        array_push($inarr,$d->guildId);
                    }
                    $a = gvgtop::where('gvgDataId', $id)->first();
                    $amiallowed = $a->guildDataIdA;
                    if(!in_array($amiallowed,$inarr)){
                        return response()->json(['You are not allowed to see this grid']);
                    }
                    
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
                        
                        $totalRecords = gvglog::select('count(*) as allcount')->where('gvgDataId', $id)->where('userId', $idm)->count();
                        $totalRecordswithFilter = gvglog::select('count(*) as allcount')->where('gvgDataId', $id)->where('userId', $idm)->where('readableText', 'like', '%' .$searchValue . '%')->orWhere('gvgDataId', $id)->where('userId', $idm)->where('gvglogs.readableText', 'like', '%' .$searchValue . '%')
                    ->count();

                    // Fetch records
                            $records = gvglog::orderBy($columnName,$columnSortOrder)
                            ->where('gvgDataId', $id)
                            ->where('userId', $idm)
                            // ->where('gvglogs.userName', 'like', '%' .$searchValue . '%')
                            //   ->orWhere('gvgDataId', $id)
                            ->Where('gvglogs.readableText', 'like', '%' .$searchValue . '%')
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
