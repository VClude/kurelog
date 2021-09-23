@extends('layouts.backend')

@section('content')
    <!-- Page Content -->
    <div class="content">

        <div class="bg-pattern bg-black-op-25" style="background-image: url('assets/media/various/bg-pattern.png');">
            <div class="content text-center">
                <div class="pt-50 pb-20">
                    <h1 class="font-w700 text-white mb-10">Sinoalice Skins</h1>
                    <h2 class="h4 font-w400 text-white-op">Finally can get rid Alice HNM xd</h2>
                    
                    <h2 class="h4 font-w400 text-white-op">How to use :</h2>
                    <h2 class="h4 font-w400 text-white-op">Extract and replace the zip to Android/data/com.nexon.sinoalice/files/UnityCache/Shared</h2>
                </div>
            </div>
        </div>
        
        <div class="row gutters-tiny js-appear-enabled animated fadeIn" id="accordion2" role="tablist"
                aria-multiselectable="true" data-toggle="appear">
                <!-- Row #4 -->
                <div class="col-md-12">
                    <div class="block block-themed block-mode-loading-inverse block-transparent bg-image w-100">
  
                            -->
                        <div class="block-header" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_q1"
                            aria-expanded="false" aria-controls="accordion2_q1">
                            <h3 class="block-title center">
                                Click to see Rapunzel Armpits
                            </h3>
                        </div>
                        <!-- </a> -->

                        <div class="block-content block-content-full collapse" id="accordion2_q1" role="tabpanel"
                            aria-labelledby="accordion2_h1">

                             <div class="bg-pattern bg-black-op-25" style="background-image: url('assets/media/various/bg-pattern.png');">
                        <div class="content text-center">
                            <div class="pt-50 pb-20">
                                <h2 class="h4 font-w400 text-white-op">sniff sniff rapunzel armpits wangy</h2>
                                
                                <img src="https://cdn.discordapp.com/attachments/879576453300236370/879730181269491752/Screenshot_387.png"</img>
            
                            </div>
                        </div>
                    </div>

                        </div>
                    </div>
                </div>
                <!-- END Row #4 -->
            </div>
    
        

        
        <div class="alert alert-warning" role="alert">
                This Skin was Client-side, so only you can see this skin, i am not responsible for anything and any flex on maincord, if you are extracting the zip but the replace arent prompt, try opening the game, if the skins doesnt show up, you extract on the wrong place, More skins will be available in the future.
            </div>
            <div class="alert alert-warning" role="alert">
                Open Request for skins, just DM VClude#4666 on discord 
            </div>
        
       <div class="row row-deck gutters-tiny" id="accordion2" role="tablist" aria-multiselectable="true">
            <div class="col-md-12">
                <div class="block block-rounded">
                   
                    
                            @foreach ($skin as $a)
                            <div class="row js-appear-enabled animated fadeIn" data-toggle="appear">
                        <div class="col-md-12">
                            <a class="block block-link-shadow overflow-hidden" href="{{ route('download.skins', $a['id']) }}">
                                <div class="block-content block-content-full">
                                    <div class="text-left">
                                        <h3>{{$a['charaB']}} Skins (Click to Download)</h3>
                                    </div>

                                    <div class="row py-20">
                                        <div class="col-6 text-right border-r">
                                            <div class="js-appear-enabled animated fadeInLeft" data-toggle="appear"
                                                data-class="animated fadeInLeft">
                                                <div class="font-size-h3 font-w600 text-info"><img src="{{$a['imgA']}}"></img></div>
                                                <div class="font-size-sm font-w600 text-uppercase text-muted">Original Chara :

                                                </div>
                                                <div class="font-size-sm font-w600 text-uppercase text-muted">{{$a['charaA']}}

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="js-appear-enabled animated fadeInRight" data-toggle="appear"
                                                data-class="animated fadeInRight">
                                                <div class="font-size-h3 font-w600 text-success"><img src="{{$a['imgB']}}"></img></div>
                                                <div class="font-size-sm font-w600 text-uppercase text-muted">Replaced To :
                                                </div>
                                                <div class="font-size-sm font-w600 text-uppercase text-muted">{{$a['charaB']}}

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


@endsection
@section('js_after')
<script>

    $(document).ready(function () {
        

        // $.noConflict();
// DataTable


    });

</script>

@endsection
