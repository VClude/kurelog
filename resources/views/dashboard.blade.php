@extends('layouts.backend')

@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="my-50 text-center">
            <h2 class="font-w700 text-black mb-10">Battle Log Analyzer</h2>
            <h3 class="h5 text-muted mb-0">Choose the Match you want to see.</h3>
        </div>


        @foreach ($guild as $g)
        <a href="{{ route('show.log') }}/{{ $g->gvgDataId }}">
        <div class="row justify-content-center">
            <div class="col-md-6 col-xl-8">
                <div class="block">
                    <div class="block-content">
                    <h1>{{ $g->battleEndTime }} </br> {{ $g->guildDataNameA }} vs {{ $g->guildDataNameB }}</h1>

                    </div>
                </div>
            </div>
        </div>
        </a>
        @endforeach

        
    </div>
    <!-- END Page Content -->
@endsection
