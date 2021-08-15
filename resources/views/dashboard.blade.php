@extends('layouts.backend')

@section('content')
<!-- Page Content -->
<div class="content">
    <div class="block block-rounded block-transparent bg-primary">
        <div class="block-content bg-pattern bg-black-op-25"
            style="background-image: url('assets/media/various/bg-pattern.png');">
            <div class="py-20 text-center">
                <h1 class="font-w700 text-white mb-10">Welcome back {{$discordname}}</h1>
                <h2 class="h4 font-w400 text-white-op"> to Kurelog.</h2>
            </div>
        </div>
    </div>

    <a href="{{ route('show.gc', 'all') }}">
        <div class="row justify-content-center">
            <div class="col-md-6 col-xl-12">
                <div class="block">
                    <div class="block-content">
                        <h1>GC 13 Rank Data</h1>

                    </div>
                </div>
            </div>
        </div>
    </a>


    @if(count($isentry) > 0)


    <div class="row gutters-tiny js-appear-enabled animated fadeIn" data-toggle="appear">
        <div class="col-xl-12 d-flex align-items-stretch">
            <div class="block block-transparent bg-primary-dark d-flex align-items-center w-100">
                <div class="block-content block-content-full">
                    <div class="py-15 px-20 clearfix border-black-op-b">

                        <div class="font-size-sm font-w600 text-uppercase text-success-light"> GC 12 Finals (0 LF Guild was not shown here)</div>

                    </div>
                
                    <div class="py-15 px-20 clearfix border-black-op-b">
                        @foreach ($a as $g)
                        <a href="{{ route('show.gridonly', $g->gvgDataId) }}">
                            <div class="row justify-content-center">
                                <div class="col-md-6 col-xl-12">
                                    <div class="block">
                                        <div class="block-content">
                                            <h1>{{ $g->battleEndTime }} @if($g->selfComboCount == 105) [US] @else [ASIA] @endif </br> {{ $g->guildDataNameA }} vs
                                                {{ $g->guildDataNameB }}</h1>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach



                    </div>


                    <div class="py-15 px-20 clearfix border-black-op-b">
                        
                            <div class="row justify-content-center">
                            <div class="col-md-3 col-xl-12"></div>
                                <div class="col-md-6 col-xl-12">
                                    
                                {{ $a->links() }}

                                </div>
                                <div class="col-md-3 col-xl-12"></div>

                            </div>
                     
                       



                    </div>







                </div>
            </div>
        </div>
    </div>

    @else

            
    <form>
                     <input type="hidden" name="discord_id" value="{{$discordid}}" />
                     <input type="hidden" name="discord_name" value="{{$discordname}}" />
                    

        
        <div class="row gutters-tiny js-appear-enabled animated fadeIn" data-toggle="appear">
            <div class="col-xl-12 d-flex align-items-stretch">
                    <div class="block block-transparent bg-primary-dark d-flex align-items-center w-100">
                        <div class="block-content block-content-full">
                            <div class="py-15 px-20 clearfix border-black-op-b">

                                <div class="font-size-sm font-w600 text-uppercase text-success-light"> GC 12 Finals Data</div>

                                 <div class="font-size-sm font-w600 text-uppercase text-success"> Max Entry Extended to 100 users, feel free to sign up, first come first served :) </div>
                            </div>

    <div class="py-15 px-20 clearfix border-black-op-b">
        <a href="#" class="access-submit">
            <div class="row justify-content-center">
            <div class="col-md-6 col-xl-12">
                <div class="block">
                    
                    <div class="block-content bg-gray js-tooltip-enabled">
                        @if(count($isentry) == 0)
                        <h1 class="textsign">Sign up</h1>
                        @else
                        <h1 class="textsign">Signed up</h1>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        </a>


                                
    </div>

                            
   </form>     
                            
                            
                            
                            

                            
                        </div>
                    </div>
                </div>
            </div>

    @endif





</div>


<!-- END Page Content -->
@endsection


@section('js_after')
<script type="text/javascript">

   

    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });

   

    $(".access-submit").click(function(e){

  

        e.preventDefault();

   

        var discord_id = $("input[name=discord_id]").val();

        var discord_name = $("input[name=discord_name]").val();


        $.ajax({

           type:'POST',

           url:"{{ route('access.whitelist') }}",

           data:{discord_id:discord_id, discord_name:discord_name},

           success:function(data){
              if(data.response == true){
                    alert("Sign-up for Whitelist success.");
                    $( ".textsign" ).text( "Signed up (Please Reload browser)" );
              }
              else{
                  $( ".textsign" ).text(data.response);
              }
            
           }

        });

  

    });

</script>

@endsection
