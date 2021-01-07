@extends('layouts.backend')

@section('content')

    <!-- Page Content -->
    <div class="content">
        <div class="block block-rounded block-transparent bg-primary">
                        <div class="block-content bg-pattern bg-black-op-25" style="background-image: url('assets/media/various/bg-pattern.png');">
                            <div class="py-20 text-center">
                                <h1 class="font-w700 text-white mb-10">Visual {{$username}} Grid vs {{$guildenemy}}</h1>
                            </div>
                        </div>
                    </div>
                    <main id="main-container" style="min-height: 321px;">

<!-- Page Content -->
<div class="content">
<div class="alert alert-warning" role="alert">
  some of the grid image may not shown/mismatch (under 100% accuracy), it is because not all weapon are included in image database / not up to date to the latest. if Duplicate Image is shown it is most likely the user grid is less than 20,
  if you found the image are inaccurate please refer to the Text grid instead. you can hover/click the image to show the skill levels.
</div>  
    <div class="row gutters-tiny js-appear-enabled animated fadeIn" data-toggle="appear">
        <!-- Row #3 -->
        <div class="col-xl-8 d-flex align-items-stretch">
            <div class="block block-themed block-mode-loading-inverse block-transparent bg-image w-100" style="background-image: url('assets/media/photos/photo34@2x.jpg');">
                <div class="block-header">
                    <h3 class="block-title">
                        {{$username}} <small>Grid</small>
                    </h3>
                </div>
                <div class="block-content">
                @php
                    $b = 0
                @endphp
                
                @foreach ($imglist as $im)
                    <img src="{{ asset($im) }}" data-toggle="tooltip" data-placement="bottom"  data-html="true"
                    title="Colo Skill : <br> @if(isset($gridlist[$b])){{ $gridlist[$b] }} @else'Not found' @endif <br><br>  Colo Support : <br> @if(isset($cololist[$b])){{ $cololist[$b] }} @else'Not found' @endif "></img>
                @php
                    $b++;
                @endphp
                @endforeach
                </div>
            </div>
        </div>
        <div class="col-xl-4 d-flex align-items-stretch">
            <div class="block block-transparent bg-primary-dark d-flex align-items-center w-100">
                <div class="block-content block-content-full">
                <div class="py-15 px-20 clearfix border-black-op-b">

                        <div class="font-size-sm font-w600 text-uppercase text-success-light">Statistics</div>
                    </div>

                    <div class="py-15 px-20 clearfix border-black-op-b">

                        <div class="font-size-h3 font-w600 text-success js-count-to-enabled" data-toggle="countTo" data-speed="200" data-to="{{$apm}}">{{$apm}}</div>
                        <div class="font-size-sm font-w600 text-uppercase text-success-light">Weapon used in 20 Minutes</div>
                    </div>
                    <div class="py-15 px-20 clearfix border-black-op-b">

                        <div class="font-size-h3 font-w600 text-danger"><span data-toggle="countTo" data-speed="1000" data-to="980" class="js-count-to-enabled">{{$recover}}</span></div>
                        <div class="font-size-sm font-w600 text-uppercase text-danger-light">Total Recover</div>
                    </div>
                    <div class="py-15 px-20 clearfix border-black-op-b">
                      
                        <div class="font-size-h3 font-w600 text-warning js-count-to-enabled" data-toggle="countTo" data-speed="1000" data-to="38">{{$patkbuff}}</div>
                        <div class="font-size-sm font-w600 text-uppercase text-warning-light">Overall P.ATK buff</div>
                    </div>
                    <div class="py-15 px-20 clearfix border-black-op-b">
                      
                        <div class="font-size-h3 font-w600 text-info js-count-to-enabled" data-toggle="countTo" data-speed="1000" data-to="260">{{$matkbuff}}</div>
                        <div class="font-size-sm font-w600 text-uppercase text-info-light">Overall M.ATK buff</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Row #3 -->
    </div>
    <div class="row gutters-tiny js-appear-enabled animated fadeIn" data-toggle="appear">
        <!-- Row #4 -->
        <div class="col-md-4">
            <div class="block block-transparent bg-primary-dark">
                <div class="block-content block-content-full">
                <div class="py-15 px-20 clearfix border-black-op-b">
                      
                      <div class="font-size-h3 font-w600 text-warning js-count-to-enabled" data-toggle="countTo" data-speed="1000" data-to="260">{{$pdefbuff}}</div>
                      <div class="font-size-sm font-w600 text-uppercase text-info-light">Overall P.DEF buff</div>
                  </div>
                  <div class="py-15 px-20 clearfix border-black-op-b">
                      
                      <div class="font-size-h3 font-w600 text-info js-count-to-enabled" data-toggle="countTo" data-speed="1000" data-to="260">{{$mdefbuff}}</div>
                      <div class="font-size-sm font-w600 text-uppercase text-info-light">Overall M.DEF buff</div>
                  </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="block block-transparent bg-primary-dark">
                <div class="block-content block-content-full">
                <div class="py-15 px-20 clearfix border-black-op-b">
                      
                      <div class="font-size-h3 font-w600 text-warning js-count-to-enabled" data-toggle="countTo" data-speed="1000" data-to="260">{{$patkdebuff}}</div>
                      <div class="font-size-sm font-w600 text-uppercase text-info-light">Overall P.ATK debuff</div>
                  </div>
                  <div class="py-15 px-20 clearfix border-black-op-b">
                      
                      <div class="font-size-h3 font-w600 text-info js-count-to-enabled" data-toggle="countTo" data-speed="1000" data-to="260">{{$matkdebuff}}</div>
                      <div class="font-size-sm font-w600 text-uppercase text-info-light">Overall M.ATK debuff</div>
                  </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="block block-transparent bg-primary-dark">
                <div class="block-content block-content-full">
                <div class="py-15 px-20 clearfix border-black-op-b">
                      
                      <div class="font-size-h3 font-w600 text-warning js-count-to-enabled" data-toggle="countTo" data-speed="1000" data-to="260">{{$pdefdebuff}}</div>
                      <div class="font-size-sm font-w600 text-uppercase text-info-light">Overall P.DEF debuff</div>
                  </div>
                  <div class="py-15 px-20 clearfix border-black-op-b">
                      
                      <div class="font-size-h3 font-w600 text-info js-count-to-enabled" data-toggle="countTo" data-speed="1000" data-to="260">{{$mdefdebuff}}</div>
                      <div class="font-size-sm font-w600 text-uppercase text-info-light">Overall M.DEF debuff</div>
                  </div>
                </div>
            </div>
        </div>
        <!-- END Row #4 -->
    </div>
</div>
<!-- END Page Content -->

</main>

<div class="bg-pattern bg-black-op-25" style="background-image: url('assets/media/various/bg-pattern.png');">
                        <div class="content text-center">
                            <div class="pt-50 pb-20">
                                <h1 class="font-w700 text-white mb-10">Individual Battle Log</h1>
                                <h2 class="h4 font-w400 text-white-op">{{$username}} Battle logs</h2>
                            </div>
                    </div>
            </div>
        <div class="row">

<div class="col-md-12 mt-5">

    <table id="btlog" class="table table-bordered data-table">

        <thead>

            <tr>
                <th style="background-color:white !important;">id</th>

                <th style="background-color:white !important;">Time</th>

                <th style="background-color:white !important;">userName</th>

                <th style="background-color:white !important;">ownGuild</th>

                <th style="background-color:white !important;">Action</th>

            </tr>

        </thead>

        <tbody>

        </tbody>

    </table>

</div>

</div>



<div class="block block-rounded block-transparent bg-primary">
                        <div class="block-content bg-pattern bg-black-op-25" style="background-image: url('assets/media/various/bg-pattern.png');">
                            <div class="py-20 text-center">
                                <h1 class="font-w700 text-white mb-10">Text Grid Analyze</h1>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row justify-content-center">
            <div class="col-md-6 col-xl-12">
                <div class="block">
                    <div class="block-content" style="word-wrap: break-word !important;">
                    @php
                        $i = 1;
                        $b = 0;
                    @endphp
        @foreach ($gridlist as $g)
                    <h3>Weapon {{$i}}</h3>
                    <p>Colo Skill   : {{ $g }}</p>
                    <p>Colo Supp    : {{ $cololist[$b] }}</p>
                    -----------------------------------------
                    @php
                        $i++;
                        $b++;
                    @endphp
   
        @endforeach


        </div>
                </div>
            </div>


        
   <script>


    $(document).ready(function(){
        $.noConflict();
// DataTable
$('#btlog').DataTable({
    
   processing: true,
   serverSide: true,
   ajax: "{{route('show.getlog2',[$ide,$uid])}}",
   columns: [
      { data: 'id' },
      { data: 'actTime' },
      { data: 'username' },
      { data: 'isenemy' },
      { data: 'text' }
   ]
});

});

       </script>
    </div>
    <!-- END Page Content -->
@endsection
