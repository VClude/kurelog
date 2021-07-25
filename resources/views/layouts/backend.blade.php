<!doctype html>
<html lang="{{ config('app.locale') }}" class="no-focus">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>Astellia &amp; Battle Log</title>
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Fonts and Styles -->
        @yield('css_before')
        <link href="{{ asset('/js/plugins/datatables/jquery.dataTables.min.css') }}" rel="stylesheet">



        <link href="{{ asset('/js/plugins/datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,400i,600,700">
        <link rel="stylesheet" id="css-main" href="{{ asset('/css/codebase.css') }}">
   
        <style>
            table tbody td {    
                white-space: pre-wrap;
                }
                
            </style>
        <!-- You can include a specific file from public/css/themes/ folder to alter the default color theme of the template. eg: -->
        <!-- <link rel="stylesheet" id="css-theme" href="{{ asset('/css/themes/corporate.css') }}"> -->
        @yield('css_after')

        <!-- Scripts -->
        <script>window.Laravel = {!! json_encode(['csrfToken' => csrf_token(),]) !!};</script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
        <script src="{{ asset('/js/plugins/datatables/jquery.dataTables.min.js') }}" defer></script>
        <script src="{{ asset('/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
        <style>
        .kontener {
  position: relative;
}

/* Bottom right text */
.text-blok {
  position: absolute;
  bottom: 20px;
  right: 20px;
  background-color: black;
  color: white;
  padding-left: 20px;
  padding-right: 20px;
}
        </style>
    </head>
    <body>
  
        <div id="page-container" class=" enable-page-overlay page-header-modern main-content-boxed">
        
            <!-- Side Overlay-->
            <aside id="side-overlay">
                <!-- Side Header -->
                <div class="content-header content-header-fullrow">
                    <div class="content-header-section align-parent">
                        <!-- Close Side Overlay -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <button type="button" class="btn btn-circle btn-dual-secondary align-v-r" data-toggle="layout" data-action="side_overlay_close">
                            <i class="fa fa-times text-danger"></i>
                        </button>
                        <!-- END Close Side Overlay -->

                        <!-- User Info -->
                        <div class="content-header-item">
                            <a class="img-link mr-5" href="javascript:void(0)">
                                <img class="img-avatar img-avatar32" src="{{ asset('media/avatars/avatar15.jpg') }}" alt="">
                            </a>
                            <a class="align-middle link-effect text-primary-dark font-w600" href="javascript:void(0)">John Smith</a>
                        </div>
                        <!-- END User Info -->
                    </div>
                </div>
                <!-- END Side Header -->

                <!-- Side Content -->
        
                <!-- END Side Content -->
            </aside>
  
            <main id="main-container">
                @yield('content')
            </main>
            <!-- END Main Container -->

                    <!-- Footer -->
                    <footer id="page-footer" class="opacity-0">
                <div class="content py-20 font-size-xs clearfix" style="color:white !important;">
                    <div class="float-right">
                        Created by <a class="font-w600">Kureha</a>
                    </div>
                    <div class="float-left">
                        spare tc pls | 
                        <span></li><a class="font-w600" href="https://saweria.co/kureha" target="_blank">Saweria</a></span> | 
                        <span></li><a class="font-w600" href="https://ko-fi.com/kurelog" target="_blank">Ko- Fi</a> </span>
                    </div>
                </div>
            </footer>
            <!-- END Footer -->
        </div>
        <!-- END Page Container -->

        <!-- Codebase Core JS -->

        <script src="{{ asset('js/codebase.app.js') }}"></script>
       

        <!-- Laravel Scaffolding JS -->
        <script src="{{ asset('js/laravel.app.js') }}"></script>
        <script src="{{asset('/js/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
        <script src="{{asset('/js/plugins/easy-pie-chart/jquery.easypiechart.min.js')}}"></script>
        <script src="{{asset('/js/plugins/chartjs/Chart.bundle.min.js')}}"></script>
        <script src="{{asset('/js/plugins/flot/jquery.flot.min.js')}}"></script>
        <script src="{{asset('/js/plugins/flot/jquery.flot.pie.min.js')}}"></script>
        <script src="{{asset('/js/plugins/flot/jquery.flot.stack.min.js')}}"></script>
        <script src="{{asset('/js/plugins/flot/jquery.flot.resize.min.js')}}"></script>

        <!-- Page JS Code -->
        <!-- <script src="{{asset('/js/pages/be_comp_charts.min.js')}}"></script> -->

        <!-- Page JS Helpers (Easy Pie Chart Plugin) -->
        <!-- <script>jQuery(function(){ Codebase.helpers('easy-pie-chart'); });</script> -->
        @yield('js_after')
    </body>
</html>
