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
                        <h1>GC 12 Rank Data</h1>

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

                        <div class="font-size-sm font-w600 text-uppercase text-success-light"> GC 12 Finals  (Still Parsing)</div>

                    </div>

                    <div class="py-15 px-20 clearfix border-black-op-b">
                        @foreach ($guild as $g)
                        <a href="{{ route('show.gridonly', $g->gvgDataId) }}">
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








                </div>
            </div>
        </div>
    </div>

    @endif





</div>


<!-- END Page Content -->
@endsection
