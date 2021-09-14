@extends('layouts.backend')

@section('content')
    <!-- Page Content -->
    <div class="content">
    <div class="my-50 text-center">
            
    <h2 class="font-w700 text-white mb-10">Guild/User Info</h2>
        <h3 class="h5 text-muted mb-0">u cibai ?</h3>

        </div>

        <div class="bg-pattern bg-black-op-25" style="background-image: url('assets/media/various/bg-pattern.png');">
            <div class="content text-center">
                <div class="pt-50 pb-20">
                    <img
                                            src="https://kurelog.site/public/media/photos/{{$guildData->guildCountryCode}}.png"> </img>
                    <h1 class="font-w700 text-white mb-10">{{$guildData->guildName}} </h1>
                    <h2 class="h4 font-w400 text-white-op">Guild Information</h2>
                </div>
            </div>
        </div>
        
        <div class="row gutters-tiny js-appear-enabled animated fadeIn" data-toggle="appear">
            <div class="col-xl-6 d-flex align-items-stretch">
                    <div class="block block-transparent bg-primary-dark d-flex align-items-center w-100">
                        <div class="block-content block-content-full">


                            <div class="py-15 px-20 clearfix border-black-op-b">

                                <div class="font-size-h3 font-w600 text-success">{{$guildData->guildDescription}}</div>
                                <div class="font-size-sm font-w600 text-uppercase text-success-light">Guild Description</div>
                            </div>
                            
                            <div class="py-15 px-20 clearfix border-black-op-b">

                                <div class="font-size-h3 font-w600 text-success">{{$guildData->guildLevel}}</div>
                                <div class="font-size-sm font-w600 text-uppercase text-success-light">Guild Level</div>
                            </div>
                            
                            <div class="py-15 px-20 clearfix border-black-op-b">

                                <div class="font-size-h3 font-w600 text-success">{{$rank}}</div>
                                <div class="font-size-sm font-w600 text-uppercase text-success-light">Guild Rank</div>
                            </div>
                            
                            <div class="py-15 px-20 clearfix border-black-op-b">

                                <div class="font-size-h3 font-w600 text-success">{{$guildData->ranking}}</div>
                                <div class="font-size-sm font-w600 text-uppercase text-success-light">Guild Ranking</div>
                            </div>
                            
                            <div class="py-15 px-20 clearfix border-black-op-b">

                                <div class="font-size-h3 font-w600 text-success">{{$guildData->joinMember}}/15</div>
                                <div class="font-size-sm font-w600 text-uppercase text-success-light">Guild Member</div>
                            </div>

                        </div>
                    </div>
                </div>
                
    <div class="col-xl-6 d-flex align-items-stretch">
                    <div class="block block-transparent bg-primary-dark d-flex align-items-center w-100">
                        <div class="block-content block-content-full">


                            <div class="py-15 px-20 clearfix border-black-op-b">

                                <div class="font-size-h3 font-w600 text-success">{{$guildData->masterName}}</div>
                                <div class="font-size-sm font-w600 text-uppercase text-success-light">Guild Leader</div>
                            </div>

                            <div class="py-15 px-20 clearfix border-black-op-b">

                                <div class="font-size-h3 font-w600 text-success">{{$guildData->siegeHp}}</div>
                                <div class="font-size-sm font-w600 text-uppercase text-success-light">Guildship HP</div>
                            </div>
                            
                            <div class="py-15 px-20 clearfix border-black-op-b">

                                <div class="font-size-h3 font-w600 text-success">{{$TS}}</div>
                                <div class="font-size-sm font-w600 text-uppercase text-success-light">Guild Current TS</div>
                            </div>
                            
                            <div class="py-15 px-20 clearfix border-black-op-b">

                                <div class="font-size-h3 font-w600 text-success">{{$guildData->gvgWin}} - {{$guildData->gvgDraw}} - {{$guildData->gvgLose}}</div>
                                <div class="font-size-sm font-w600 text-uppercase text-success-light">Guild Win-Draw-Lose</div>
                            </div>
                            
                            <div class="py-15 px-20 clearfix border-black-op-b">

                                <div class="font-size-h3 font-w600 text-success">-</div>
                                <div class="font-size-sm font-w600 text-uppercase text-success-light">-</div>
                            </div>
                            


                        </div>
                    </div>
                </div>
            </div>
            
        
           


        <div class="row row-deck gutters-tiny" id="accordion2" role="tablist" aria-multiselectable="true">
            <div class="col-md-12">
                <div class="block block-rounded">
                   
                    
                            @foreach ($member as $a)
                            <div class="row js-appear-enabled animated fadeIn" data-toggle="appear">
                        <div class="col-md-12">
                            <a class="block block-link-shadow overflow-hidden" href="{{ route('show.profile', $a['userId']) }}" target="_blank">
                                <div class="block-content block-content-full">
                                    <div class="text-left">
                                        <h3>{{$a['name']}} (Click to view Details)</h3>
                                    </div>
                                    <div class="text-right">
                                        <h3>Last Online : {{$a['lastlogin']}}</h3>
                                    </div>
                                    <div class="row py-20">
                                        <div class="col-6 text-right border-r">
                                            <div class="js-appear-enabled animated fadeInLeft" data-toggle="appear"
                                                data-class="animated fadeInLeft">
                                                <div class="font-size-h3 font-w600 text-info">{{$a['level']}}</div>
                                                <div class="font-size-sm font-w600 text-uppercase text-muted">Rank

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="js-appear-enabled animated fadeInRight" data-toggle="appear"
                                                data-class="animated fadeInRight">
                                                <div class="font-size-h3 font-w600 text-success">{{$a['hp']}}</div>
                                                <div class="font-size-sm font-w600 text-uppercase text-muted">HP
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row py-20">
                                        <div class="col-6 text-right border-r">
                                            <div class="js-appear-enabled animated fadeInLeft" data-toggle="appear"
                                                data-class="animated fadeInLeft">
                                                <div class="font-size-h3 font-w600 text-info">{{$a['cp']}}</div>
                                                <div class="font-size-sm font-w600 text-uppercase text-muted">Point
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="js-appear-enabled animated fadeInRight" data-toggle="appear"
                                                data-class="animated fadeInRight">
                                                <div class="font-size-h3 font-w600 text-success">{{$a['CJ2']}}</div>
                                                <div class="font-size-sm font-w600 text-uppercase text-muted">Class
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- END Row #4 -->
                    </div>
                            @endforeach
                  

                </div>
            </div>


            
        </div>











    </div>

@endsection
@section('js_after')
<script>

    $(document).ready(function () {
        

        // $.noConflict();
// DataTable


    });

</script>

@endsection
