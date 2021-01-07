@extends('layouts.backend')



@section('content')
    <!-- Page Content -->
    <div class="content">
        <div class="my-50 text-center">
        @foreach ($guild as $g)
            <h2 class="font-w700 text-white mb-10">Battle Log Analyzer</h2>
            <h3 class="h5 text-muted mb-0">{{ $g->guildDataNameA }} vs {{ $g->guildDataNameB }}</h3>
        
        </div>


       
</hr>
        <div class="row text-center" style="margin-top: 30px;">
                        <div class="col-6">
                            
                        <h2 style="color:white !important;"><img src="http://ec2-18-212-84-193.compute-1.amazonaws.com/media/photos/{{$g->guildDataCountryCodeA}}.png"> </img>{{ $g->guildDataNameA }}</h2>
                        <h2 style="color:white !important; text-align:left !important;">Lifeforce : {{ $g->totalGuildPointA }}</h2>  
                        <h2 style="color:white !important; text-align:left !important;">Combo : {{ $g->selfComboCount }}</h2>  
                        <h2 style="color:white !important; text-align:left !important;"> Downed Guildships: {{ $g->selfSiegeWinCount }}</h2>  

                        </div>

                        <div class="col-6">
<h2 style="color:white !important;"><img src="http://ec2-18-212-84-193.compute-1.amazonaws.com/media/photos/{{$g->guildDataCountryCodeB}}.png"> </img>{{ $g->guildDataNameB }}</h2>
                            <h2 style="color:white !important; text-align:left !important;">Lifeforce : {{ $g->totalGuildPointB }}</h2>  
                            <h2 style="color:white !important; text-align:left !important;">Combo : {{ $g->enemyComboCount }}</h2>  
                            <h2 style="color:white !important; text-align:left !important;"> Downed Guildships: {{ $g->enemySiegeWinCount }}</h2>  
    
                            </div>
        </div>
        <div class="row row-deck gutters-tiny"   id="accordion2" role="tablist" aria-multiselectable="true">
            <div class="col-md-6">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <a class="font-w600 collapsed" data-toggle="collapse" data-parent="#accordion2"
                            href="#accordion2_q1" aria-expanded="false" aria-controls="accordion2_q1">Tap to show Ally Member List</a>
                    </div>
                    <div id="accordion2_q1" class="collapse" role="tabpanel" aria-labelledby="accordion2_h1" style="">
                        <div class="block-content">
                        @foreach ($ally as $a)
                            <div class="block block-rounded">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">{{$a->name}} | HP: {{$a->maxHp}}</h3>
                                </div>
                                <div class="block-content">
                                <a href="{{ route('show.grid', [$a->userId, $ide]) }}" class="btn btn-xs btn-info modalMd" target="_blank"><div class="font-size-md text-black mb-5">Click to See {{$a->name}} Grid</div></a>
 
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>


            <div class="col-md-6">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <a class="font-w600 collapsed" data-toggle="collapse" data-parent="#accordion2"
                            href="#accordion2_q2" aria-expanded="false" aria-controls="accordion2_q2">Tap to show Enemy Member List</a>
                    </div>
                    <div id="accordion2_q2" class="collapse" role="tabpanel" aria-labelledby="accordion2_h2" style="">
                        <div class="block-content">
                        @foreach ($enemy as $a)
                            <div class="block block-rounded">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">{{$a->name}} | HP: {{$a->maxHp}}</h3>
                                </div>
                                <div class="block-content">
                                <a href="{{ route('show.grid', [$a->userId, $ide]) }}" class="btn btn-xs btn-info modalMd" target="_blank"><div class="font-size-md text-black mb-5">Click to See {{$a->name}} Grid</div></a>

                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row row-deck gutters-tiny">

        @foreach ($shinma as $s)
                   <div class="col-md-6">
                       <div class="block block-rounded">
                           <div class="block-header block-header-default">
                               <h3 class="block-title">{{$s->name}}</h3>
                           </div>
                           <div class="block-content">
                               <div class="row text-center">
                                    <div class="col-md-4">
                                        <h3 style="color:green">{{$s->guildACount}}</h3>
                                    </div>
                                    <div class="col-md-4">
                                        <h3>Vs</h3>
                                    </div>
                                    <div class="col-md-4">
                                        <h3 style="color:red">{{$s->guildBCount}}</h3>
                                    </div>
                               </div>
                           </div>

                           <p class="font-size-md text-black mb-5 ml-20">{{$s->description}}</p>
                       </div>
                   </div>
        @endforeach


</div>


        <div class="bg-pattern bg-black-op-25" style="background-image: url('assets/media/various/bg-pattern.png');">
                        <div class="content text-center">
                            <div class="pt-50 pb-20">
                                <h1 class="font-w700 text-white mb-10">Top 5</h1>
                                <h2 class="h4 font-w400 text-white-op">Top 5 Score Category</h2>
                            </div>
                    </div>
            </div>
                    @endforeach

<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="p1-tab" data-toggle="tab" href="#p1" role="tab" aria-controls="p1" aria-selected="true">Lifeforce</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="p2-tab" data-toggle="tab" href="#p2" role="tab" aria-controls="p2" aria-selected="false">Recover</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="p3-tab" data-toggle="tab" href="#p3" role="tab" aria-controls="p3" aria-selected="false">Ally ATK Support</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="p4-tab" data-toggle="tab" href="#p4" role="tab" aria-controls="p4" aria-selected="true">Ally DEF Support</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="p5-tab" data-toggle="tab" href="#p5" role="tab" aria-controls="p5" aria-selected="false">Enemy ATK Debuff </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="p6-tab" data-toggle="tab" href="#p6" role="tab" aria-controls="p6" aria-selected="false">Enemy DEF Debuff</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="p7-tab" data-toggle="tab" href="#p7" role="tab" aria-controls="p7" aria-selected="false">Combo</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="p1" role="tabpanel" aria-labelledby="p1-tab">
  <div class="row row-deck gutters-tiny text-center">
  @foreach ($p1 as $p)
                     
                        <div class="col-md-6">
                            <div class="block block-rounded">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">{{$p->nameA}}</h3>
                                </div>
                                <div class="block-content">
                                    <div class="font-size-lg text-black mb-5">{{$p->valueA}}</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="block block-rounded">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">{{$p->nameB}}</h3>
                                </div>
                                <div class="block-content">
                                    <div class="font-size-lg text-black mb-5">{{$p->valueB}}</div>
                                </div>
                            </div>
                        </div>
  @endforeach
 
                    
</div>
  </div>
  <div class="tab-pane fade" id="p2" role="tabpanel" aria-labelledby="p2-tab">
  <div class="row row-deck gutters-tiny text-center">

  @foreach ($p2 as $p)
                     
                     <div class="col-md-6">
                         <div class="block block-rounded">
                             <div class="block-header block-header-default">
                                 <h3 class="block-title">{{$p->nameA}}</h3>
                             </div>
                             <div class="block-content">
                                 <div class="font-size-lg text-black mb-5">{{$p->valueA}}</div>
                             </div>
                         </div>
                     </div>

                     <div class="col-md-6">
                         <div class="block block-rounded">
                             <div class="block-header block-header-default">
                                 <h3 class="block-title">{{$p->nameB}}</h3>
                             </div>
                             <div class="block-content">
                                 <div class="font-size-lg text-black mb-5">{{$p->valueB}}</div>
                             </div>
                         </div>
                     </div>
@endforeach
</div>
  </div>
  <div class="tab-pane fade" id="p3" role="tabpanel" aria-labelledby="p3-tab">
  <div class="row row-deck gutters-tiny text-center">

  @foreach ($p3 as $p)
                     
                     <div class="col-md-6">
                         <div class="block block-rounded">
                             <div class="block-header block-header-default">
                                 <h3 class="block-title">{{$p->nameA}}</h3>
                             </div>
                             <div class="block-content">
                                 <div class="font-size-lg text-black mb-5">{{$p->valueA}}</div>
                             </div>
                         </div>
                     </div>

                     <div class="col-md-6">
                         <div class="block block-rounded">
                             <div class="block-header block-header-default">
                                 <h3 class="block-title">{{$p->nameB}}</h3>
                             </div>
                             <div class="block-content">
                                 <div class="font-size-lg text-black mb-5">{{$p->valueB}}</div>
                             </div>
                         </div>
                     </div>
@endforeach
</div>
  </div>
  <div class="tab-pane fade" id="p4" role="tabpanel" aria-labelledby="p4-tab">
  <div class="row row-deck gutters-tiny text-center">

  @foreach ($p4 as $p)
                     
                     <div class="col-md-6">
                         <div class="block block-rounded">
                             <div class="block-header block-header-default">
                                 <h3 class="block-title">{{$p->nameA}}</h3>
                             </div>
                             <div class="block-content">
                                 <div class="font-size-lg text-black mb-5">{{$p->valueA}}</div>
                             </div>
                         </div>
                     </div>

                     <div class="col-md-6">
                         <div class="block block-rounded">
                             <div class="block-header block-header-default">
                                 <h3 class="block-title">{{$p->nameB}}</h3>
                             </div>
                             <div class="block-content">
                                 <div class="font-size-lg text-black mb-5">{{$p->valueB}}</div>
                             </div>
                         </div>
                     </div>
@endforeach
</div>
  </div>
  <div class="tab-pane fade" id="p5" role="tabpanel" aria-labelledby="p5-tab">
  <div class="row row-deck gutters-tiny text-center">

  @foreach ($p5 as $p)
                     
                     <div class="col-md-6">
                         <div class="block block-rounded">
                             <div class="block-header block-header-default">
                                 <h3 class="block-title">{{$p->nameA}}</h3>
                             </div>
                             <div class="block-content">
                                 <div class="font-size-lg text-black mb-5">{{$p->valueA}}</div>
                             </div>
                         </div>
                     </div>

                     <div class="col-md-6">
                         <div class="block block-rounded">
                             <div class="block-header block-header-default">
                                 <h3 class="block-title">{{$p->nameB}}</h3>
                             </div>
                             <div class="block-content">
                                 <div class="font-size-lg text-black mb-5">{{$p->valueB}}</div>
                             </div>
                         </div>
                     </div>
@endforeach
</div>
  </div>
  <div class="tab-pane fade" id="p6" role="tabpanel" aria-labelledby="p6-tab">
  <div class="row row-deck gutters-tiny text-center">

  @foreach ($p6 as $p)
                     
                     <div class="col-md-6">
                         <div class="block block-rounded">
                             <div class="block-header block-header-default">
                                 <h3 class="block-title">{{$p->nameA}}</h3>
                             </div>
                             <div class="block-content">
                                 <div class="font-size-lg text-black mb-5">{{$p->valueA}}</div>
                             </div>
                         </div>
                     </div>

                     <div class="col-md-6">
                         <div class="block block-rounded">
                             <div class="block-header block-header-default">
                                 <h3 class="block-title">{{$p->nameB}}</h3>
                             </div>
                             <div class="block-content">
                                 <div class="font-size-lg text-black mb-5">{{$p->valueB}}</div>
                             </div>
                         </div>
                     </div>
@endforeach
</div>
  </div>
  <div class="tab-pane fade" id="p7" role="tabpanel" aria-labelledby="p7-tab">
  <div class="row row-deck gutters-tiny text-center">

  @foreach ($p7 as $p)
                     
                     <div class="col-md-6">
                         <div class="block block-rounded">
                             <div class="block-header block-header-default">
                                 <h3 class="block-title">{{$p->nameA}}</h3>
                             </div>
                             <div class="block-content">
                                 <div class="font-size-lg text-black mb-5">{{$p->valueA}}</div>
                             </div>
                         </div>
                     </div>

                     <div class="col-md-6">
                         <div class="block block-rounded">
                             <div class="block-header block-header-default">
                                 <h3 class="block-title">{{$p->nameB}}</h3>
                             </div>
                             <div class="block-content">
                                 <div class="font-size-lg text-black mb-5">{{$p->valueB}}</div>
                             </div>
                         </div>
                     </div>
@endforeach
</div>
  </div>
</div>

<a data-toggle="collapse" href="#nmcollapse" role="button" aria-expanded="false" aria-controls="nmcollapse">
<div class="bg-pattern bg-black-op-25" style="background-image: url('assets/media/various/bg-pattern.png');">
                        <div class="content text-center">
                            <div class="pt-50 pb-20">
                                <h1 class="font-w700 text-white mb-10">Nightmare Logs</h1>
                                <h2 class="h4 font-w400 text-white-op">Click here to Show</h2>
                            </div>
                    </div>
            </div>
  </a>

            <div class="collapse container py-2 mt-4 mb-4" id="nmcollapse">
            @php
                $spacer = 1
            @endphp
            @foreach ($nml as $n)
            @if($spacer % 2 == 0)

            <div class="row no-gutters">
            <div class="col-sm py-2 @if($n->isOwnGuild == 1) bg-success @else bg-warning @endif">
                
                        <div class="card-body">
                        <div class="float-right text-muted small" style="padding-right:20px !important;">{{$n->actTime}}</div>
                        <h4 class="card-title text-muted" style="padding-left:20px !important;">{{$n->userName}}</h4>
                        <p class="card-text" style="white-space: pre-wrap !important; margin-left: 20px !important; margin-right: 20px !important;">{{$n->readableText}}</p>
            
                    </div>
                </div>
                <div class="col-sm-1 text-center flex-column d-none d-sm-flex">
                    <div class="row h-50">
                        <div class="col border-right">&nbsp;</div>
                        <div class="col">&nbsp;</div>
                    </div>
                    <h5 class="m-2">
                        <span class="badge badge-pill bg-light border">&nbsp;</span>
                    </h5>
                    <div class="row h-50">
                        <div class="col border-right">&nbsp;</div>
                        <div class="col">&nbsp;</div>
                    </div>
                </div>
                <div class="col-sm">
                    <!--spacer-->
                </div>
            </div>
        
            @endif

            @if($spacer % 2 == 1)

                <div class="row no-gutters">
                    <div class="col-sm">
                        <!--spacer-->
                    </div>
                    <div class="col-sm-1 text-center flex-column d-none d-sm-flex">
                        <div class="row h-50">
                            <div class="col border-right">&nbsp;</div>
                            <div class="col">&nbsp;</div>
                        </div>
                        <h5 class="m-2">
                            <span class="badge badge-pill bg-light border">&nbsp;</span>
                        </h5>
                        <div class="row h-50">
                            <div class="col border-right">&nbsp;</div>
                            <div class="col">&nbsp;</div>
                        </div>
                    </div>
                    <div class="col-sm py-2 @if($n->isOwnGuild == 1) bg-success @else bg-warning @endif">
                        <div class="card">
                            <div class="card-body">
                            <div class="float-right text-muted small" style="padding-right:20px !important;">{{$n->actTime}}</div>
                        <h4 class="card-title text-muted" style="padding-left:20px !important;">{{$n->userName}}</h4>
                        <p class="card-text" style="white-space: pre-wrap !important; margin-left: 20px !important; margin-right: 20px !important;">{{$n->readableText}}</p>
                            </div>
                        </div>
                    </div>
                </div>


            @endif

            @php
            $spacer++
            @endphp
            @endforeach

            </div>




            <a data-toggle="collapse" href="#blcollapse" role="button" aria-expanded="false" aria-controls="blcollapse">
<div class="bg-pattern bg-black-op-25" style="background-image: url('assets/media/various/bg-pattern.png');">
                        <div class="content text-center">
                            <div class="pt-50 pb-20">
                                <h1 class="font-w700 text-white mb-10">Battle Logs</h1>
                                <h2 class="h4 font-w400 text-white-op">Click here to Show</h2>
                            </div>
                    </div>
            </div>
  </a>

            <div class="collapse row" id="blcollapse">

<div class="col-md-12 mt-5">

    <table id="btlog" class="table table-bordered data-table" style="width:100% !important;">

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


    </div>

    <div class="modal fade" id="modalMd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="modalMdTitle"></h4>
                  </div>
                  <div class="modal-body">
                      <div class="modalError"></div>
                      <div id="modalMdContent"></div>
                  </div>
              </div>
          </div>
        </div>
   <script>


$(document).on('ajaxComplete ready', function () {
    $.noConflict();
    $('.modalMd').off('click').on('click', function () {
        $('#modalMdContent').load($(this).attr('value'));
        $('#modalMdTitle').html($(this).attr('title'));
    });
});
    $(document).ready(function(){
        console.log('{{$ide}}');
        $.noConflict();
// DataTable
$('#btlog').DataTable({
    
   processing: true,
   serverSide: true,
   ajax: "{{route('show.getlog',$ide)}}",
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
 
@endsection
