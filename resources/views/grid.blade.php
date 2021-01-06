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

                    <div class="row justify-content-center">
            <div class="col-md-6 col-xl-12">
                <div class="block">
                    <div class="block-content">
        @foreach ($gridlist as $g)

                    <p>{{ $g }}</p>


   
        @endforeach
        </div>
                </div>
            </div>
        </div>

        
    </div>
    <!-- END Page Content -->
@endsection
