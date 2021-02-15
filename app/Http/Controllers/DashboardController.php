<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\gvgtop;
use App\Models\gvgmvp;
use App\Models\gvglog;
use App\Models\gcrank;
use App\Models\gvgnmlog;
use App\Models\gvgshinma;
use App\Models\gvgmember;
use App\Models\gvgenemymember;
use Carbon\Carbon;
use DB;
use Config;
use Spatie\WebhookServer\WebhookCall;
use App\Models\weapimg;
use App\Models\weapskill;
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
        $inarr = [];
        if (!session('usern')) {

            $provider = new \Wohali\OAuth2\Client\Provider\Discord([
                'clientId'          => Config::get('app.disc-client-id'),
                'clientSecret'      => Config::get('app.disc-client-secret'),
                'redirectUri'       => Config::get('app.disc-client-uri')
                //  'redirectUri'       => 'http://localhost/kureha-log/public'

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
                    $indev = Config::get('app.debug') ? ' (Development Mode)' : '';
                    $user = $provider->getResourceOwner($token);
                    $this->dispatchWebhook($user->getUsername() . '#' . $user->getDiscriminator() . ' Logged in to site ' . $indev);
                    $usersess = $user->getId();
                    $inarr = [];
                    $checkdemo = allowed::where('username',$usersess)->where('guildId','54')->count();
                    if($checkdemo == 0){
                        $givedemo = new allowed;
                        $givedemo->username = $user->getId();
                        $givedemo->guildId = '54';
                        $givedemo->save();
                    }
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

            $shinma1contribarrSelf = [];
            $shinma1contribarrEnemy = [];
            $shinma2contribarrSelf = [];
            $shinma2contribarrEnemy = [];


            $lifeforcenameA = [];
            $lifeforcearrayA = [];
            $lifeforcearrayB = [];

            $recovernameA = [];
            $recoverarrayA = [];
            $recoverarrayB = [];

            $atkbuffnamearrayA = [];
            $atkbuffvaluearrayA = [];
            $atkbuffvaluearrayB = [];

            $defbuffnamearrayA = [];
            $defbuffvaluearrayA = [];
            $defbuffvaluearrayB = [];

            $atkdebuffnamearrayA = [];
            $atkdebuffvaluearrayA = [];
            $atkdebuffvaluearrayB = [];

            $defdebuffnamearrayA = [];
            $defdebuffvaluearrayA = [];
            $defdebuffvaluearrayB = [];
            $isAllowed = allowed::where('username',$sess)->get();
            if($isAllowed){
                foreach($isAllowed as $d){
                    array_push($inarr,$d->guildId);
                }
                $a = gvgtop::where('gvgDataId', $id)->get();
                if(count($a) == 0){
                    return response()->json(['match/grid not available']);
                }
                $amiallowed = $a[0]->guildDataIdA;
                if(!in_array($amiallowed,$inarr)){
                    return response()->json(['You are not allowed to see this log']);
                }
                $b = gvgshinma::where('gvgDataId', $id)->leftJoin('gvgshinmadetails', 'gvgshinmas.artMstId', '=', 'gvgshinmadetails.artMstId')->get();
                
                    $s1w = explode("effectiveness of ", $b[0]->description);
                    $shinma1weapon = explode(", ", $s1w[1]);
                    $shinma1weapon[2] = preg_replace('/\band \b/i', '', $shinma1weapon[2]);
                    $shinma1weapon[2] = preg_replace('/\bskills\b/i', '', $shinma1weapon[2]);
                    $shinma1weapon[2] = preg_replace('/\s/', '', $shinma1weapon[2]);
                    $shinma1weapon[2] = preg_replace('/\./', '', $shinma1weapon[2]);
                    if(in_array('heavy',$shinma1weapon)){
                        $shinma1weapon[0] = 'hammer';
                        $shinma1weapon[1] = 'bow';

                    }

                    $s2w = explode("effectiveness of ", $b[1]->description);
                    $shinma2weapon = explode(", ", $s2w[1]);
                    $shinma2weapon[2] = preg_replace('/\band \b/i', '', $shinma2weapon[2]);
                    $shinma2weapon[2] = preg_replace('/\bskills\b/i', '', $shinma2weapon[2]);
                    $shinma2weapon[2] = preg_replace('/\s/', '', $shinma2weapon[2]);
                    $shinma2weapon[2] = preg_replace('/\./', '', $shinma2weapon[2]);
                    if(in_array('heavy',$shinma2weapon)){
                        $shinma2weapon[0] = 'hammer';
                        $shinma2weapon[1] = 'bow';

                    }
                    
                    $shinma1 = gvgnmlog::where('gvgDataId', $id)->where('readableText','like','%'.$b[0]->name.'%')->orderBy('actTime')->get();
                    $shinma2 = gvgnmlog::where('gvgDataId', $id)->where('readableText','like','%'.$b[1]->name.'%')->orderBy('actTime')->get();
                    $shinma1start = isset($shinma1[0]) ? $shinma1[0]->actTime : 999999999999;
                    $shinma1end = isset($shinma1[1]) ? $shinma1[1]->actTime : gvgnmlog::where('gvgDataId', $id)->orderBy('actTime','DESC')->first()->actTime;
                    $shinma1selftotal = $b[0]->guildACount;
                    $shinma1enemytotal = $b[0]->guildBCount;
                    $shinma1selfctr = 0;
                    $shinma1enemyctr = 0;
                    $shinma2start = isset($shinma2[0]) ? $shinma2[0]->actTime : 999999999999;
                    $shinma2end = isset($shinma2[1]) ? $shinma2[1]->actTime : gvgnmlog::where('gvgDataId', $id)->orderBy('actTime','DESC')->first()->actTime;
                    $shinma2selftotal = $b[1]->guildACount;
                    $shinma2enemytotal = $b[1]->guildBCount;
                    $shinma2selfctr = 0;
                    $shinma2enemyctr = 0;
                    $shinma1SelfContrib = gvglog::where('gvgDataId', $id)->where('readableText', 'not like', '%revive%')->where('readableText', 'not like', '%guildship%')->where('readableText', 'not like', '%10 mastery earned.%')->
                    where('readableText', 'not like', '%summon skill%')->where('readableText', 'not like', '%switched with%')->where('readableText', 'not like', '%HP recovered.%')->where('readableText', 'not like', '%Preparing to summon%')->where('readableText', 'not like', '%lifeforce%')->whereBetween('actTime', [$shinma1start, $shinma1end])->get();
                    
                    $shinma2SelfContrib = gvglog::where('gvgDataId', $id)->where('readableText', 'not like', '%revive%')->where('readableText', 'not like', '%guildship%')->where('readableText', 'not like', '%10 mastery earned.%')->
                    where('readableText', 'not like', '%summon skill%')->where('readableText', 'not like', '%switched with%')->where('readableText', 'not like', '%HP recovered.%')->where('readableText', 'not like', '%Preparing to summon%')->where('readableText', 'not like', '%lifeforce%')->whereBetween('actTime', [$shinma2start, $shinma2end])->get();
                    foreach($shinma1SelfContrib as $g){

                        $thearr = explode("\n", $g->readableText);
                        if(preg_match('/combo.$/', $thearr[0])){
                            $strt = preg_replace('/activated.$/', '', $thearr[1]);
                        }
                        else{
                            $strt = preg_replace('/activated.$/', '', $thearr[0]);
                        }

                        $theq = explode("'s", $strt);
    
                            if(count($theq) > 3){
                                $regexq = $theq[0]."'s". $theq[1];
    
                            }
                            if(count($theq) == 3){
                                $regexq = $theq[0];
                                $iq = weapimg::where('weapname', 'like',$regexq.'%')->count();
                                if($iq > 1){
                                    $regexq = $regexq = $theq[0]."'s". $theq[1];
                                }
    
    
                            }
                            else{
                                $regexq = $theq[0];
    
                            }
                            // $regexq = $theq[0];
                            // print($regexq . '</br>');
                            $imgquery = weapimg::where('weapname', 'like',$regexq.'%')->first();
                            
    
                            if($imgquery){
                                $wt = $imgquery->weaptype;
                            }
                            if(!$imgquery){
                                $wt = 'Not recognized';
    
                            }

                            // $attr = [
                            //     'userId' => $g->userId,
                            //     'userName' => $g->userName,
                            //     'weapName' => $strt,
                            //     'weapType' => $wt
                            // ];
                                if(in_array(strtolower($wt), $shinma1weapon) || $wt == 'Not recognized'){
                                    if($g->isOwnGuild == 0){
                                        if($shinma1enemyctr != $shinma1enemytotal){
                                            array_push($shinma1contribarrEnemy, $g->userName);
                                            $shinma1enemyctr++;
                                        }

                                    }

                                    else{
                                        if($shinma1selfctr != $shinma1selftotal){
                                            array_push($shinma1contribarrSelf, $g->userName);
                                            $shinma1selfctr++;

                                        }
                                    }
 
                                }

                                if($shinma1enemyctr == $shinma1enemytotal && $shinma1selfctr == $shinma1selftotal ){
                                    break;
                                }
                    }

                    foreach($shinma2SelfContrib as $g){

                        $thearr = explode("\n", $g->readableText);
                        if(preg_match('/combo.$/', $thearr[0])){
                            $strt = preg_replace('/activated.$/', '', $thearr[1]);
                        }
                        else{
                            $strt = preg_replace('/activated.$/', '', $thearr[0]);
                        }

                        $theq = explode("'s", $strt);
    
                            if(count($theq) > 3){
                                $regexq = $theq[0]."'s". $theq[1];
    
                            }
                            if(count($theq) == 3){
                                $regexq = $theq[0];
                                $iq = weapimg::where('weapname', 'like',$regexq.'%')->count();
                                if($iq > 1){
                                    $regexq = $regexq = $theq[0]."'s". $theq[1];
                                }
    
    
                            }
                            else{
                                $regexq = $theq[0];
    
                            }
                            // $regexq = $theq[0];
                            // print($regexq . '</br>');
                            $imgquery = weapimg::where('weapname', 'like',$regexq.'%')->first();
                            
    
                            if($imgquery){
                                $wt = $imgquery->weaptype;
                            }
                            if(!$imgquery){
                                $wt = 'Not recognized';
    
                            }

                            // $attr = [
                            //     'userId' => $g->userId,
                            //     'userName' => $g->userName,
                            //     'weapName' => $strt,
                            //     'weapType' => $wt
                            // ];

                                if(in_array(strtolower($wt), $shinma2weapon) || $wt == 'Not recognized'){
                                    if($g->isOwnGuild == 0){
                                        if($shinma2enemyctr != $shinma2enemytotal){
                                            array_push($shinma2contribarrEnemy, $g->userName);
                                            $shinma2enemyctr++;
                                        }

                                    }

                                    else{
                                        if($shinma2selfctr != $shinma2selftotal){
                                            array_push($shinma2contribarrSelf, $g->userName);
                                            $shinma2selfctr++;

                                        }
                                    }
                                }

                                if($shinma2enemyctr == $shinma2enemytotal && $shinma2selfctr == $shinma2selftotal){
                                    break;
                                }
                    }

                    // dd($shinma1contribarrEnemy);
                    $shinma1contribarrEnemy = array_count_values($shinma1contribarrEnemy);
                    arsort($shinma1contribarrEnemy);
                    $s1enemyK = array_keys($shinma1contribarrEnemy);
                    $s1enemyV = array_values($shinma1contribarrEnemy);

                    $shinma1contribarrSelf = array_count_values($shinma1contribarrSelf);
                    arsort($shinma1contribarrSelf);
                    $s1selfK = array_keys($shinma1contribarrSelf);
                    $s1selfV = array_values($shinma1contribarrSelf);

                    $shinma2contribarrEnemy = array_count_values($shinma2contribarrEnemy);
                    arsort($shinma2contribarrEnemy);
                    $s2enemyK = array_keys($shinma2contribarrEnemy);
                    $s2enemyV = array_values($shinma2contribarrEnemy);

                    $shinma2contribarrSelf = array_count_values($shinma2contribarrSelf);
                    arsort($shinma2contribarrSelf);
                    $s2selfK = array_keys($shinma2contribarrSelf);
                    $s2selfV = array_values($shinma2contribarrSelf);

          
                $p1 = gvgmvp::where('gvgDataId', $id)->where('typeMvp','Lifeforce')->orderBy('valueA','desc')->get();
                foreach($p1 as $v){
                    array_push($lifeforcenameA, $v->nameA . ' vs ' . $v->nameB);
                    array_push($lifeforcearrayA, $v->valueA);
                    array_push($lifeforcearrayB, $v->valueB);
                }
                $p2 = gvgmvp::where('gvgDataId', $id)->where('typeMvp','Recover')->orderBy('valueA','desc')->get();
                foreach($p2 as $v){
                    array_push($recovernameA, $v->nameA . ' vs ' . $v->nameB);
                    array_push($recoverarrayA, $v->valueA);
                    array_push($recoverarrayB, $v->valueB);
                }
                
                $p3 = gvgmvp::where('gvgDataId', $id)->where('typeMvp','Ally ATK Support')->orderBy('valueA','desc')->get();
                foreach($p3 as $v){
                    array_push($atkbuffnamearrayA, $v->nameA . ' vs ' . $v->nameB);
                    array_push($atkbuffvaluearrayA, $v->valueA);
                    array_push($atkbuffvaluearrayB, $v->valueB);
                }

                $p4 = gvgmvp::where('gvgDataId', $id)->where('typeMvp','Ally DEF Support')->orderBy('valueA','desc')->get();
                foreach($p4 as $v){
                    array_push($defbuffnamearrayA, $v->nameA . ' vs ' . $v->nameB);
                    array_push($defbuffvaluearrayA, $v->valueA);
                    array_push($defbuffvaluearrayB, $v->valueB);
                }
                $p5 = gvgmvp::where('gvgDataId', $id)->where('typeMvp','Enemy ATK Debuff')->orderBy('valueA','desc')->get();
                foreach($p5 as $v){
                    array_push($atkdebuffnamearrayA, $v->nameA . ' vs ' . $v->nameB);
                    array_push($atkdebuffvaluearrayA, $v->valueA);
                    array_push($atkdebuffvaluearrayB, $v->valueB);
                }
                $p6 = gvgmvp::where('gvgDataId', $id)->where('typeMvp','Enemy DEF Debuff')->orderBy('valueA','desc')->get();
                foreach($p6 as $v){
                    array_push($defdebuffnamearrayA, $v->nameA . ' vs ' . $v->nameB);
                    array_push($defdebuffvaluearrayA, $v->valueA);
                    array_push($defdebuffvaluearrayB, $v->valueB);
                }
                $p7 = gvgmvp::where('gvgDataId', $id)->where('typeMvp','Combo')->orderBy('valueA','desc')->get();
                $enemykiss = gvglog::where('gvgDataId', $id)->where('isOwnGuild',1)->where('readableText', 'like' ,'%has fainted.%')->count();
                $ownkiss = gvglog::where('gvgDataId', $id)->where('isOwnGuild',0)->where('readableText', 'like' ,'%has fainted.%')->count();
                $crit = gvglog::where('gvgDataId', $id)->where('isOwnGuild',1)->where('readableText', 'like' ,'%critical hit%')->count();
                $crite = gvglog::where('gvgDataId', $id)->where('isOwnGuild',0)->where('readableText', 'like' ,'%critical hit%')->count();

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
                return view('log', compact('lifeforcenameA','lifeforcearrayA','lifeforcearrayB','recovernameA','recoverarrayA','recoverarrayB','atkbuffnamearrayA','atkbuffvaluearrayA', 'atkbuffvaluearrayB','defbuffnamearrayA','defbuffvaluearrayA', 'defbuffvaluearrayB','atkdebuffnamearrayA','atkdebuffvaluearrayA', 'atkdebuffvaluearrayB','defdebuffnamearrayA','defdebuffvaluearrayA', 'defdebuffvaluearrayB'))->with('guild',$a)
                ->with('shinma',$b)
                ->with('crit',$crit)
                ->with('crite',$crite)
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
                ->with('s1enemyK',$s1enemyK)
                ->with('s1enemyV',$s1enemyV)
                ->with('s1selfK',$s1selfK)
                ->with('s1selfV',$s1selfV)
                ->with('s2enemyK',$s2enemyK)
                ->with('s2enemyV',$s2enemyV)
                ->with('s2selfK',$s2selfK)
                ->with('s2selfV',$s2selfV)
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

    public function statSpec($specs,$userid, $idmatch, Request $request)
        {
            $allowedspec = ['atk','def','defd','atkd'];
            if(!isset($specs) || !$specs || !in_array($specs, $allowedspec)){
                return response()->json(['spec not found']);
            }
            $q = '';
            switch($specs){
                case 'atk':
                    $q = '%ATK UP by%';
                    $regex = 'ATK UP by';
                    $key1 = 'P.ATK Buff';
                    $key2 = 'M.ATK Buff';
                    break;
                case 'def':
                    $q = '%DEF UP by%';
                    $regex = 'DEF UP by';
                    $key1 = 'P.DEF Buff';
                    $key2 = 'M.DEF Buff';
                    break;
                case 'atkd':
                    $q = '%ATK DOWN by%';
                    $regex = 'ATK DOWN by';
                    $key1 = 'P.ATK Debuff';
                    $key2 = 'M.ATK Debuff';
                    break;
                case 'defd':
                    $q = '%DEF DOWN by%';
                    $regex = 'DEF DOWN by';
                    $key1 = 'P.DEF Debuff';
                    $key2 = 'M.DEF Debuff';
                    break;
                default:
                    $q = '';
            }
            $p1=0;
            $p2=0;
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
                if(count($a) == 0){
                    return response()->json(['match/grid not available']);
                }
                $amiallowed = $a[0]->guildDataIdA;
                if(!in_array($amiallowed,$inarr)){
                    return response()->json(['You are not allowed to see this grid']);
                }

                $specget = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)->where('readableText', 'like', $q)->get();
                if(isset($specget[0])){

                    foreach($specget as $cs){
                        $cse = explode("\n", $cs->readableText);
                        $cskill = preg_grep("/M.".$regex." (.*)/", $cse);

                        foreach($cskill as $crv){
                            $csve = explode("by", $crv);
                            $v = preg_replace('/[^0-9]/', '', $csve[1]);
                            if($v == ''){
                                        
                            }
                            else{
                                $p2 += $v;
                            }
                            
                        }

                    }

                    foreach($specget as $cs){
                        $cse = explode("\n", $cs->readableText);
                        $cskill = preg_grep("/[^M.]".$regex." (.*)/", $cse);

                        foreach($cskill as $crv){
                            $csve = explode("by", $crv);
                            $v = preg_replace('/[^0-9]/', '', $csve[1]);
                            if($v == ''){
                                        
                            }
                            else{
                                $p1 += $v;
                            }
                        }

                    }

                    return response()->json([$key1=> $p1,$key2=>$p2]);

                }

                else{
                    return response()->json(['patk'=> 0,'matk'=>0]);
                }

            }
            else{
                return response()->json(['You are not allowed']);

            }

        }
    }

    public function statSpecWeap($userid,$idmatch,$specs, Request $request)
        {

            if(!isset($specs) || !isset($userid) || !isset($idmatch)){
                return response()->json(['spec not found']);
            }
            $q = '';
            $p1=0;
            $p2=0;
            $sess = session('usern');
            if(!isset($sess)){
                return redirect()->route('index');
            }
            else{
                $regexp = '';
                $weapskill = '';
                $weapdesc = '';
                $weaptype = '';
                $weapurl = '';
                $ismulti = false;
                $multicount = 0;
                $valavg = 0;
                $valsum = 0;
                $reccontrib = 0;
                $dmgcontrib = 0;
                $atkbcontrib = 0;
                $defbcontrib = 0;
                $atkdcontrib = 0;
                $defdcontrib = 0;

            $inarr = [];
            $valuearr = [];
            $atkarr = [];
            $defarr = [];

            $tsarr = [];
            $isAllowed = allowed::where('username',$sess)->get();
            if($isAllowed){
                foreach($isAllowed as $d){
                    array_push($inarr,$d->guildId);
                }
                $a = gvgtop::where('gvgDataId', $idmatch)->get();

                if(count($a) == 0){
                    return response()->json(['match/grid not available']);
                }
                $amiallowed = $a[0]->guildDataIdA;
                if(!in_array($amiallowed,$inarr)){
                    return response()->json(['You are not allowed to see this grid']);
                }

                $thequery = gvglog::where('gvgDataId', $idmatch)->where('userId', $userid)->where('readableText','like','%' . $specs . '%')->orderBy('gvgHistoryId','asc');
                $getquery = $thequery->get();
                $weaponcount = $thequery->count();
                $theq = explode("'s", $specs);

                if(count($theq) > 3){
                    $regexq = $theq[0]."'s". $theq[1];

                }
                if(count($theq) == 3){
                    $regexq = $theq[0];
                    $iq = weapimg::where('weapname', 'like',$regexq.'%')->count();
                    if($iq > 1){
                        $regexq = $regexq = $theq[0]."'s". $theq[1];
                    }


                }
                else{
                    $regexq = $theq[0];

                }
                // $regexq = $theq[0];
                // print($regexq . '</br>');
                $imgquery = weapimg::where('weapname', 'like',$regexq.'%')->first();
                

                if($imgquery){
                    $ws = weapskill::where('weapskillid',$imgquery->weapskillid)->first();
                    if($ws){
                        $weapskill = $ws->weapskillname;
                        $weapdesc = $ws->weapdesc;


                    }
                        $weaptype = $imgquery->weaptype != null ? $imgquery->weaptype : 'unknown';
                        $weapurl = $imgquery->weapurl != null ? $imgquery->weapurl : 'unknown';

                }
                if(!$imgquery){
                    $weapskill = 'not found';
                    $weapdesc = 'not found';
                    $weaptype = 'not found';

                }

                // switch($weaptype){
                //     case 'Tome':
                //         $whatto = ''
                // }

                $multigacha=explode('1 to 2 allies', $weapdesc);
                $multigachag=explode('2 allies', $weapdesc);
                $multigachagt=explode('of 2 enemies', $weapdesc);
                $multigachavg=explode('1 to 2 enemies', $weapdesc);
                $singlevg=explode('1 enemy', $weapdesc);
                $singlevgs=explode('1 ally', $weapdesc);

                
                if(isset($multigachag[1]) && !isset($multigacha[1]) || isset($multigachagt[1]) && !isset($multigacha[1])){
                    $ismulti = 2;
                }
                if(isset($singlevg[1]) || isset($singlevgs[1])){
                    $ismulti = 0;
                }
                    
                if(isset($multigacha[1]) || isset($multigachavg[1])){
                    $ismulti = 1;
                    // dd($valuearr);
                    // dd($multicount, $weaponcount);
                }

                foreach($getquery as $cs){
                    $cse = explode("\n", $cs->readableText);
                    array_push($tsarr, date('H:i', strtotime($cs->actTime)));

                    $valrecover = 0;
                    $valrecover2 = 0;
                    $valrecover3 = 0;
                    if($weaptype == 'Staff'){
                        $cskill = preg_grep("/HP recovered by (.*)/", $cse);
                        foreach($cskill as $crv){
                            $csve = explode("HP recovered by", $crv);
                            $v = preg_replace('/[^0-9]/', '', $csve[1]);
                           $valrecover += $v;
                        }
                        array_push($valuearr,$valrecover);
                        if(count($cskill) == 2){
                            $multicount++;
                        }
                    

                    
                    }
                    else if(in_array($weaptype,['Polearm','Hammer'])){
                        $cskill = preg_grep("/damage to 2 (.*)/", $cse);
                        if(count($cskill) == 1){
                            $multicount++;
                        }
                        $cskill2 = preg_grep("/damage to (.*)/", $cse);

                        foreach($cskill2 as $crv){
                            $csve = explode("damage to", $crv);
                            $v = preg_replace('/[^0-9]/', '', $csve[0]);
                            array_push($valuearr,$v);


                            // if($csve[1] == " 2 target(s)."){
                            //     // array_push($valuearr,strval($v * 2));

                            // }
                            // else{
                            //     array_push($valuearr,$v);

                            // }

                        }
                       
                    }

                    else if(in_array($weaptype,['Bow','Sword','Artifact'])){
                        $cskill2 = preg_grep("/damage to (.*)/", $cse);

                        foreach($cskill2 as $crv){
                            $csve = explode("damage to", $crv);
                            $v = preg_replace('/[^0-9]/', '', $csve[0]);
                            array_push($valuearr,$v);


                            // if($csve[1] == " 2 target(s)."){
                            //     // array_push($valuearr,strval($v * 2));

                            // }
                            // else{
                            //     array_push($valuearr,$v);

                            // }

                        }
                       
                    }
                    else if($weaptype == 'Tome'){
                        
                        
                        $patkdown = explode("P.ATK", $weapdesc);
                        $matkdown = explode("M.ATK", $weapdesc);
                        $pdefdown = explode("P.DEF", $weapdesc);
                        $mdefdown = explode("M.DEF", $weapdesc);

                        $ispatk = isset($patkdown[1]);
                        $ismatk = isset($matkdown[1]);
                        $ispdef = isset($pdefdown[1]);
                        $ismdef = isset($mdefdown[1]);

                        if(!$ispatk && !$ismatk && !$ispdef && $ismdef){
                            // $cskill = preg_grep("/[^M.]ATK DOWN by (.*)/", $cse);
                            $cskill = preg_grep("/M.DEF DOWN by (.*)/", $cse);


                            foreach($cskill as $crv){
                                $csve = explode("M.DEF DOWN by", $crv);
                                $v = preg_replace('/[^0-9]/', '', $csve[1]);
                               $valrecover += $v;
                            }
                            array_push($defarr,$valrecover);
                            array_push($valuearr,$valrecover);
                            if(count($cskill) == 2){
                                $multicount++;
                            }

                        }

                        if(!$ispatk && !$ismatk && $ispdef && !$ismdef){
                            $cskill = preg_grep("/[^M.]DEF DOWN by (.*)/", $cse);

                            foreach($cskill as $crv){
                                $csve = explode("DEF DOWN by", $crv);
                                $v = preg_replace('/[^0-9]/', '', $csve[1]);
                               $valrecover += $v;
                            }
                            array_push($defarr,$valrecover);
                            array_push($valuearr,$valrecover);

                            if(count($cskill) == 2){
                                $multicount++;
                            }

                        }
                        
                        if(!$ispatk && $ismatk && !$ispdef && !$ismdef){
                            $cskill = preg_grep("/M.ATK DOWN by (.*)/", $cse);

                            foreach($cskill as $crv){
                                $csve = explode("M.ATK DOWN by", $crv);
                                $v = preg_replace('/[^0-9]/', '', $csve[1]);
                               $valrecover += $v;
                            }
                            array_push($atkarr,$valrecover);
                            array_push($valuearr,$valrecover);

                            if(count($cskill) == 2){
                                $multicount++;
                            }

                        }

                        if($ispatk && !$ismatk && !$ispdef && !$ismdef){
                            $cskill = preg_grep("/[^M.]ATK DOWN by (.*)/", $cse);

                            foreach($cskill as $crv){
                                $csve = explode("ATK DOWN by", $crv);
                                $v = preg_replace('/[^0-9]/', '', $csve[1]);
                               $valrecover += $v;
                            }
                            array_push($atkarr,$valrecover);
                            array_push($valuearr,$valrecover);

                            if(count($cskill) == 2){
                                $multicount++;
                            }

                        }

                        if($ispatk && $ismatk && !$ispdef && !$ismdef){
                            $cskill = preg_grep("/ATK DOWN by (.*)/", $cse);

                            foreach($cskill as $crv){
                                $csve = explode("ATK DOWN by", $crv);
                                $v = preg_replace('/[^0-9]/', '', $csve[1]);
                                $valrecover += $v;
                            }
                            array_push($atkarr,$valrecover);
                            array_push($valuearr,$valrecover);

                            if(count($cskill) == 4){
                                $multicount++;
                            }

                        }


                        if(!$ispatk && !$ismatk && $ispdef && $ismdef){
                            $cskill = preg_grep("/DEF DOWN by (.*)/", $cse);

                            foreach($cskill as $crv){
                                $csve = explode("DEF DOWN by", $crv);
                                $v = preg_replace('/[^0-9]/', '', $csve[1]);
                               $valrecover += $v;
                            }
                            array_push($defarr,$valrecover);
                            array_push($valuearr,$valrecover);

                            if(count($cskill) == 4){
                                $multicount++;
                            }

                        }


                        if(!$ispatk && $ismatk && !$ispdef && $ismdef){
                            $cskill = preg_grep("/M.DEF DOWN by (.*)|M.ATK DOWN by (.*)/", $cse);

                            foreach($cskill as $crv){
                                $csve = explode("DEF DOWN by", $crv);
                                $csve2 = explode("ATK DOWN by", $crv);

                                if(isset($csve[1])){
                                    $v = preg_replace('/[^0-9]/', '', $csve[1]);
                                    $valrecover += $v;
                                    $valrecover3 += $v;
                                }
                               
                                if(isset($csve2[1])){
                                    $v = preg_replace('/[^0-9]/', '', $csve2[1]);
                                    $valrecover2 += $v;
                                    $valrecover3 += $v;
                                }
                            }
                                array_push($defarr,$valrecover2);
                                array_push($atkarr,$valrecover);
                                array_push($valuearr,$valrecover3);


                            if(count($cskill) == 4){
                                $multicount++;
                            }

                        }

                        if($ispatk && !$ismatk && $ispdef && !$ismdef){
                           

                            $cskill = preg_grep("/[^M.]DEF DOWN by (.*)|[^M.]ATK DOWN by (.*)/", $cse);
                        
                            foreach($cskill as $crv){
                                $csve = explode("DEF DOWN by", $crv);
                                $csve2 = explode("ATK DOWN by", $crv);

                                if(isset($csve[1])){
                                    $v = preg_replace('/[^0-9]/', '', $csve[1]);
                                    $valrecover += $v;
                                    $valrecover3 += $v;
                                }
                               
                                if(isset($csve2[1])){
                                    $v = preg_replace('/[^0-9]/', '', $csve2[1]);
                                    $valrecover2 += $v;
                                    $valrecover3 += $v;
                                }

                            }
                            array_push($defarr,$valrecover2);
                                array_push($atkarr,$valrecover);
                                array_push($valuearr,$valrecover3);
                            if(count($cskill) == 4){
                                $multicount++;
                            }

                        }

                    
                    }

                    else if($weaptype == 'Instrument'){
                        
                        
                        $patkdown = explode("P.ATK", $weapdesc);
                        $matkdown = explode("M.ATK", $weapdesc);
                        $pdefdown = explode("P.DEF", $weapdesc);
                        $mdefdown = explode("M.DEF", $weapdesc);

                        $ispatk = isset($patkdown[1]);
                        $ismatk = isset($matkdown[1]);
                        $ispdef = isset($pdefdown[1]);
                        $ismdef = isset($mdefdown[1]);

                        if(!$ispatk && !$ismatk && !$ispdef && $ismdef){
                            // $cskill = preg_grep("/[^M.]ATK DOWN by (.*)/", $cse);
                            $cskill = preg_grep("/M.DEF UP by (.*)/", $cse);


                            foreach($cskill as $crv){
                                $csve = explode("M.DEF UP by", $crv);
                                $v = preg_replace('/[^0-9]/', '', $csve[1]);
                               $valrecover += $v;
                            }
                            array_push($defarr,$valrecover);
                            array_push($valuearr,$valrecover);
                            if(count($cskill) == 2){
                                $multicount++;
                            }

                        }

                        if(!$ispatk && !$ismatk && $ispdef && !$ismdef){
                            $cskill = preg_grep("/[^M.]DEF UP by (.*)/", $cse);

                            foreach($cskill as $crv){
                                $csve = explode("DEF UP by", $crv);
                                $v = preg_replace('/[^0-9]/', '', $csve[1]);
                               $valrecover += $v;
                            }
                            array_push($defarr,$valrecover);
                            array_push($valuearr,$valrecover);

                            if(count($cskill) == 2){
                                $multicount++;
                            }

                        }
                        
                        if(!$ispatk && $ismatk && !$ispdef && !$ismdef){
                            $cskill = preg_grep("/M.ATK UP by (.*)/", $cse);

                            foreach($cskill as $crv){
                                $csve = explode("M.ATK UP by", $crv);
                                $v = preg_replace('/[^0-9]/', '', $csve[1]);
                               $valrecover += $v;
                            }
                            array_push($atkarr,$valrecover);
                            array_push($valuearr,$valrecover);

                            if(count($cskill) == 2){
                                $multicount++;
                            }

                        }

                        if($ispatk && !$ismatk && !$ispdef && !$ismdef){
                            $cskill = preg_grep("/[^M.]ATK UP by (.*)/", $cse);

                            foreach($cskill as $crv){
                                $csve = explode("ATK UP by", $crv);
                                $v = preg_replace('/[^0-9]/', '', $csve[1]);
                               $valrecover += $v;
                            }
                            array_push($atkarr,$valrecover);
                            array_push($valuearr,$valrecover);

                            if(count($cskill) == 2){
                                $multicount++;
                            }

                        }

                        if($ispatk && $ismatk && !$ispdef && !$ismdef){
                            $cskill = preg_grep("/ATK UP by (.*)/", $cse);

                            foreach($cskill as $crv){
                                $csve = explode("ATK UP by", $crv);
                                $v = preg_replace('/[^0-9]/', '', $csve[1]);
                                $valrecover += $v;
                            }
                            array_push($atkarr,$valrecover);
                            array_push($valuearr,$valrecover);

                            if(count($cskill) == 4){
                                $multicount++;
                            }

                        }


                        if(!$ispatk && !$ismatk && $ispdef && $ismdef){
                            $cskill = preg_grep("/DEF UP by (.*)/", $cse);

                            foreach($cskill as $crv){
                                $csve = explode("DEF UP by", $crv);
                                $v = preg_replace('/[^0-9]/', '', $csve[1]);
                               $valrecover += $v;
                            }
                            array_push($defarr,$valrecover);
                            array_push($valuearr,$valrecover);

                            if(count($cskill) == 4){
                                $multicount++;
                            }

                        }


                        if(!$ispatk && $ismatk && !$ispdef && $ismdef){
                            $cskill = preg_grep("/M.DEF UP by (.*)|M.ATK UP by (.*)/", $cse);

                            foreach($cskill as $crv){
                                $csve = explode("DEF UP by", $crv);
                                $csve2 = explode("ATK UP by", $crv);

                                if(isset($csve[1])){
                                    $v = preg_replace('/[^0-9]/', '', $csve[1]);
                                    $valrecover += $v;
                                    $valrecover3 += $v;
                                }
                               
                                if(isset($csve2[1])){
                                    $v = preg_replace('/[^0-9]/', '', $csve2[1]);
                                    $valrecover2 += $v;
                                    $valrecover3 += $v;
                                }
                            }
                                array_push($defarr,$valrecover2);
                                array_push($atkarr,$valrecover);
                                array_push($valuearr,$valrecover3);


                            if(count($cskill) == 4){
                                $multicount++;
                            }

                        }

                        if($ispatk && !$ismatk && $ispdef && !$ismdef){
                           

                            $cskill = preg_grep("/[^M.]DEF UP by (.*)|[^M.]ATK UP by (.*)/", $cse);
                        
                            foreach($cskill as $crv){
                                $csve = explode("DEF UP by", $crv);
                                $csve2 = explode("ATK UP by", $crv);

                                if(isset($csve[1])){
                                    $v = preg_replace('/[^0-9]/', '', $csve[1]);
                                    $valrecover += $v;
                                    $valrecover3 += $v;
                                }
                               
                                if(isset($csve2[1])){
                                    $v = preg_replace('/[^0-9]/', '', $csve2[1]);
                                    $valrecover2 += $v;
                                    $valrecover3 += $v;
                                }

                            }
                            array_push($defarr,$valrecover2);
                                array_push($atkarr,$valrecover);
                                array_push($valuearr,$valrecover3);
                            if(count($cskill) == 4){
                                $multicount++;
                            }

                        }

                    
                    }
                            // $cskill2 = implode("",$cskill);
                    

                }

                if($weaptype == 'Staff'){

                    $valavg = array_sum($valuearr) / $weaponcount;
                    $reccontrib = array_sum($valuearr);
                }

                if(in_array($weaptype, ['Sword','Bow','Polearm','Hammer','Artifact'])){

                    $valavg = array_sum($valuearr) / $weaponcount;
                    $dmgcontrib = array_sum($valuearr);
                }
                

                if($weaptype == 'Tome'){
                                     
                    if(!empty($defarr)){
                        $defdcontrib = array_sum($defarr);
                        $valavg = array_sum($defarr) / $weaponcount;
                    }

                    if(!empty($atkarr)){
                        $atkdcontrib = array_sum($atkarr);
                        $valavg = array_sum($atkarr) / $weaponcount;
                    }
                    
                }


                
                if($weaptype == 'Instrument'){
                                     
                    if(!empty($defarr)){
                        $defbcontrib = array_sum($defarr);
                        $valavg = array_sum($defarr) / $weaponcount;
                    }

                    if(!empty($atkarr)){
                        $atkbcontrib = array_sum($atkarr);
                        $valavg = array_sum($atkarr) / $weaponcount;
                    }
                    
                }

                return response()->json([
                'url' => $weapurl, 
                'ismulti' => $ismulti,
                'weaponcount'=>$weaponcount, 
                'multicount'=>$multicount,
                'valavg' => number_format($valavg),
                'dmgcontrib' => number_format($dmgcontrib),
                'reccontrib' => number_format($reccontrib),
                'atkbcontrib' => number_format($atkbcontrib),
                'defbcontrib' => number_format($defbcontrib),
                'atkdcontrib' => number_format($atkdcontrib),
                'defdcontrib' => number_format($defdcontrib),
                'valuearr'=>$valuearr,
                'atkarr'=>$atkarr,
                'defarr'=>$defarr,
                'tsarr'=>$tsarr ]);
            }
            else{
                return response()->json(['You are not allowed']);

            }

        }
    }




    public function getBuffSimp($userid, $idmatch){
        $patk = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)
                    ->where('readableText', 'like', '%ATK UP by%')
                    ->orwhere('readableText', 'like', '%DEF UP by%')
                    ->where('userId',$userid)->where('gvgDataId',$idmatch)
                    ->get();
     
                    $patkarr= [];
                    $patkb = [];
                    if(isset($patk[0])){

                        foreach($patk as $cs){
                            $cse = explode("\n", $cs->readableText);
                            $cskill = preg_grep("/(ATK UP by (.*)|DEF UP by (.*))/", $cse);
                            array_push($patkarr, $cskill);

                            foreach($cskill as $crv){
                                $csve = explode("'s", $crv);
                                
                                array_push($patkb, $csve[0]);

                       

                             

                            }

                        }

                    }
                   

                    return($patkb);
    }


    public function getDebuffSimp($userid, $idmatch){
        $patk = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)
                    ->where('readableText', 'like', '%ATK DOWN by%')
                    ->orwhere('readableText', 'like', '%DEF DOWN by%')
                    ->where('userId',$userid)->where('gvgDataId',$idmatch)
                    ->get();
                    $patkarr= [];
                    $patkb = [];

                    if(isset($patk[0])){
                        foreach($patk as $cs){
                            $cse = explode("\n", $cs->readableText);
                            $cskill = preg_grep("/(ATK DOWN by (.*)|DEF DOWN by (.*))/", $cse);
                            array_push($patkarr, $cskill);

                            foreach($cskill as $crv){
                                $csve = explode("'s", $crv);
                                
                                array_push($patkb, $csve[0]);

                       

                             

                            }

                        }

                    }
                   

                    return($patkb);
    }
    
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
                if(count($a) == 0){
                    return response()->json(['match/grid not available']);
                }
                $amiallowed = $a[0]->guildDataIdA;
                if(!in_array($amiallowed,$inarr)){
                    return response()->json(['You are not allowed to see this grid']);
                }

                    $y = [];
                    $yb =[];
                    $ybd = [];
                    $ybe = [];
                    $img = [];
                    $arrdebug = [];
                    $weaptype =[];
                    $highestatkbuff = '';
                    $highestdefbuff = '';
                    $highestatkdebuff = '';
                    $highestdefdebuff = '';
                    $highestdmg = '';
                    $highestrecover = '';

                    $highestatkbuffid = 0;
                    $highestdefbuffid = 0;
                    $highestatkdebuffid = 0;
                    $highestdefdebuffid = 0;
                    $highestdmgid = 0;
                    $highestrecoverid = 0;

                    $highestatkbuffvalue = 0;
                    $highestdefbuffvalue = 0;
                    $highestatkdebuffvalue = 0;
                    $highestdefdebuffvalue = 0;
                    $highestdmgvalue = 0;
                    $highestrecovervalue = 0;

                    $patkvalue=0;
                    $matkvalue=0;
                    $pdefvalue=0;
                    $mdefvalue=0;
                    $patkdvalue=0;
                    $matkdvalue=0;
                    $pdefdvalue=0;
                    $mdefdvalue=0;
                    $recovervalue=0;
                    $damagevalue=0;
                    $dc1rate = 0;
                    $sb1rate = 0;
                    $rs1rate = 0;
                    $dc2rate = 0;
                    $sb2rate = 0;
                    $sb3rate = 0;
                    $rs2rate = 0;
                    $gridctr = 0;
                    // $blog = TbBlog::find($id);
                    $limitgrid = $idmatch == '1475559' ? 100 : 20;
                    $grid = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)->where('readableText', 'not like', '%revive%')->where('readableText', 'not like', '%guildship%')->where('readableText', 'not like', '%10 mastery earned.%')->
                        where('readableText', 'not like', '%summon skill%')->where('readableText', 'not like', '%switched with%')->where('readableText', 'not like', '%HP recovered.%')->
                        orderBy('gvgHistoryId','asc')->LIMIT(100)->get();
                        if(count($grid) == 0){
                            return response()->json(['match/grid not available']);
                        }
                    
                    foreach($grid as $g){


                        if($gridctr != $limitgrid){
                            $thearr = explode("\n", $g->readableText);
                            if(preg_match('/combo.$/', $thearr[0])){
                                $strt = preg_replace('/activated.$/', '', $thearr[1]);
                                if(!in_array($strt,$y)){
                                    array_push($y, $strt);
                                    $gridctr++;
                                }
                                
                            }
                            else{
                                $strt = preg_replace('/activated.$/', '', $thearr[0]);
                                if(!in_array($strt,$y)){
                                    array_push($y, $strt);
                                    $gridctr++;

                                }
                                
                            }

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
                        if(count($theq) == 3){
                            $regexq = $theq[0];
                            $iq = weapimg::where('weapname', 'like',$regexq.'%')->count();
                            if($iq > 1){
                                $regexq = $regexq = $theq[0]."'s". $theq[1];
                            }


                        }
                        else{
                            $regexq = $theq[0];

                        }
                        // $regexq = $theq[0];
                        // print($regexq . '</br>');
                        $imgquery = weapimg::where('weapname', 'like',$regexq.'%')->first();
                        

                        if($imgquery){
                            $ws = weapskill::where('weapskillid',$imgquery->weapskillid)->first();
                            if($ws){
                                array_push($ybd,$ws->weapskillname);
                                array_push($ybe,$ws->weapdesc);
    
                            }
                            array_push($weaptype,$imgquery->weaptype);
                            array_push($img,$imgquery->weapurl);
                        }
                        if(!$imgquery){
                            array_push($img,'not found');
                            array_push($ybd,'not found');
                            array_push($ybe,'not found');
                            array_push($weaptype,'not found');

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
                            array_push($yb, 'Colo skill not found / not proced');
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
                    $thequery = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)
                    ->where('readableText', 'not like', '%revive%')->where('readableText', 'not like', '%guildship%')
                    ->where('readableText', 'not like', '%10 mastery earned.%')
                    ->where('readableText', 'not like', '%summon skill%')->
                    where('readableText', 'not like', '%switched with%');
                    $apm = $thequery->count();

                    $thequery2 = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch);
                    $apm2 = $thequery2->count();
                   
                    $recover = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)
                    ->where('readableText', 'like', '%HP recovered by%')->get();
                    $recovercount = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)
                    ->where('readableText', 'like', '%HP recovered by%')
                    ->where('readableText', 'not like', '%revive%')
                    ->where('readableText', 'not like', '%guildship%')
                    ->where('readableText', 'not like', '%10 mastery earned.%')
                    ->where('readableText', 'not like', '%summon skill%')->count();

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
                                if($v == ''){
                                        
                                }
                                else{
                                    $recovervalue += $v;
                                }
                                
                            }
                            // print($cskill2 . '</br>');
                        }
                    }



                  
// dd($arrdebug);return;

                    //eof recover
                    // $querybasic = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch);
                    //patk buff
                    $recoverc = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)->where('readableText', 'not like', '%revive%')->where('readableText', 'not like', '%guildship%')
                    ->where('readableText', 'not like', '%10 mastery earned.%')
                    ->where('readableText', 'not like', '%summon skill%')->where('readableText', 'like', '%HP Recovered by%')->get();
                    $damagec = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)->where('readableText', 'not like', '%revive%')->where('readableText', 'not like', '%guildship%')
                    ->where('readableText', 'not like', '%10 mastery earned.%')
                    ->where('readableText', 'not like', '%summon skill%')->where('readableText', 'like', '%damage to%')->get();


                    $patk = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)->where('readableText', 'not like', '%revive%')->where('readableText', 'not like', '%guildship%')
                    ->where('readableText', 'not like', '%10 mastery earned.%')
                    ->where('readableText', 'not like', '%summon skill%')->where('readableText', 'like', '%ATK UP by%')->get();
                    $pdef = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)->where('readableText', 'not like', '%revive%')->where('readableText', 'not like', '%guildship%')
                    ->where('readableText', 'not like', '%10 mastery earned.%')
                    ->where('readableText', 'not like', '%summon skill%')->where('readableText', 'like', '%DEF UP by%')->get();
                    $patkd = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)->where('readableText', 'not like', '%revive%')->where('readableText', 'not like', '%guildship%')
                    ->where('readableText', 'not like', '%10 mastery earned.%')
                    ->where('readableText', 'not like', '%summon skill%')->where('readableText', 'like', '%ATK DOWN by%')->get();
                    $pdefd = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)->where('readableText', 'not like', '%revive%')->where('readableText', 'not like', '%guildship%')
                    ->where('readableText', 'not like', '%10 mastery earned.%')
                    ->where('readableText', 'not like', '%summon skill%')->where('readableText', 'like', '%DEF DOWN by%')->get();
                    $rs1 = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)->where('readableText', 'not like', '%revive%')->where('readableText', 'not like', '%guildship%')
                    ->where('readableText', 'not like', '%10 mastery earned.%')
                    ->where('readableText', 'not like', '%summon skill%')->where('readableText', 'like', '%Recovery Support (I)%')->count();
                    $dc1 = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)->where('readableText', 'not like', '%revive%')->where('readableText', 'not like', '%guildship%')
                    ->where('readableText', 'not like', '%10 mastery earned.%')
                    ->where('readableText', 'not like', '%summon skill%')->where('readableText', 'like', '%Dauntless Courage (I)%')->count();
                    $sb1 = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)->where('readableText', 'not like', '%revive%')->where('readableText', 'not like', '%guildship%')
                    ->where('readableText', 'not like', '%10 mastery earned.%')
                    ->where('readableText', 'not like', '%summon skill%')->where('readableText', 'like', '%Support Boon (I)%')->count();
                    $rs2 = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)->where('readableText', 'not like', '%revive%')->where('readableText', 'not like', '%guildship%')
                    ->where('readableText', 'not like', '%10 mastery earned.%')
                    ->where('readableText', 'not like', '%summon skill%')->where('readableText', 'like', '%Recovery Support (II)%')->count();
                    $dc2 = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)->where('readableText', 'not like', '%revive%')->where('readableText', 'not like', '%guildship%')
                    ->where('readableText', 'not like', '%10 mastery earned.%')
                    ->where('readableText', 'not like', '%summon skill%')->where('readableText', 'not like', '%revive%')->where('readableText', 'not like', '%guildship%')
                    ->where('readableText', 'not like', '%10 mastery earned.%')
                    ->where('readableText', 'not like', '%summon skill%')->where('readableText', 'like', '%Dauntless Courage (II)%')->count();
                    $sb2 = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)->where('readableText', 'not like', '%revive%')->where('readableText', 'not like', '%guildship%')
                    ->where('readableText', 'not like', '%10 mastery earned.%')
                    ->where('readableText', 'not like', '%summon skill%')->where('readableText', 'like', '%Support Boon (II)%')->count();
                    $sb3 = gvglog::where('userId',$userid)->where('gvgDataId',$idmatch)->where('readableText', 'not like', '%revive%')->where('readableText', 'not like', '%guildship%')
                    ->where('readableText', 'not like', '%10 mastery earned.%')
                    ->where('readableText', 'not like', '%summon skill%')->where('readableText', 'like', '%Assistance Support (III)%')->count();

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


                    if(isset($damagec[0])){
                        foreach($damagec as $cs){
                            $cse = explode("\n", $cs->readableText);
                            $cskill = preg_grep("/damage to (.*)/", $cse);

                            foreach($cskill as $crv){
                                $csve = explode("damage to", $crv);
                                $v = preg_replace('/[^0-9]/', '', $csve[0]);
                     
                                    if($v == ''){
                                        
                                    }
                                    else{
                                        if($v > $highestdmgvalue){
                                            $highestdmgvalue = $v;
                                            $highestdmg = $cs->readableText;
                                        }
                                        $damagevalue += $v;
                                    }
                                
                       

                             

                            }

                        }

                    }

                    if(isset($recoverc[0])){
                        foreach($recoverc as $cs){
                            $cse = explode("\n", $cs->readableText);
                            $cskill = preg_grep("/HP recovered by (.*)/", $cse);
                            // dd($cskill);
                            foreach($cskill as $crv){
                                $csve = explode("by", $crv);
                                $v = preg_replace('/[^0-9]/', '', $csve[1]);
                     
                                    if($v == ''){
                                        
                                    }
                                    else{
                                        if($v > $highestrecovervalue){
                                            $highestrecovervalue = $v;
                                            $highestrecover = $cs->readableText;

                                        }
                                    }
                                
                       

                             

                            }

                        }

                    }

                    if(isset($patk[0])){
                        $patkarr= [];
                        foreach($patk as $cs){
                            $cse = explode("\n", $cs->readableText);
                            $cskill = preg_grep("/M.ATK UP by (.*)/", $cse);
                            array_push($patkarr, $cskill);

                            foreach($cskill as $crv){
                                $csve = explode("by", $crv);
                                $v = preg_replace('/[^0-9]/', '', $csve[1]);
                     
                                    if($v == ''){
                                        
                                    }
                                    else{
                                        if($v > $highestatkbuffvalue){
                                            $highestatkbuffvalue = $v;
                                            $highestatkbuff = $cs->readableText;

                                        }
                                        $matkvalue += $v;
                                    }
                                
                       

                             

                            }

                        }
                        // dd($patk);
                        foreach($patk as $cs){
                            $cse = explode("\n", $cs->readableText);
                            $cskill = preg_grep("/[^M.]ATK UP by (.*)/", $cse);

                            foreach($cskill as $crv){
                                $csve = explode("by", $crv);
                                $v = preg_replace('/[^0-9]/', '', $csve[1]);
                                if($v == ''){
                                        
                                }
                                else{
                                    if($v > $highestatkbuffvalue){
                                        $highestatkbuffvalue = $v;
                                        $highestatkbuff = $cs->readableText;

                                    }
                                    $patkvalue += $v;
                                }

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
                                if($v == ''){
                                        
                                }
                                else{
                                    if($v > $highestdefbuffvalue){
                                        $highestdefbuffvalue = $v;
                                        $highestdefbuff = $cs->readableText;

                                    }
                                    $mdefvalue += $v;
                                }


                            }

                        }

                        foreach($pdef as $cs){
                            $cse = explode("\n", $cs->readableText);
                            $cskill = preg_grep("/[^M.]DEF UP by (.*)/", $cse);

                            foreach($cskill as $crv){
                                $csve = explode("by", $crv);
                                $v = preg_replace('/[^0-9]/', '', $csve[1]);
                                if($v == ''){
                                        
                                }
                                else{
                                    if($v > $highestdefbuffvalue){
                                        $highestdefbuffvalue = $v;
                                        $highestdefbuff = $cs->readableText;

                                    }
                                    $pdefvalue += $v;
                                }


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
                            
                                if($v == ''){
                                        
                                }
                                else{
                                    if($v > $highestatkdebuffvalue){
                                        $highestatkdebuffvalue = $v;
                                        $highestatkdebuff = $cs->readableText;

                                    }
                                    $matkdvalue += $v;
                                }


                            }

                        }

                        foreach($patkd as $cs){
                            $cse = explode("\n", $cs->readableText);
                            $cskill = preg_grep("/[^M.]ATK DOWN by (.*)/", $cse);

                            foreach($cskill as $crv){
                                $csve = explode("by", $crv);
                                $v = preg_replace('/[^0-9]/', '', $csve[1]);
                                if($v == ''){
                                        
                                }
                                else{
                                    if($v > $highestatkdebuffvalue){
                                        $highestatkdebuffvalue = $v;
                                        $highestatkdebuff = $cs->readableText;

                                    }
                                    $patkdvalue += $v;
                                }


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
                                if($v == ''){
                                        
                                }
                                else{
                                    if($v > $highestdefdebuffvalue){
                                        $highestdefdebuffvalue = $v;
                                        $highestdefdebuff = $cs->readableText;

                                    }
                                    $mdefdvalue += $v;
                                }


                            }

                        }

                        foreach($pdefd as $cs){
                            $cse = explode("\n", $cs->readableText);
                            $cskill = preg_grep("/[^M.]DEF DOWN by (.*)/", $cse);

                            foreach($cskill as $crv){
                                $csve = explode("by", $crv);
                                $v = preg_replace('/[^0-9]/', '', $csve[1]);
                                if($v == ''){
                                        
                                }
                                else{
                                    if($v > $highestdefdebuffvalue){
                                        $highestdefdebuffvalue = $v;
                                        $highestdefdebuff = $cs->readableText;

                                    }
                                    $pdefdvalue += $v;
                                }


                            }

                        }
                    }



                    //eof patkbuff


// dd($ybd,$ybe);
                    $weaptypearr = array_count_values($weaptype);
                    $averagerecover = $recovercount > 0 ? number_format(ceil($recovervalue / $recovercount)) : 0;

                    $toget = $this->getBuffSimp($userid, $idmatch);
                    $patkb = array_count_values($toget);
                    arsort($patkb);
                    $patkbK = array_keys($patkb);
                    $patkbV = array_values($patkb);


                    $dtoget = $this->getDebuffSimp($userid, $idmatch);
                    $dpatkb = array_count_values($dtoget);
                    arsort($dpatkb);
                    $dpatkbK = array_keys($dpatkb);
                    $dpatkbV = array_values($dpatkb);
                   
                    // return response()->json($y);
                    return view('grid')
                    ->with('gridlist',$y)
                    ->with('imglist',$img)
                    ->with('cololist',$yb)
                    ->with('hdv',$highestdmgvalue)
                    ->with('hrv',$highestrecovervalue)
                    ->with('habv',$highestatkbuffvalue)
                    ->with('hdbv',$highestdefbuffvalue)
                    ->with('hadv',$highestatkdebuffvalue)
                    ->with('hddv',$highestdefdebuffvalue)
                    ->with('hd',$highestdmg)
                    ->with('hr',$highestrecover)
                    ->with('hab',$highestatkbuff)
                    ->with('hdb',$highestdefbuff)
                    ->with('had',$highestatkdebuff)
                    ->with('hdd',$highestdefdebuff)
                    ->with('username',$grid[0]->userName)
                    ->with('guildenemy',$guildenemy)
                    ->with('uid',$userid)
                    ->with('ide',$idmatch)
                    ->with('apm',$apm)
                    ->with('apm2',$apm2)
                    ->with('ybd',$ybd)
                    ->with('ybe',$ybe)
                    ->with('BSK',$patkbK)
                    ->with('BSV',$patkbV)
                    ->with('DSK',$dpatkbK)
                    ->with('DSV',$dpatkbV)
                    ->with('weaptype',$weaptypearr)
                    ->with('avgrecover',$averagerecover)
                    ->with('damage',number_format($damagevalue))
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
                          ->orWhere('gvgDataId', $id)
                          ->Where('gvglogs.readableText', 'like', '%' .$searchValue . '%')
                        ->select('gvglogs.*')
                        ->skip($start)
                        ->take($rowperpage)
                        ->get();



                        $data_arr = array();

                        foreach($records as $record){
                        $id = $record->gvgHistoryId;
                        // $actTime = date('Y-m-d H:i', strtotime($record->actTime));
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

      public function gcView($txt = "all"){
          if($txt == "all"){
            return view('gc')->with('ide',$txt);
          }
          else if($txt > 0 && $txt <= 13){
            return view('gc')->with('ide',$txt);
          }
          else{
            return view('gc')->with('ide',"all");

          }
          
          
      }

      public function getGcRank($txt, Request $request){

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

                        $totalRecords = gcrank::select('count(*) as allcount')->count();
                        
                        switch($txt){
                            case("all"):
                                $tx = "all";
                                break;
                            case(1):
                                $tx = 1;
                                break;
                            case(2):
                                $tx = 2;
                                break;
                            case(3):
                                $tx = 4;
                                break;
                            case(4):
                                $tx = 8;
                                break;
                            case(5):
                                $tx = 16;
                                break;
                            case(6):
                                $tx = 32;
                                break;
                            case(7):
                                $tx = 64;
                                break;
                            case(8):
                                $tx = 128;
                                break;
                            case(9):
                                $tx = 256;
                                break;
                            case(10):
                                $tx = 512;
                                break;
                            case(11):
                                $tx = 1024;
                                break;
                            case(12):
                                $tx = 2048;
                                break;
                            case(13):
                                $tx = 4096;
                                break;
                            default:
                                $tx = "all";
                                break;
                        }
                        // Fetch records
                        if($txt == "all"){
                            $totalRecordswithFilter = gcrank::select('count(*) as allcount')->where('guildName', 'like', '%' .$searchValue . '%')
                            ->count();
                            $records = gcrank::orderBy("point","desc")
                            ->select('gcranks.*')
                            ->where('gcranks.guildName', 'like', '%' .$searchValue . '%')
                            ->skip($start)
                            ->take($rowperpage)
                            ->orderBy('point','DESC')
                            ->get();
                            
                          }
                          else if($txt > 0 && $txt <= 13){
                            $totalRecordswithFilter = gcrank::select('count(*) as allcount')->where('gcranks.gvgTimeType', $txt)->where('guildName', 'like', '%' .$searchValue . '%')
                            ->count();
                            $records = gcrank::orderBy("point","desc")
                            ->select('gcranks.*')
                            ->where('gcranks.gvgTimeType', $tx)
                            ->where('gcranks.guildName', 'like', '%' .$searchValue . '%')
                            ->skip($start)
                            ->take($rowperpage)
                            ->orderBy('point','DESC')
                            ->get();
                          }
                          else{
                            $totalRecordswithFilter = gcrank::select('count(*) as allcount')->where('guildName', 'like', '%' .$searchValue . '%')
                            ->count();
                            $records = gcrank::orderBy("point","desc")
                            ->select('gcranks.*')
                            ->where('gcranks.guildName', 'like', '%' .$searchValue . '%')
                            ->skip($start)
                            ->take($rowperpage)
                            ->orderBy('point','DESC')
                            ->get();
                
                          }
                        



                        $data_arr = array();
                        foreach($records as $record){
              
                        $id = $record->id;
                        $guildName = $record->guildName;
                        $guildLevel = $record->guildLevel;
                        $point = $record->point;
                        $winPoint = $record->winPoint;
                        $sourceCount = $record->sourceCount;
                        $rankingInBattleForm = $record->rankingInBattleTerm;
                        switch($record->gvgTimeType){
                            case(1):
                                $TS = 1;
                                break;
                            case(2):
                                $TS = 2;
                                break;
                            case(4):
                                $TS = 3;
                                break;
                            case(8):
                                $TS = 4;
                                break;
                            case(16):
                                $TS = 5;
                                break;
                            case(32):
                                $TS = 6;
                                break;
                            case(64):
                                $TS = 7;
                                break;
                            case(128):
                                $TS = 8;
                                break;
                            case(256):
                                $TS = 9;
                                break;
                            case(512):
                                $TS = 10;
                                break;
                            case(1024):
                                $TS = 11;
                                break;
                            case(2048):
                                $TS = 12;
                                break;
                            case(4096):
                                $TS = 13;
                                break;
                            default:
                                $TS = "unknown";
                                break;
                        }

                        $data_arr[] = array(
                            "rank"=>$id,
                            "guildName" => $guildName,
                            "guildLevel" => $guildLevel,
                            "point" => number_format($point),
                            "winPoint" => $winPoint,
                            "losePoint" => $sourceCount - $winPoint,
                            "sourceCount" => $sourceCount,
                            "gvgTimeType" => $TS
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

      private function dispatchWebhook($list){
        $payload = [
            'embeds' => [
                [
                    'title' => 'Connected to Kureha-log',
                    'description' => $list,
                    'color' => 23334,
                    'timestamp' => Carbon::now()
                ]
            ]
        ];

        WebhookCall::create()
            ->url(Config::get('app.disc-webhook'))
            ->payload($payload)
            ->useSecret('helloSecret')
            ->dispatch();

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
                            ->where('gvglogs.readableText', 'like', '%' .$searchValue . '%')
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
