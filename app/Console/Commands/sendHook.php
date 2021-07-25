<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use Spatie\WebhookServer\WebhookCall;
use Illuminate\Support\Facades\Log;
use App\Models\gvgshinmadetail;

class sendHook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kure:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Hook';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
$client = new \GuzzleHttp\Client();
        
                    $res = $client->request('GET', 'https://xvc.cleverapps.io/gettop/');
        
                    $resp = json_decode($res->getBody());
                    if ($resp->status == 200 && $resp->payload != null) {
 
                        
                        if($resp->payload->gvgSchedule[0]->guildDataNameA){
                            
                       $fq = gvgshinmadetail::where('artMstId', $resp->payload->gvgUltimateArtInfoList[0]->gvgUltimateArtDataList[0]->artMstId)->first();
                        $sq = gvgshinmadetail::where('artMstId', $resp->payload->gvgUltimateArtInfoList[0]->gvgUltimateArtDataList[1]->artMstId)->first();
                        
                        $firstshinma = !$fq ? "uh oh, kurelog havent update yet" : $fq->description;
                        $secondshinma = !$sq ? "uh oh, kurelog havent update yet" : $sq->description;
                        
                        $firstshinman = !$fq ? "oops." : $fq->name;
                        $secondshinman = !$sq ? "oops." : $sq->name;
                            
                            $this->dispatchWebhook($resp->payload, $firstshinma, $secondshinma, $firstshinman, $secondshinman);
                        }
                        
                        else{

                        }
                        
                        
                    }
        

    }

    private function dispatchWebhook($list, $firstshinma, $secondshinma, $fn, $sn)
    {
        $payload = [
            'embeds' => [
                [
                    'title' => 'Today Opponents (Click to open Kurelog)',
                    'description' => $list->gvgSchedule[0]->guildDataNameA . ' vs ' . $list->gvgSchedule[0]->guildDataNameB,
                    'url' => 'https://kurelog.site/guild/' . $list->gvgSchedule[0]->guildDataIdB,
                    'color' => 23334,
                    'timestamp' => Carbon::now(),
                    'thumbnail' => [
                        'url' => 'https://www.kurelog.site/public/media/photos/' . $list->gvgSchedule[0]->guildDataCountryCodeB . '.png'
                    ],
                    "fields" => [
                // Field 1
                [
                    "name" => $list->gvgSchedule[0]->guildDataNameA . " Power",
                    "value" => $list->gvgSchedule[0]->totalGuildPowerA,
                    "inline" => true
                ],
                // Field 2
                [
                    "name" => $list->gvgSchedule[0]->guildDataNameB . " Power",
                    "value" => $list->gvgSchedule[0]->totalGuildPowerB,
                    "inline" => true
                ],
                
                [
                    "name" => $fn,
                    "value" => $firstshinma,
                    "inline" => false
                ],
                
                [
                    "name" => $sn,
                    "value" => $secondshinma,
                    "inline" => false
                ],
                
                
                
                ],
                ],
            ],
        ];

        WebhookCall::create()
            ->url('https://discord.com/api/webhooks/865450316384567306/2N2vRjR0nB6teEv5FK_ghRkzkwXpnxjh2Yy-pAJlh5CPakTk8y258A3tQ8clXVmWdeU7')
            ->payload($payload)
            ->useSecret('helloSecret')
            ->dispatch();

    }
}
