@extends('layouts.backend')

@section('content')
    <!-- Page Content -->
    <div class="content">
    <div class="my-50 text-center">
            
    <h2 class="font-w700 text-white mb-10">Stalking Mode</h2>
        <h3 class="h5 text-muted mb-0">use it wisely</h3>

        </div>

        <div class="bg-pattern bg-black-op-25" style="background-image: url('assets/media/various/bg-pattern.png');">
            <div class="content text-center">
                <div class="pt-50 pb-20">
                    <h1 class="font-w700 text-white mb-10">Player Profile</h1>
                    <h2 class="h4 font-w400 text-white-op">Player Profile Category</h2>
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
                                        <h3>{{$a['name']}}</h3>
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
