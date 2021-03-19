<!DOCTYPE html>
<html>

<head>
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@flickr" />
    <meta name="twitter:title" content="Suspicious link" />
    <meta name="twitter:description" content="this link will give you corona" />
    <meta name="twitter:image"
        content="https://cdn.shopify.com/s/files/1/0078/7038/2195/products/CoronaExtraLagerBottle_1x710ml_1024x1024.jpg?v=1606545539" />

    <title>GC 8 Rank</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h2 class="mb-4">GC 8 Rank (Last Update : {{$lu}} UTC)</h2>
        <h3>Reset Time : 05:00 UTC</h3>
        <p>Update on : 15:30 UTC / 22:30 GMT+7, 23:00 UTC / 06:00 GMT +7, 05:00 UTC / 12:00 GMT +7</p>
        <label for="ts">Select TS:</label>

        <select name="ts" id="ts">
            <option value="all" {{ $ide == 'all' ? 'selected' : '' }}>All</option>
            <option value="1" {{ $ide == 1 ? 'selected' : '' }}>1</option>
            <option value="2" {{ $ide == 2 ? 'selected' : '' }}>2</option>
            <option value="3" {{ $ide == 3 ? 'selected' : '' }}>3</option>
            <option value="4" {{ $ide == 4 ? 'selected' : '' }}>4</option>
            <option value="5" {{ $ide == 5 ? 'selected' : '' }}>5</option>
            <option value="6" {{ $ide == 6 ? 'selected' : '' }}>6</option>
            <option value="7" {{ $ide == 7 ? 'selected' : '' }}>7</option>
            <option value="8" {{ $ide == 8 ? 'selected' : '' }}>8</option>
            <option value="9" {{ $ide == 9 ? 'selected' : '' }}>9</option>
            <option value="10" {{ $ide == 10 ? 'selected' : '' }}>10</option>
            <option value="11" {{ $ide == 11 ? 'selected' : '' }}>11</option>
            <option value="12" {{ $ide == 12 ? 'selected' : '' }}>12</option>
            <option value="13" {{ $ide == 13 ? 'selected' : '' }}>13</option>
        </select>
        <div class="row">
            <div class="col-md-12" style="overflow:auto;">
        <table class="table table-bordered yajra-datatable" id="tbl1">
            <thead>
                <tr>
                    <th>Rank (Server)</th>
                    <th>Rank (TS)</th>
                    <th>Guild Name</th>
                    <th>Day 1</th>
                    <th>Day 2</th>
                    <th>Day 3</th>
                    <th>Day 4</th>
                    <th>Day 5</th>
                    <th>Day 6</th>
                    <th>Lifeforce Gain</th>
                    <th>Win</th>
                    <th>Lose</th>
                    <th>Total Battle</th>
                    <th>TS</th>

                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
</div>
</div>
        <div class="row">
            <div class="col-md-12">
                <h2> Due Lack of US TS Final slot information, the Final US Prediction wasn't Showed </h2>

            </div>

            
        </div>

        <div class="row">
            <div class="col-md-6">
                <h1> Final Asia Prediction </h1>
                <table class="table table-bordered yajra-datatable" id="tbl2">
                    <thead>
                        <tr>
                            <th>Guild Name</th>
                            <th>Versus</th>
                            <th>Guild Name</th>

                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

            
        </div>
    </div>

</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {

        $('#tbl1').DataTable({

            processing: true,
            serverSide: true,
            orderable: true,
            ajax: "{{route('get.gc', $ide)}}",
            columns: [{
                    data: 'grank',
                    name: 'Rank',
                    sortable: false
                },
                {
                    data: 'tsrank',
                    name: 'TS Rank',
                    sortable: false
                },
                {
                    data: 'guildName',
                    name: 'Guild Name',
                    render: function (data, type, full, meta) {
                        return "<a href='{{route('show.guild')}}/" + full.guildId + "'>" + full
                            .guildName + "</a>";
                    },
                    sortable: false
                },
                {
                    data: 'point',
                    name: 'LF Day 1'
                },
                {
                    data: 'point2',
                    name: 'LF Day 2'
                },
                {
                    data: 'point3',
                    name: 'LF Day 3'
                },
                {
                    data: 'point4',
                    name: 'LF Day 4'
                },
                {
                    data: 'point5',
                    name: 'LF Day 5'
                },
                {
                    data: 'point6',
                    name: 'LF Day 6'
                },
                {
                    data: 'gain',
                    name: 'Lifeforce Gain',
                    sortable: false
                },
                {
                    data: 'winPoint',
                    name: 'Win',
                    sortable: false
                },
                {
                    data: 'losePoint',
                    name: 'Lose',
                    sortable: false
                },
                {
                    data: 'sourceCount',
                    name: 'Total Battle',
                    sortable: false
                },
                {
                    data: 'gvgTimeType',
                    name: 'TS',
                    sortable: false
                },
            ]
        });

        $('#tbl2').DataTable({

            processing: true,
            serverSide: true,
            orderable: true,
            searching: false,
            lengthChange: false,
            pageLength: 50,
            ajax: "{{route('get.finala')}}",
            columns: [{
                    data: 'guildNameA',
                    name: 'Guild A',
                    sortable: false
                },
                {
                    data: 'versus',
                    name: 'Guild Name',
                    sortable: false
                },
                {
                    data: 'guildNameB',
                    name: 'Guild B',
                    sortable: false
                }
            ]
        });

       

        document.getElementById('ts').addEventListener('change', function (e) {
            window.location.href = "{{route('show.gc')}}/" + e.target.value;
        });

    });

</script>

</html>
