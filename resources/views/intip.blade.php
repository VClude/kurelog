@extends('layouts.backend')

@section('content')
<!-- Page Content -->
<div class="content">
    <div class="my-50 text-center">

        <h2 class="font-w700 text-white mb-10">Mencurry Battle Log Orang</h2>
        <h3 class="h5 text-muted mb-0">dijampe jampe pake dukun biar gaul</h3>

    </div>

    <div class="row gutters-tiny js-appear-enabled animated fadeIn" data-toggle="appear">
        <!-- Row #3 -->
        <div class="col-xl-12 d-flex align-items-stretch">
            <div class="block block-transparent bg-primary-dark d-flex align-items-center w-100">
                <div class="block-content block-content-full">
                    <div class="py-15 px-20 clearfix border-black-op-b">

                        <div class="font-size-sm font-w600 text-uppercase text-success-light">{{$name}} Details</div>
                    </div>

                    <div class="py-15 px-20 clearfix border-black-op-b">

                        <div class="font-size-h3 font-w600 text-success js-count-to-enabled" data-toggle="countTo"
                            data-speed="200" data-to="149">{{$guild}}</div>
                        <div class="font-size-sm font-w600 text-uppercase text-success-light">Account Guild</div>
                    </div>

                    <div class="py-15 px-20 clearfix border-black-op-b">

                        <div class="font-size-h3 font-w600 text-success js-count-to-enabled" data-toggle="countTo"
                            data-speed="200" data-to="149">{{$created}}</div>
                        <div class="font-size-sm font-w600 text-uppercase text-success-light">Account Created</div>
                    </div>

                    <div class="py-15 px-20 clearfix border-black-op-b">

                        <div class="font-size-h3 font-w600 text-success js-count-to-enabled" data-toggle="countTo"
                            data-speed="200" data-to="149">{{$level}}</div>
                        <div class="font-size-sm font-w600 text-uppercase text-success-light">Account Level</div>
                    </div>

                    <div class="py-15 px-20 clearfix border-black-op-b">

                        <div class="font-size-h3 font-w600 text-success js-count-to-enabled" data-toggle="countTo"
                            data-speed="200" data-to="149">{{$gold}}</div>
                        <div class="font-size-sm font-w600 text-uppercase text-success-light">Gold</div>
                    </div>

                    <div class="py-15 px-20 clearfix border-black-op-b">

                        <div class="font-size-h3 font-w600 text-success js-count-to-enabled" data-toggle="countTo"
                            data-speed="200" data-to="149">{{$maxcost}}</div>
                        <div class="font-size-sm font-w600 text-uppercase text-success-light">Max Cost</div>
                    </div>

                    <div class="py-15 px-20 clearfix border-black-op-b">

                        <div class="font-size-h3 font-w600 text-success js-count-to-enabled" data-toggle="countTo"
                            data-speed="200" data-to="149">{{$latestset}}</div>
                        <div class="font-size-sm font-w600 text-uppercase text-success-light">Latest used Grid Power</div>
                    </div>

                    <div class="py-15 px-20 clearfix border-black-op-b">

                        <div class="font-size-h3 font-w600 text-success js-count-to-enabled" data-toggle="countTo"
                            data-speed="200" data-to="149">{{$set}}</div>
                        <div class="font-size-sm font-w600 text-uppercase text-success-light">Main Set Grid Power</div>
                    </div>

                    <div class="py-15 px-20 clearfix border-black-op-b">

                        <div class="font-size-h3 font-w600 text-success js-count-to-enabled" data-toggle="countTo"
                            data-speed="200" data-to="149">{{$stamina}} / {{$staminamax}}</div>
                        <div class="font-size-sm font-w600 text-uppercase text-success-light">AP Left</div>
                    </div>

                    <div class="py-15 px-20 clearfix border-black-op-b">

                        <div class="font-size-h3 font-w600 text-success js-count-to-enabled" data-toggle="countTo"
                            data-speed="200" data-to="149">{{$hp}} ({{$hpbonus}} Base HP from class)</div>
                        <div class="font-size-sm font-w600 text-uppercase text-success-light">HP</div>
                    </div>

                    <div class="py-15 px-20 clearfix border-black-op-b">

                        <div class="font-size-h3 font-w600 text-success js-count-to-enabled" data-toggle="countTo"
                            data-speed="200" data-to="149">{{$patk}} ({{$patkbonus}} Base PATK from class)</div>
                        <div class="font-size-sm font-w600 text-uppercase text-success-light">HP</div>
                    </div>

                    <div class="py-15 px-20 clearfix border-black-op-b">

                        <div class="font-size-h3 font-w600 text-success js-count-to-enabled" data-toggle="countTo"
                            data-speed="200" data-to="149">{{$pdef}} ({{$pdefbonus}} Base PDEF from class)</div>
                        <div class="font-size-sm font-w600 text-uppercase text-success-light">HP</div>
                    </div>

                    <div class="py-15 px-20 clearfix border-black-op-b">

                        <div class="font-size-h3 font-w600 text-success js-count-to-enabled" data-toggle="countTo"
                            data-speed="200" data-to="149">{{$matk}} ({{$matkbonus}} Base MATK from class)</div>
                        <div class="font-size-sm font-w600 text-uppercase text-success-light">HP</div>
                    </div>

                    <div class="py-15 px-20 clearfix border-black-op-b">

                        <div class="font-size-h3 font-w600 text-success js-count-to-enabled" data-toggle="countTo"
                            data-speed="200" data-to="149">{{$mdef}} ({{$mdefbonus}} Base MDEF from class)</div>
                        <div class="font-size-sm font-w600 text-uppercase text-success-light">HP</div>
                    </div>




                </div>
            </div>
        </div>
        <!-- END Row #3 -->
    </div>


</div>

@endsection
