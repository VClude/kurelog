@extends('layouts.backend')

@section('content')
    <!-- Page Content -->
    <div class="content">
    <div class="my-50 text-center">
            
                <h2 class="font-w700 text-white mb-10">Mencurry Battle Log Orang</h2>
                <h3 class="h5 text-muted mb-0">dijampe jampe pake dukun biar gaul</h3>

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
                    <div class="block-header block-header-default">
                        <a class="font-w600 collapsed" data-toggle="collapse" data-parent="#accordion2"
                           href="#accordion2_q1" aria-expanded="false" aria-controls="accordion2_q1">Tap to show
                            Member List</a>
                    </div>
                    <div id="accordion2_q1" class="collapse" role="tabpanel" aria-labelledby="accordion2_h1" style="">
                        <div class="block-content">
                            @foreach ($member as $a)
                                <div class="block block-rounded">
                                    <div class="block-header block-header-default">
                                        <h3 class="block-title">{{$a['name']}}</h3>
                                    </div>
                                    <div class="block-content">

                                        <a href="{{ route('show.profile', $a['userId']) }}"
                                           class="btn btn-xs btn-info modalMd" target="_blank">
                                            <div class="font-size-md text-black mb-5">Intip {{$a['name']}} Profile
                                            </div>
                                        </a>


                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

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
