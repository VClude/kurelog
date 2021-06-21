@extends('layouts.backend')

@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="block block-rounded block-transparent bg-primary">
                        <div class="block-content bg-pattern bg-black-op-25" style="background-image: url('assets/media/various/bg-pattern.png');">
                            <div class="py-20 text-center">
                                <h1 class="font-w700 text-white mb-10">Battle Log Analyzer</h1>
                                <h2 class="h4 font-w400 text-white-op">Choose the Match you want to see.</h2>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('show.gc', 'all') }}">
        <div class="row justify-content-center">
            <div class="col-md-6 col-xl-12">
                <div class="block">
                    <div class="block-content">
                    <h1>GC 11 Rank Data</h1>

                    </div>
                </div>
            </div>
        </div>
        </a>
        @foreach ($guild as $g)
        <a href="{{ route('show.log', $g->gvgDataId) }}">
        <div class="row justify-content-center">
            <div class="col-md-6 col-xl-12">
                <div class="block">
                    <div class="block-content">
                    <h1>{{ $g->battleEndTime }} </br> {{ $g->guildDataNameA }} vs {{ $g->guildDataNameB }}</h1>

                    </div>
                </div>
            </div>
        </div>
        </a>
        @endforeach

        @if(count($guild) == 0)
            <h1 style="color:white !important;">Battle Records not Found</h1>
        @endif

        
    </div>
    <!-- END Page Content -->
@endsection
