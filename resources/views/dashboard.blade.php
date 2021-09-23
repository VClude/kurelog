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
    
       <a href="{{ route('sino.skins') }}">
        <div class="row justify-content-center">
            <div class="col-md-6 col-xl-12">
                <div class="block">
                    <div class="block-content">
                        <h1>
🔥 Sinoalice Skins</h1>

                    </div>
                </div>
            </div>
        </div>
    </a>
    

    

    
        <a href="https://ko-fi.com/kurelog">
        <div class="row justify-content-center">
            <div class="col-md-6 col-xl-12">
                <div class="block">
                    <div class="block-content">
                        <h1>☕ Support Kurelog</h1>

                    </div>
                </div>
            </div>
        </div>
    </a>
    
  
    
                            @foreach ($de as $g)
                            @if($g->gvgDataId == 2219301)
                                                    <a href="{{ route('show.gridonly', $g->gvgDataId) }}">

                            @else
                                                    <a href="{{ route('show.log', $g->gvgDataId) }}">

                            @endif
                            <div class="row justify-content-center">
                                <div class="col-md-6 col-xl-12">
                                    <div class="block">
                                        <div class="block-content">
                                            <h1>{{ $g->battleEndTime }} </br> {{ $g->guildDataNameA }} vs
                                                {{ $g->guildDataNameB }}</h1>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                        @endforeach






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
