@extends('layouts.backend')

@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="my-50 text-center">
            @foreach ($guild as $g)
                <h2 class="font-w700 text-white mb-10">Battle Log Analyzer</h2>
                <h3 class="h5 text-muted mb-0">{{ $g->guildDataNameA }} vs {{ $g->guildDataNameB }}</h3>

        </div>

        </hr>

        <div class="row js-appear-enabled animated fadeIn" data-toggle="appear">
            <!-- Row #4 -->
            <div class="col-md-12">
                <a class="block block-link-shadow overflow-hidden">
                    <div class="block-content block-content-full">
                        <div class="text-left">
                            <h3> Overall Results</h3>
                        </div>

                        <div class="row py-20">
                            <div class="col-6 text-left border-r">
                                <div class="js-appear-enabled animated fadeInLeft" data-toggle="appear"
                                     data-class="animated fadeInLeft">
                                    <div class="font-size-h3 font-w600 text-info"><img
                                            src="http://kurelog.madjavacoder.me/media/photos/{{$g->guildDataCountryCodeA}}.png"> </img>{{ $g->guildDataNameA }}
                                    </div>

                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <div class="js-appear-enabled animated fadeInRight" data-toggle="appear"
                                     data-class="animated fadeInRight">
                                    <div class="font-size-h3 font-w600 text-success"><img
                                            src="http://kurelog.madjavacoder.me/media/photos/{{$g->guildDataCountryCodeB}}.png"> </img>{{ $g->guildDataNameB }}
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="row py-20">
                            <div class="col-6 text-left border-r">
                                <div class="js-appear-enabled animated fadeInLeft" data-toggle="appear"
                                     data-class="animated fadeInLeft">
                                    <div
                                        class="font-size-h3 font-w600 text-info">{{ number_format($g->totalGuildPointA) }}</div>
                                    <div
                                        class="font-size-sm font-w600 text-uppercase text-muted">{{ $g->guildDataNameA }}
                                        Lifeforce
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <div class="js-appear-enabled animated fadeInRight" data-toggle="appear"
                                     data-class="animated fadeInRight">
                                    <div
                                        class="font-size-h3 font-w600 text-success">{{ number_format($g->totalGuildPointB) }}</div>
                                    <div
                                        class="font-size-sm font-w600 text-uppercase text-muted">{{ $g->guildDataNameB }}
                                        Lifeforce
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row py-20">
                            <div class="col-6 text-left border-r">
                                <div class="js-appear-enabled animated fadeInLeft" data-toggle="appear"
                                     data-class="animated fadeInLeft">
                                    <div
                                        class="font-size-h3 font-w600 text-info">{{ number_format($g->selfComboCount) }}</div>
                                    <div
                                        class="font-size-sm font-w600 text-uppercase text-muted">{{ $g->guildDataNameA }}
                                        Combo
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <div class="js-appear-enabled animated fadeInRight" data-toggle="appear"
                                     data-class="animated fadeInRight">
                                    <div
                                        class="font-size-h3 font-w600 text-success">{{ number_format($g->enemyComboCount) }}</div>
                                    <div
                                        class="font-size-sm font-w600 text-uppercase text-muted">{{ $g->guildDataNameB }}
                                        Combo
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row py-20">
                            <div class="col-6 text-left border-r">
                                <div class="js-appear-enabled animated fadeInLeft" data-toggle="appear"
                                     data-class="animated fadeInLeft">
                                    <div class="font-size-h3 font-w600 text-info">{{ $g->selfSiegeWinCount }}times
                                    </div>
                                    <div
                                        class="font-size-sm font-w600 text-uppercase text-muted">{{ $g->guildDataNameA }}
                                        Shipping {{ $g->guildDataNameB }}</div>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <div class="js-appear-enabled animated fadeInRight" data-toggle="appear"
                                     data-class="animated fadeInRight">
                                    <div class="font-size-h3 font-w600 text-success">{{ $g->enemySiegeWinCount }}Times
                                    </div>
                                    <div
                                        class="font-size-sm font-w600 text-uppercase text-muted">{{ $g->guildDataNameB }}
                                        Shipping {{ $g->guildDataNameA }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="row py-20">
                            <div class="col-6 text-left border-r">
                                <div class="js-appear-enabled animated fadeInLeft" data-toggle="appear"
                                     data-class="animated fadeInLeft">
                                    <div class="font-size-h3 font-w600 text-info">{{ $crit }} times</div>
                                    <div
                                        class="font-size-sm font-w600 text-uppercase text-muted">{{ $g->guildDataNameA }}
                                        Critical hits occured.
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <div class="js-appear-enabled animated fadeInRight" data-toggle="appear"
                                     data-class="animated fadeInRight">
                                    <div class="font-size-h3 font-w600 text-success">{{ $crite }} Times</div>
                                    <div
                                        class="font-size-sm font-w600 text-uppercase text-muted">{{ $g->guildDataNameB }}
                                        Critical hits occured.
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row py-20">
                            <div class="col-6 text-left border-r">
                                <div class="js-appear-enabled animated fadeInLeft" data-toggle="appear"
                                     data-class="animated fadeInLeft">
                                    <div class="font-size-h3 font-w600 text-info">{{ $enemykiss }} times</div>
                                    <div
                                        class="font-size-sm font-w600 text-uppercase text-muted">{{ $g->guildDataNameA }}
                                        make {{ $g->guildDataNameB }} Kissing floor
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <div class="js-appear-enabled animated fadeInRight" data-toggle="appear"
                                     data-class="animated fadeInRight">
                                    <div class="font-size-h3 font-w600 text-success">{{ $ownkiss }} Times</div>
                                    <div
                                        class="font-size-sm font-w600 text-uppercase text-muted">{{ $g->guildDataNameB }}
                                        make {{ $g->guildDataNameA }} Kissing floor
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row py-20">
                            <div class="col-6 text-left border-r">
                                <div class="js-appear-enabled animated fadeInLeft" data-toggle="appear"
                                     data-class="animated fadeInLeft">
                                    <div class="font-size-h3 font-w600 text-info">{{ $mostsimped }}</div>
                                    <div
                                        class="font-size-sm font-w600 text-uppercase text-muted">{{ $g->guildDataNameA }}
                                        Most Targeted Ally (Buff Simps)
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <div class="js-appear-enabled animated fadeInRight" data-toggle="appear"
                                     data-class="animated fadeInRight">
                                    <div class="font-size-h3 font-w600 text-success">{{ $emostsimped }}</div>
                                    <div
                                        class="font-size-sm font-w600 text-uppercase text-muted">{{ $g->guildDataNameB }}
                                        Most Targeted Ally (Buff Simps)
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row py-20">
                            <div class="col-6 text-left border-r">
                                <div class="js-appear-enabled animated fadeInLeft" data-toggle="appear"
                                     data-class="animated fadeInLeft">
                                    <div class="font-size-h3 font-w600 text-success">{{ $emostkiss }}</div>
                                    <div
                                        class="font-size-sm font-w600 text-uppercase text-muted">{{ $g->guildDataNameA }}
                                        Most Targeted Enemy (Floor Kisser)
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <div class="js-appear-enabled animated fadeInRight" data-toggle="appear"
                                     data-class="animated fadeInRight">
                                    <div class="font-size-h3 font-w600 text-info">{{ $mostkiss }}</div>
                                    <div
                                        class="font-size-sm font-w600 text-uppercase text-muted">{{ $g->guildDataNameB }}
                                        Most Targeted Enemy (Floor Kisser)
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- END Row #4 -->
        </div>


        <div class="row js-appear-enabled animated fadeIn" data-toggle="appear">
            <!-- Row #4 -->
            <div class="col-md-6">
                <a class="block block-link-shadow overflow-hidden">
                    <div class="block-content block-content-full">
                        <div class="text-left">
                            <h3> {{ $g->guildDataNameA }} Buff War Results</h3>
                        </div>
                        <div class="row py-20">
                            <div class="col-6 text-right border-r">
                                <div class="js-appear-enabled animated fadeInLeft" data-toggle="appear"
                                     data-class="animated fadeInLeft">
                                    <div
                                        class="font-size-h3 font-w600 text-info">{{ number_format($guildAAbuff) }}</div>
                                    <div
                                        class="font-size-sm font-w600 text-uppercase text-muted">{{ $g->guildDataNameA }}
                                        Atk Buff
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="js-appear-enabled animated fadeInRight" data-toggle="appear"
                                     data-class="animated fadeInRight">
                                    <div
                                        class="font-size-h3 font-w600 text-success">{{ number_format($guildBAdebuff) }}</div>
                                    <div
                                        class="font-size-sm font-w600 text-uppercase text-muted">{{ $g->guildDataNameB }}
                                        Atk Debuff
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row py-20">
                            <div class="col-6 text-right border-r">
                                <div class="js-appear-enabled animated fadeInLeft" data-toggle="appear"
                                     data-class="animated fadeInLeft">
                                    <div
                                        class="font-size-h3 font-w600 text-info">{{ number_format($guildADbuff) }}</div>
                                    <div
                                        class="font-size-sm font-w600 text-uppercase text-muted">{{ $g->guildDataNameA }}
                                        Def buff
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="js-appear-enabled animated fadeInRight" data-toggle="appear"
                                     data-class="animated fadeInRight">
                                    <div
                                        class="font-size-h3 font-w600 text-success">{{ number_format($guildBDdebuff) }}</div>
                                    <div
                                        class="font-size-sm font-w600 text-uppercase text-muted">{{ $g->guildDataNameB }}
                                        Def Debuff
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a class="block block-link-shadow overflow-hidden">
                    <div class="block-content block-content-full">
                        <div class="text-left">
                            <h3> {{ $g->guildDataNameB }} Buff War Results</h3>
                        </div>
                        <div class="row py-20">
                            <div class="col-6 text-right border-r">
                                <div class="js-appear-enabled animated fadeInLeft" data-toggle="appear"
                                     data-class="animated fadeInLeft">
                                    <div
                                        class="font-size-h3 font-w600 text-success">{{ number_format($guildBAbuff) }}</div>
                                    <div
                                        class="font-size-sm font-w600 text-uppercase text-muted">{{ $g->guildDataNameB }}
                                        Atk Buff
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="js-appear-enabled animated fadeInRight" data-toggle="appear"
                                     data-class="animated fadeInRight">
                                    <div
                                        class="font-size-h3 font-w600 text-info">{{ number_format($guildAAdebuff) }}</div>
                                    <div
                                        class="font-size-sm font-w600 text-uppercase text-muted">{{ $g->guildDataNameA }}
                                        Atk Debuff
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row py-20">
                            <div class="col-6 text-right border-r">
                                <div class="js-appear-enabled animated fadeInLeft" data-toggle="appear"
                                     data-class="animated fadeInLeft">
                                    <div
                                        class="font-size-h3 font-w600 text-success">{{ number_format($guildBDbuff) }}</div>
                                    <div
                                        class="font-size-sm font-w600 text-uppercase text-muted">{{ $g->guildDataNameB }}
                                        Def buff
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="js-appear-enabled animated fadeInRight" data-toggle="appear"
                                     data-class="animated fadeInRight">
                                    <div
                                        class="font-size-h3 font-w600 text-info">{{ number_format($guildADdebuff) }}</div>
                                    <div
                                        class="font-size-sm font-w600 text-uppercase text-muted">{{ $g->guildDataNameA }}
                                        Def Debuff
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- END Row #4 -->
        </div>

        <div class="bg-pattern bg-black-op-25" style="background-image: url('assets/media/various/bg-pattern.png');">
            <div class="content text-center">
                <div class="pt-50 pb-20">
                    <h1 class="font-w700 text-white mb-10">Player Grid</h1>
                    <h2 class="h4 font-w400 text-white-op">Player Grid Category</h2>
                </div>
            </div>
        </div>

        <div class="row row-deck gutters-tiny" id="accordion2" role="tablist" aria-multiselectable="true">
            <div class="col-md-6">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <a class="font-w600 collapsed" data-toggle="collapse" data-parent="#accordion2"
                           href="#accordion2_q1" aria-expanded="false" aria-controls="accordion2_q1">Tap to show Ally
                            Member List</a>
                    </div>
                    <div id="accordion2_q1" class="collapse" role="tabpanel" aria-labelledby="accordion2_h1" style="">
                        <div class="block-content">
                            @foreach ($ally as $a)
                                <div class="block block-rounded">
                                    <div class="block-header block-header-default">
                                        <h3 class="block-title">{{$a->name}} | HP: {{$a->maxHp}}</h3>
                                    </div>
                                    <div class="block-content">
                                        <a href="{{ route('show.grid', [$a->userId, $ide]) }}"
                                           class="btn btn-xs btn-info modalMd" target="_blank">
                                            <div class="font-size-md text-black mb-5">Click to See {{$a->name}}Grid
                                            </div>
                                        </a>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>


            <div class="col-md-6">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <a class="font-w600 collapsed" data-toggle="collapse" data-parent="#accordion2"
                           href="#accordion2_q2" aria-expanded="false" aria-controls="accordion2_q2">Tap to show Enemy
                            Member List</a>
                    </div>
                    <div id="accordion2_q2" class="collapse" role="tabpanel" aria-labelledby="accordion2_h2" style="">
                        <div class="block-content">
                            @foreach ($enemy as $a)
                                <div class="block block-rounded">
                                    <div class="block-header block-header-default">
                                        <h3 class="block-title">{{$a->name}} | HP: {{$a->maxHp}}</h3>
                                    </div>
                                    <div class="block-content">
                                        <a href="{{ route('show.grid', [$a->userId, $ide]) }}"
                                           class="btn btn-xs btn-info modalMd" target="_blank">
                                            <div class="font-size-md text-black mb-5">Click to See {{$a->name}}Grid
                                            </div>
                                        </a>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>


        <div class="bg-pattern bg-black-op-25" style="background-image: url('assets/media/various/bg-pattern.png');">
            <div class="content text-center">
                <div class="pt-50 pb-20">
                    <h1 class="font-w700 text-white mb-10">Shinma</h1>
                    <h2 class="h4 font-w400 text-white-op">Shinma War Results</h2>
                </div>
            </div>
        </div>

        <div class="row row-deck gutters-tiny">


                <div class="col-md-6">
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">{{$shinma[0]->name}}</h3>
                        </div>
                        <div class="block-content">
                            <div class="row text-center">
                                <div class="col-md-4">
                                    <h3 style="color:green">{{$shinma[0]->guildACount}}</h3>
                                </div>
                                <div class="col-md-4">
                                    <h3>Vs</h3>
                                </div>
                                <div class="col-md-4">
                                    <h3 style="color:red">{{$shinma[0]->guildBCount}}</h3>
                                </div>
                            </div>
                        </div>

                        <p class="font-size-md text-black mb-5 ml-20">{{$shinma[0]->description}}</p>

                        <div class="block-content block-content-full">
                        <div class="text-left">
                            <h3>Shinma War Results</h3>
                        </div>
                        <div class="row py-20">
                       
                        
                            <div class="col-6 text-right border-r">
                                <div class="js-appear-enabled animated fadeIn yabbe" data-toggle="appear"
                                    data-class="animated fadeIn">
                                    @for ($i = 0; $i < count($s1selfK); $i++)
                                    <div class="font-size-h3 font-w600 text-info">{{$s1selfV[$i]}}</div>
                                    <div class="font-size-sm font-w600 text-uppercase text-muted">{{$s1selfK[$i]}}</div> 
                                    @endfor
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="js-appear-enabled animated fadeIn yabbe" data-toggle="appear"
                                    data-class="animated fadeIn">
                                    @for ($i = 0; $i < count($s1enemyK); $i++)
                                    <div class="font-size-h3 font-w600 text-success">{{$s1enemyV[$i]}}</div>
                                    <div class="font-size-sm font-w600 text-uppercase text-muted">{{$s1enemyK[$i]}}</div> 
                                    @endfor
                                    </div>
                                </div>
                            </div>

                        </div>


                    </div>
                    
                </div>
    




                <div class="col-md-6">
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">{{$shinma[1]->name}}</h3>
                        </div>
                        <div class="block-content">
                            <div class="row text-center">
                                <div class="col-md-4">
                                    <h3 style="color:green">{{$shinma[1]->guildACount}}</h3>
                                </div>
                                <div class="col-md-4">
                                    <h3>Vs</h3>
                                </div>
                                <div class="col-md-4">
                                    <h3 style="color:red">{{$shinma[1]->guildBCount}}</h3>
                                </div>
                            </div>
                        </div>

                        <p class="font-size-md text-black mb-5 ml-20">{{$shinma[1]->description}}</p>
                        <div class="block-content block-content-full">
                        <div class="text-left">
                            <h3>Shinma War Results</h3>
                        </div>
                        <div class="row py-20">
                       
                        
                            <div class="col-6 text-right border-r">
                                <div class="js-appear-enabled animated fadeIn yabbe" data-toggle="appear"
                                    data-class="animated fadeIn">
                                    @for ($i = 0; $i < count($s2selfK); $i++)
                                    <div class="font-size-h3 font-w600 text-info">{{$s2selfV[$i]}}</div>
                                    <div class="font-size-sm font-w600 text-uppercase text-muted">{{$s2selfK[$i]}}</div> 
                                    @endfor
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="js-appear-enabled animated fadeIn yabbe" data-toggle="appear"
                                    data-class="animated fadeIn">
                                    @for ($i = 0; $i < count($s2enemyK); $i++)
                                    <div class="font-size-h3 font-w600 text-success">{{$s2enemyV[$i]}}</div>
                                    <div class="font-size-sm font-w600 text-uppercase text-muted">{{$s2enemyK[$i]}}</div> 
                                    @endfor
                                    </div>
                                </div>
                            </div>

                        </div>

     
                    </div>
              
                </div>



        </div>



        <div class="bg-pattern bg-black-op-25" style="background-image: url('assets/media/various/bg-pattern.png');">
            <div class="content text-center">
                <div class="pt-50 pb-20">
                    <h1 class="font-w700 text-white mb-10">Top 5</h1>
                    <h2 class="h4 font-w400 text-white-op">Top 5 Score Category</h2>
                </div>
            </div>
        </div>
        @endforeach
        <div class="row js-appear-enabled animated fadeIn" data-toggle="appear">
            <!-- Row #4 -->
            <div class="col-md-12">
                <a class="block block-link-shadow overflow-hidden">
                    <div class="block-content block-content-full">
                        <div class="text-left">
                            <h3> Ally Statistics Breakdowns</h3>
                        </div>
                        <div class="row py-20" id="pgl">
                            <div class="col-6 text-right border-r">
                                <div class="js-appear-enabled animated fadeInLeft" data-toggle="appear" data-class="animated fadeInLeft">
                                <div class="font-size-h3 font-w600 text-info" id="nameself">Ally Stats</div>
                                <div class="d-none justify-content-center" id="allyloader">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    </div>
                                     <canvas class="js-chartjs-pie chartjs-render-monitor" id="ours"></canvas>
                                </div>
                            </div>
                        <div class="col-6">
                                <div class="js-appear-enabled animated fadeInLeft" data-toggle="appear" data-class="animated fadeInLeft">
                                <div class="font-size-h3 font-w600 text-success" id="nameenemy">Enemy Stats</div>
                                <div class="d-none justify-content-center" id="enemyloader">
                                    <div class="spinner-border" role="status">
                                        <span class="sr-only">Loading...</span>
                                    </div>
                                    </div>
                                     <canvas class="js-chartjs-pie chartjs-render-monitor" id="theirs"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- END Row #4 -->
        </div>



        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="p1-tab" data-toggle="tab" href="#p1" role="tab" aria-controls="p1"
                   aria-selected="true">Lifeforce</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="p2-tab" data-toggle="tab" href="#p2" role="tab" aria-controls="p2"
                   aria-selected="false">Recover</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="p3-tab" data-toggle="tab" href="#p3" role="tab" aria-controls="p3"
                   aria-selected="false">Ally ATK Support</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="p4-tab" data-toggle="tab" href="#p4" role="tab" aria-controls="p4"
                   aria-selected="true">Ally DEF Support</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="p5-tab" data-toggle="tab" href="#p5" role="tab" aria-controls="p5"
                   aria-selected="false">Enemy ATK Debuff </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="p6-tab" data-toggle="tab" href="#p6" role="tab" aria-controls="p6"
                   aria-selected="false">Enemy DEF Debuff</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="p7-tab" data-toggle="tab" href="#p7" role="tab" aria-controls="p7"
                   aria-selected="false">Combo</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="p1" role="tabpanel" aria-labelledby="p1-tab">
                <div class="row js-appear-enabled animated fadeIn" data-toggle="appear">
                    <!-- Row #4 -->
                    <div class="col-md-12">
                        <a class="block block-link-shadow overflow-hidden">
                            <div class="block-content block-content-full">
                                <div class="text-center">
                                    <h3> Lifeforce</h3>
                                </div>
                                @foreach ($p1 as $p)
                                    <div class="row py-20">
                                        <div class="col-6 text-right border-r">
                                            <div class="js-appear-enabled animated fadeIn yabbe" data-toggle="appear"
                                                 data-class="animated fadeIn">
                                                <div
                                                    class="font-size-h3 font-w600 text-info">{{number_format($p->valueA)}}</div>
                                                <div
                                                    class="font-size-sm font-w600 text-uppercase text-muted">{{$p->nameA}}</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="js-appear-enabled animated fadeIn yabbe" data-toggle="appear"
                                                 data-class="animated fadeIn">
                                                <div
                                                    class="font-size-h3 font-w600 text-success">{{number_format($p->valueB)}}</div>
                                                <div
                                                    class="font-size-sm font-w600 text-uppercase text-muted">{{$p->nameB}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="row">

                                <div class="col-xl-12">
                                    <!-- Bars Chart -->
                                    <div class="block">
                                        <div class="block-header block-header-default">
                                            <h3 class="block-title">Lifeforce</h3>
                                            <div class="block-options">
                                                <button type="button" class="btn-block-option"
                                                        data-toggle="block-option" data-action="state_toggle"
                                                        data-action-mode="demo">
                                                    <i class="si si-refresh"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="block-content block-content-full text-center">
                                            <div class="chartjs-size-monitor">
                                                <div class="chartjs-size-monitor-expand">
                                                    <div class=""></div>
                                                </div>
                                                <div class="chartjs-size-monitor-shrink">
                                                    <div class=""></div>
                                                </div>
                                            </div>
                                            <!-- Bars Chart Container -->
                                            <canvas class="js-chartjs-bars chartjs-render-monitor"
                                                    id="lifeforce"></canvas>
                                        </div>
                                    </div>
                                    <!-- END Bars Chart -->
                                </div>

                                </div>

                            </div>
                        </a>
                    </div>
                    <!-- END Row #4 -->
                </div>
            </div>


            <div class="tab-pane fade" id="p2" role="tabpanel" aria-labelledby="p2-tab">
                <div class="row js-appear-enabled animated fadeIn" data-toggle="appear">
                    <!-- Row #4 -->
                    <div class="col-md-12">
                        <a class="block block-link-shadow overflow-hidden">
                            <div class="block-content block-content-full">
                                <div class="text-center">
                                    <h3> Recover</h3>
                                </div>
                                @foreach ($p2 as $p)
                                    <div class="row py-20">
                                        <div class="col-6 text-right border-r">
                                            <div class="js-appear-enabled animated fadeIn yabbe" data-toggle="appear"
                                                 data-class="animated fadeIn">
                                                <div
                                                    class="font-size-h3 font-w600 text-info">{{number_format($p->valueA)}}</div>
                                                <div
                                                    class="font-size-sm font-w600 text-uppercase text-muted">{{$p->nameA}}</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="js-appear-enabled animated fadeIn yabbe" data-toggle="appear"
                                                 data-class="animated fadeIn">
                                                <div
                                                    class="font-size-h3 font-w600 text-success">{{number_format($p->valueB)}}</div>
                                                <div
                                                    class="font-size-sm font-w600 text-uppercase text-muted">{{$p->nameB}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="row">

                                    <div class="col-xl-12">
                                        <!-- Bars Chart -->
                                        <div class="block">
                                            <div class="block-header block-header-default">
                                                <h3 class="block-title">Recover</h3>
                                                <div class="block-options">
                                                    <button type="button" class="btn-block-option"
                                                            data-toggle="block-option" data-action="state_toggle"
                                                            data-action-mode="demo">
                                                        <i class="si si-refresh"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="block-content block-content-full text-center">
                                                <div class="chartjs-size-monitor">
                                                    <div class="chartjs-size-monitor-expand">
                                                        <div class=""></div>
                                                    </div>
                                                    <div class="chartjs-size-monitor-shrink">
                                                        <div class=""></div>
                                                    </div>
                                                </div>
                                                <!-- Bars Chart Container -->
                                                <canvas class="js-chartjs-bars chartjs-render-monitor"
                                                        id="recover"></canvas>
                                            </div>
                                        </div>
                                        <!-- END Bars Chart -->
                                    </div>

                                </div>

                            </div>
                        </a>
                    </div>
                    <!-- END Row #4 -->
                </div>
            </div>
            <div class="tab-pane fade" id="p3" role="tabpanel" aria-labelledby="p3-tab">
                <div class="row js-appear-enabled animated fadeIn" data-toggle="appear">
                    <!-- Row #4 -->
                    <div class="col-md-12">
                        <a class="block block-link-shadow overflow-hidden">
                            <div class="block-content block-content-full">
                                <div class="text-center">
                                    <h3> Ally ATK Support (Tap Name to Break stats) </h3>
                                </div>

                                @foreach ($p3 as $p)
                                    <div class="row py-20">
                                        <div class="col-6 text-right border-r" onclick="changeChart('atk', {{$ide}}, {{$p->userIdA}}, true)">
                                            <div class="js-appear-enabled animated fadeIn yabbe" data-toggle="appear"
                                                 data-class="animated fadeIn">
                                                <div
                                                    class="font-size-h3 font-w600 text-info">{{number_format($p->valueA)}}</div>
                                                <div
                                                    class="font-size-sm font-w600 text-uppercase text-muted">{{$p->nameA}}</div>
                                            </div>
                                        </div>
                                        <div class="col-6" onclick="changeChart('atk', {{$ide}}, {{$p->userIdB}}, false)">
                                            <div class="js-appear-enabled animated fadeIn yabbe" data-toggle="appear"
                                                 data-class="animated fadeIn">
                                                <div
                                                    class="font-size-h3 font-w600 text-success">{{number_format($p->valueB)}}</div>
                                                <div
                                                    class="font-size-sm font-w600 text-uppercase text-muted">{{$p->nameB}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach


                                <!-- <div class="row py-20">
                        <div class="col-12">
                            <div class="js-appear-enabled animated fadeIn" data-toggle="appear"
                                data-class="animated fadeIn">
                                <canvas class="js-chartjs-pie chartjs-render-monitor" id="piebuff"></canvas>
                            </div>
                        </div>
                    </div> -->


                                <div class="row">

                                    <div class="col-xl-12">
                                        <!-- Bars Chart -->
                                        <div class="block">
                                            <div class="block-header block-header-default">
                                                <h3 class="block-title">ATK Support</h3>
                                                <div class="block-options">
                                                    <button type="button" class="btn-block-option"
                                                            data-toggle="block-option" data-action="state_toggle"
                                                            data-action-mode="demo">
                                                        <i class="si si-refresh"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="block-content block-content-full text-center">
                                                <div class="chartjs-size-monitor">
                                                    <div class="chartjs-size-monitor-expand">
                                                        <div class=""></div>
                                                    </div>
                                                    <div class="chartjs-size-monitor-shrink">
                                                        <div class=""></div>
                                                    </div>
                                                </div>
                                                <!-- Bars Chart Container -->
                                                <canvas class="js-chartjs-bars chartjs-render-monitor"
                                                        id="atksupp"></canvas>
                                            </div>
                                        </div>
                                        <!-- END Bars Chart -->
                                    </div>

                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- END Row #4 -->
                </div>
            </div>
            <div class="tab-pane fade" id="p4" role="tabpanel" aria-labelledby="p4-tab">
                <div class="row js-appear-enabled animated fadeIn" data-toggle="appear">
                    <!-- Row #4 -->
                    <div class="col-md-12">
                        <a class="block block-link-shadow overflow-hidden">
                            <div class="block-content block-content-full">
                                <div class="text-center">
                                    <h3> Ally Def Support (Tap Name to Break stats) </h3>
                                </div>
                                @foreach ($p4 as $p)
                                <div class="row py-20">
                                        <div class="col-6 text-right border-r" onclick="changeChart('def', {{$ide}}, {{$p->userIdA}}, true)">
                                            <div class="js-appear-enabled animated fadeIn yabbe" data-toggle="appear"
                                                 data-class="animated fadeIn">
                                                <div
                                                    class="font-size-h3 font-w600 text-info">{{number_format($p->valueA)}}</div>
                                                <div
                                                    class="font-size-sm font-w600 text-uppercase text-muted">{{$p->nameA}}</div>
                                            </div>
                                        </div>
                                        <div class="col-6" onclick="changeChart('def', {{$ide}}, {{$p->userIdB}}, false)">
                                            <div class="js-appear-enabled animated fadeIn yabbe" data-toggle="appear"
                                                 data-class="animated fadeIn">
                                                <div
                                                    class="font-size-h3 font-w600 text-success">{{number_format($p->valueB)}}</div>
                                                <div
                                                    class="font-size-sm font-w600 text-uppercase text-muted">{{$p->nameB}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="row">

                                    <div class="col-xl-12">
                                        <!-- Bars Chart -->
                                        <div class="block">
                                            <div class="block-header block-header-default">
                                                <h3 class="block-title">Ally DEF Support</h3>
                                                <div class="block-options">
                                                    <button type="button" class="btn-block-option"
                                                            data-toggle="block-option" data-action="state_toggle"
                                                            data-action-mode="demo">
                                                        <i class="si si-refresh"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="block-content block-content-full text-center">
                                                <div class="chartjs-size-monitor">
                                                    <div class="chartjs-size-monitor-expand">
                                                        <div class=""></div>
                                                    </div>
                                                    <div class="chartjs-size-monitor-shrink">
                                                        <div class=""></div>
                                                    </div>
                                                </div>
                                                <!-- Bars Chart Container -->
                                                <canvas class="js-chartjs-bars chartjs-render-monitor"
                                                        id="defsupp"></canvas>
                                            </div>
                                        </div>
                                        <!-- END Bars Chart -->
                                    </div>

                                </div>

                            </div>
                        </a>
                    </div>
                    <!-- END Row #4 -->
                </div>
            </div>
            <div class="tab-pane fade" id="p5" role="tabpanel" aria-labelledby="p5-tab">
                <div class="row js-appear-enabled animated fadeIn" data-toggle="appear">
                    <!-- Row #4 -->
                    <div class="col-md-12">
                        <a class="block block-link-shadow overflow-hidden">
                            <div class="block-content block-content-full">
                                <div class="text-center">
                                    <h3> Enemy ATK Debuff (Tap Name to Break stats) </h3>
                                </div>
                                @foreach ($p5 as $p)
                                <div class="row py-20">
                                        <div class="col-6 text-right border-r" onclick="changeChart('atkd', {{$ide}}, {{$p->userIdA}}, true)">
                                            <div class="js-appear-enabled animated fadeIn yabbe" data-toggle="appear"
                                                 data-class="animated fadeIn">
                                                <div
                                                    class="font-size-h3 font-w600 text-info">{{number_format($p->valueA)}}</div>
                                                <div
                                                    class="font-size-sm font-w600 text-uppercase text-muted">{{$p->nameA}}</div>
                                            </div>
                                        </div>
                                        <div class="col-6" onclick="changeChart('atkd', {{$ide}}, {{$p->userIdB}}, false)">
                                            <div class="js-appear-enabled animated fadeIn yabbe" data-toggle="appear"
                                                 data-class="animated fadeIn">
                                                <div
                                                    class="font-size-h3 font-w600 text-success">{{number_format($p->valueB)}}</div>
                                                <div
                                                    class="font-size-sm font-w600 text-uppercase text-muted">{{$p->nameB}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="row">

                                    <div class="col-xl-12">
                                        <!-- Bars Chart -->
                                        <div class="block">
                                            <div class="block-header block-header-default">
                                                <h3 class="block-title">Enemy ATK Debuff</h3>
                                                <div class="block-options">
                                                    <button type="button" class="btn-block-option"
                                                            data-toggle="block-option" data-action="state_toggle"
                                                            data-action-mode="demo">
                                                        <i class="si si-refresh"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="block-content block-content-full text-center">
                                                <div class="chartjs-size-monitor">
                                                    <div class="chartjs-size-monitor-expand">
                                                        <div class=""></div>
                                                    </div>
                                                    <div class="chartjs-size-monitor-shrink">
                                                        <div class=""></div>
                                                    </div>
                                                </div>
                                                <!-- Bars Chart Container -->
                                                <canvas class="js-chartjs-bars chartjs-render-monitor"
                                                        id="atkdebuff"></canvas>
                                            </div>
                                        </div>
                                        <!-- END Bars Chart -->
                                    </div>

                                </div>

                            </div>
                        </a>
                    </div>
                    <!-- END Row #4 -->
                </div>
            </div>
            <div class="tab-pane fade" id="p6" role="tabpanel" aria-labelledby="p6-tab">
                <div class="row js-appear-enabled animated fadeIn" data-toggle="appear">
                    <!-- Row #4 -->
                    <div class="col-md-12">
                        <a class="block block-link-shadow overflow-hidden">
                            <div class="block-content block-content-full">
                                <div class="text-center">
                                    <h3> Enemy DEF Debuff (Tap Name to Break stats) </h3>
                                </div>
                                @foreach ($p6 as $p)
                                <div class="row py-20">
                                        <div class="col-6 text-right border-r" onclick="changeChart('defd', {{$ide}}, {{$p->userIdA}}, true)">
                                            <div class="js-appear-enabled animated fadeIn yabbe" data-toggle="appear"
                                                 data-class="animated fadeIn">
                                                <div
                                                    class="font-size-h3 font-w600 text-info">{{number_format($p->valueA)}}</div>
                                                <div
                                                    class="font-size-sm font-w600 text-uppercase text-muted">{{$p->nameA}}</div>
                                            </div>
                                        </div>
                                        <div class="col-6" onclick="changeChart('defd', {{$ide}}, {{$p->userIdB}}, false)">
                                            <div class="js-appear-enabled animated fadeIn yabbe" data-toggle="appear"
                                                 data-class="animated fadeIn">
                                                <div
                                                    class="font-size-h3 font-w600 text-success">{{number_format($p->valueB)}}</div>
                                                <div
                                                    class="font-size-sm font-w600 text-uppercase text-muted">{{$p->nameB}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                <div class="row">

                                    <div class="col-xl-12">
                                        <!-- Bars Chart -->
                                        <div class="block">
                                            <div class="block-header block-header-default">
                                                <h3 class="block-title">Enemy DEF Debuff</h3>
                                                <div class="block-options">
                                                    <button type="button" class="btn-block-option"
                                                            data-toggle="block-option" data-action="state_toggle"
                                                            data-action-mode="demo">
                                                        <i class="si si-refresh"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="block-content block-content-full text-center">
                                                <div class="chartjs-size-monitor">
                                                    <div class="chartjs-size-monitor-expand">
                                                        <div class=""></div>
                                                    </div>
                                                    <div class="chartjs-size-monitor-shrink">
                                                        <div class=""></div>
                                                    </div>
                                                </div>
                                                <!-- Bars Chart Container -->
                                                <canvas class="js-chartjs-bars chartjs-render-monitor"
                                                        id="defdebuff"></canvas>
                                            </div>
                                        </div>
                                        <!-- END Bars Chart -->
                                    </div>

                                </div>

                            </div>
                        </a>
                    </div>
                    <!-- END Row #4 -->
                </div>
            </div>
            <div class="tab-pane fade" id="p7" role="tabpanel" aria-labelledby="p7-tab">
                <div class="row js-appear-enabled animated fadeIn" data-toggle="appear">
                    <!-- Row #4 -->
                    <div class="col-md-12">
                        <a class="block block-link-shadow overflow-hidden">
                            <div class="block-content block-content-full">
                                <div class="text-center">
                                    <h3> Combo</h3>
                                </div>
                                @foreach ($p7 as $p)
                                    <div class="row py-20">
                                        <div class="col-6 text-right border-r">
                                            <div class="js-appear-enabled animated fadeIn yabbe" data-toggle="appear"
                                                 data-class="animated fadeIn">
                                                <div
                                                    class="font-size-h3 font-w600 text-info">{{number_format($p->valueA)}}</div>
                                                <div
                                                    class="font-size-sm font-w600 text-uppercase text-muted">{{$p->nameA}}</div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="js-appear-enabled animated fadeIn yabbe" data-toggle="appear"
                                                 data-class="animated fadeIn">
                                                <div
                                                    class="font-size-h3 font-w600 text-success">{{number_format($p->valueB)}}</div>
                                                <div
                                                    class="font-size-sm font-w600 text-uppercase text-muted">{{$p->nameB}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </a>
                    </div>
                    <!-- END Row #4 -->
                </div>
            </div>
        </div>

        <a data-toggle="collapse" href="#nmcollapse" role="button" aria-expanded="false" aria-controls="nmcollapse">
            <div class="bg-pattern bg-black-op-25"
                 style="background-image: url('assets/media/various/bg-pattern.png');">
                <div class="content text-center">
                    <div class="pt-50 pb-20">
                        <h1 class="font-w700 text-white mb-10">Nightmare Logs</h1>
                        <h2 class="h4 font-w400 text-white-op">Click here to Show</h2>
                    </div>
                </div>
            </div>
        </a>

        <div class="collapse container py-2 mt-4 mb-4" id="nmcollapse">
            @php
                $spacer = 1
            @endphp
            @foreach ($nml as $n)
                @if($spacer % 2 == 0)

                    <div class="row no-gutters">
                        <div class="col-sm py-2 @if($n->isOwnGuild == 1) bg-success @else bg-warning @endif">

                            <div class="card-body">
                                <div class="float-right text-muted small"
                                     style="padding-right:20px !important;">{{$n->actTime}}</div>
                                <h4 class="card-title text-muted"
                                    style="padding-left:20px !important;">{{$n->userName}}</h4>
                                <p class="card-text"
                                   style="white-space: pre-wrap !important; margin-left: 20px !important; margin-right: 20px !important;">{{$n->readableText}}</p>

                            </div>
                        </div>
                        <div class="col-sm-1 text-center flex-column d-none d-sm-flex">
                            <div class="row h-50">
                                <div class="col border-right">&nbsp;</div>
                                <div class="col">&nbsp;</div>
                            </div>
                            <h5 class="m-2">
                                <span class="badge badge-pill bg-light border">&nbsp;</span>
                            </h5>
                            <div class="row h-50">
                                <div class="col border-right">&nbsp;</div>
                                <div class="col">&nbsp;</div>
                            </div>
                        </div>
                        <div class="col-sm">
                            <!--spacer-->
                        </div>
                    </div>

                @endif

                @if($spacer % 2 == 1)

                    <div class="row no-gutters">
                        <div class="col-sm">
                            <!--spacer-->
                        </div>
                        <div class="col-sm-1 text-center flex-column d-none d-sm-flex">
                            <div class="row h-50">
                                <div class="col border-right">&nbsp;</div>
                                <div class="col">&nbsp;</div>
                            </div>
                            <h5 class="m-2">
                                <span class="badge badge-pill bg-light border">&nbsp;</span>
                            </h5>
                            <div class="row h-50">
                                <div class="col border-right">&nbsp;</div>
                                <div class="col">&nbsp;</div>
                            </div>
                        </div>
                        <div class="col-sm py-2 @if($n->isOwnGuild == 1) bg-success @else bg-warning @endif">
                            <div class="card">
                                <div class="card-body">
                                    <div class="float-right text-muted small"
                                         style="padding-right:20px !important;">{{$n->actTime}}</div>
                                    <h4 class="card-title text-muted"
                                        style="padding-left:20px !important;">{{$n->userName}}</h4>
                                    <p class="card-text"
                                       style="white-space: pre-wrap !important; margin-left: 20px !important; margin-right: 20px !important;">{{$n->readableText}}</p>
                                </div>
                            </div>
                        </div>
                    </div>


                @endif

                @php
                    $spacer++
                @endphp
            @endforeach

        </div>


        <a data-toggle="collapse" href="#blcollapse" role="button" aria-expanded="false" aria-controls="blcollapse">
            <div class="bg-pattern bg-black-op-25"
                 style="background-image: url('assets/media/various/bg-pattern.png');">
                <div class="content text-center">
                    <div class="pt-50 pb-20">
                        <h1 class="font-w700 text-white mb-10">Battle Logs</h1>
                        <h2 class="h4 font-w400 text-white-op">Click here to Show</h2>
                    </div>
                </div>
            </div>
        </a>

        <div class="collapse row" id="blcollapse">

            <div class="col-md-12 mt-5">


                <table id="btlog" class="table table-bordered data-table" style="width:100% !important;">

                    <thead>

                    <tr>
                        <th style="width:5% !important; background-color:white !important;">id</th>

                        <th style="width:20% !important; background-color:white !important;">Time</th>

                        <th style="width:20% !important; background-color:white !important;">userName</th>

                        <th style="width:5% !important; background-color:white !important;">ownGuild</th>

                        <th style="width:50% !important;    background-color:white !important;">Action</th>

                    </tr>

                    </thead>

                    <tbody>

                    </tbody>

                </table>

            </div>

        </div>


    </div>

    <div class="modal fade" id="modalMd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="modalMdTitle"></h4>
                </div>
                <div class="modal-body">
                    <div class="modalError"></div>
                    <div id="modalMdContent"></div>
                </div>
            </div>
        </div>
    </div>
@section('js_after')
    <script>
        const pieOwn = new Chart(document.getElementById('ours'), {
            type: 'pie',
            data:   {
                labels: ["Click Ally Name to breakthrough stats"],
                datasets: [{
                    data: [50],
                    backgroundColor: ["rgba(38,198,218,1)"],
                    hoverBackgroundColor: ["rgba(38,198,218,0.5)"]
                }]
            }
        });

        const pieTheir = new Chart(document.getElementById('theirs'), {
            type: 'pie',
            data:   {
                labels: ["Click Ally Name to breakthrough stats"],
                datasets: [{
                    data: [50],
                    backgroundColor: ["rgba(156,204,101,1)"],
                    hoverBackgroundColor: ["rgba(156,204,101,0.5)"]
                }]
            }
        });
        function changeChart(type, userId, matchId, ownGuild){
            const chart = ownGuild ? pieOwn : pieTheir;
            var ctx = ownGuild ? document.getElementById('nameself') : document.getElementById('nameenemy');
            var ctx2 = ownGuild ? $("#allyloader") : $("#enemyloader");
            var ctx3 = ownGuild ? $("#ours") : $("#theirs");
            ctx.scrollIntoView({
                behavior: 'smooth'
            });
            ctx3.hide();
            ctx2.show();
            // ctx.innerHTML(`${nameUser}`);
            // ctx.innerHTML(nameUser);
            // Remote ec2-18-212-84-193.compute-1.amazonaws.com should have use .env you fuckers
            //use route u fucker no knowing i named route in web.php you ass ?
            fetch(`{{ route('spec.define') }}/${type}/${matchId}/${userId}`)
                .then((response) => {
                    return response.json();
                })
                .then((data) => {
                    const labels = [];
                    const values = [];

                    Object.keys(data).forEach((key, index) => {
                        labels.push(key);
                        values.push(data[key]);
                    })

                    // Resetting the data
                    chart.data.labels.pop();
                    chart.data.datasets.forEach((dataset) => {
                        dataset.data.pop();
                    });

                    // Adding new data
                    chart.data.labels = labels;
                    chart.data.datasets[0].data = values;
                    chart.data.datasets[0].backgroundColor= ["rgba(156,204,101,1)", "rgba(255,202,40,1)"];
                    chart.data.datasets[0].hoverBackgroundColor= ["rgba(156,204,101,.5)", "rgba(255,202,40,.5)"];
                    // Updating chart
                    chart.update();
                    ctx3.show();
                    ctx2.hide();
                })
                .catch((error) => console.log(error));
        }
    </script>

    <script>
        var ctx = document.getElementById('atksupp');
        var atkbuffchart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($atkbuffnamearrayA) !!},
                datasets: [{
                    label: "{{$guild[0]->guildDataNameA}}",
                    fill: !0,
                    backgroundColor: "rgba(66,165,245,.75)",
                    borderColor: "rgba(66,165,245,1)",
                    pointBackgroundColor: "rgba(66,165,245,1)",
                    pointBorderColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(66,165,245,1)",
                    data: {!! json_encode($atkbuffvaluearrayA) !!}
                }, {
                    label: "{{$guild[0]->guildDataNameB}}",
                    fill: !0,
                    backgroundColor: "rgba(156,204,101,.25)",
                    borderColor: "rgba(156,204,101,1)",
                    pointBackgroundColor: "rgba(156,204,101,1)",
                    pointBorderColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(66,165,245,1)",
                    data: {!! json_encode($atkbuffvaluearrayB) !!}
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });


        var ctx = document.getElementById('defsupp');
        var atkbuffchart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($defbuffnamearrayA) !!},
                datasets: [{
                    label: "{{$guild[0]->guildDataNameA}}",
                    fill: !0,
                    backgroundColor: "rgba(66,165,245,.75)",
                    borderColor: "rgba(66,165,245,1)",
                    pointBackgroundColor: "rgba(66,165,245,1)",
                    pointBorderColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(66,165,245,1)",
                    data: {!! json_encode($defbuffvaluearrayA) !!}
                }, {
                    label: "{{$guild[0]->guildDataNameB}}",
                    fill: !0,
                    backgroundColor: "rgba(156,204,101,.25)",
                    borderColor: "rgba(156,204,101,1)",
                    pointBackgroundColor: "rgba(156,204,101,1)",
                    pointBorderColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(66,165,245,1)",
                    data: {!! json_encode($defbuffvaluearrayB) !!}
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });


        var ctx = document.getElementById('atkdebuff');
        var atkbuffchart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($atkdebuffnamearrayA) !!},
                datasets: [{
                    label: "{{$guild[0]->guildDataNameA}}",
                    fill: !0,
                    backgroundColor: "rgba(66,165,245,.75)",
                    borderColor: "rgba(66,165,245,1)",
                    pointBackgroundColor: "rgba(66,165,245,1)",
                    pointBorderColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(66,165,245,1)",
                    data: {!! json_encode($atkdebuffvaluearrayA) !!}
                }, {
                    label: "{{$guild[0]->guildDataNameB}}",
                    fill: !0,
                    backgroundColor: "rgba(156,204,101,.25)",
                    borderColor: "rgba(156,204,101,1)",
                    pointBackgroundColor: "rgba(156,204,101,1)",
                    pointBorderColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(66,165,245,1)",
                    data: {!! json_encode($atkdebuffvaluearrayB) !!}
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });


        var ctx = document.getElementById('defdebuff');
        var atkbuffchart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($defdebuffnamearrayA) !!},
                datasets: [{
                    label: "{{$guild[0]->guildDataNameA}}",
                    fill: !0,
                    backgroundColor: "rgba(66,165,245,.75)",
                    borderColor: "rgba(66,165,245,1)",
                    pointBackgroundColor: "rgba(66,165,245,1)",
                    pointBorderColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(66,165,245,1)",
                    data: {!! json_encode($defdebuffvaluearrayA) !!}
                }, {
                    label: "{{$guild[0]->guildDataNameB}}",
                    fill: !0,
                    backgroundColor: "rgba(156,204,101,.25)",
                    borderColor: "rgba(156,204,101,1)",
                    pointBackgroundColor: "rgba(156,204,101,1)",
                    pointBorderColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(66,165,245,1)",
                    data: {!! json_encode($defdebuffvaluearrayB) !!}
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });


        var ctx = document.getElementById('recover');
        var atkbuffchart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($recovernameA) !!},
                datasets: [{
                    label: "{{$guild[0]->guildDataNameA}}",
                    fill: !0,
                    backgroundColor: "rgba(66,165,245,.75)",
                    borderColor: "rgba(66,165,245,1)",
                    pointBackgroundColor: "rgba(66,165,245,1)",
                    pointBorderColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(66,165,245,1)",
                    data: {!! json_encode($recoverarrayA) !!}
                }, {
                    label: "{{$guild[0]->guildDataNameB}}",
                    fill: !0,
                    backgroundColor: "rgba(156,204,101,.25)",
                    borderColor: "rgba(156,204,101,1)",
                    pointBackgroundColor: "rgba(156,204,101,1)",
                    pointBorderColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(66,165,245,1)",
                    data: {!! json_encode($recoverarrayB) !!}
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });


        var ctx = document.getElementById('lifeforce');
        var atkbuffchart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($lifeforcenameA) !!},
                datasets: [{
                    label: "{{$guild[0]->guildDataNameA}}",
                    fill: !0,
                    backgroundColor: "rgba(66,165,245,.75)",
                    borderColor: "rgba(66,165,245,1)",
                    pointBackgroundColor: "rgba(66,165,245,1)",
                    pointBorderColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(66,165,245,1)",
                    data: {!! json_encode($lifeforcearrayA) !!}
                }, {
                    label: "{{$guild[0]->guildDataNameB}}",
                    fill: !0,
                    backgroundColor: "rgba(156,204,101,.25)",
                    borderColor: "rgba(156,204,101,1)",
                    pointBackgroundColor: "rgba(156,204,101,1)",
                    pointBorderColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(66,165,245,1)",
                data: {!! json_encode($lifeforcearrayB) !!}
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });


    </script>
@endsection
<script>


    $(document).on('ajaxComplete ready', function () {
        // $.noConflict();
        $('.modalMd').off('click').on('click', function () {
            $('#modalMdContent').load($(this).attr('value'));
            $('#modalMdTitle').html($(this).attr('title'));
        });
    });

    $(document).ready(function () {
        

        // $.noConflict();
// DataTable
        $('#btlog').DataTable({

            processing: true,
            serverSide: true,
            ajax: "{{route('show.getlog',$ide)}}",
            columns: [
                {data: 'id'},
                {data: 'actTime'},
                {data: 'username'},
                {data: 'isenemy'},
                {data: 'text'}
            ]
        });

    });

</script>

@endsection
