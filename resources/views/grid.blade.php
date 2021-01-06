@extends('layouts.backend')

@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="block block-rounded block-transparent bg-primary">
                        <div class="block-content bg-pattern bg-black-op-25" style="background-image: url('assets/media/various/bg-pattern.png');">
                            <div class="py-20 text-center">
                                <h1 class="font-w700 text-white mb-10">{{$username}} Grid vs {{$guildenemy}}</h1>
                            </div>
                        </div>
                    </div>
                    @foreach ($imglist as $im)
                    <img src="{{ asset($im) }}"></img>
                    @endforeach
                    <div class="row justify-content-center">
            <div class="col-md-3 col-xl-6">
                <div class="block">
                    <div class="block-content" style="word-wrap: break-word !important;">
                    @php
                        $i = 1
                    @endphp
        @foreach ($gridlist as $g)
                    <h3>weapon {{$i}}</h3>
                    <p>Colo Skill   : {{ $g }}</p>
                    -----------------------------------------
                    @php
                        $i++
                    @endphp
   
        @endforeach


        </div>
                </div>
            </div>


            <div class="col-md-3 col-xl-6">
                <div class="block">
                    <div class="block-content" style="word-wrap: break-word !important;">
                    @php
                        $i = 1
                    @endphp
        @foreach ($cololist as $g)
                    <h3>weapon {{$i}}</h3>
                    <p>Colo Support : {{ $g }}</p>
                    -----------------------------------------
                    @php
                        $i++
                    @endphp
   
        @endforeach


        </div>
                </div>
            </div>
        </div>

        
    </div>
    <!-- END Page Content -->
@endsection
