@extends('main')

@section('content')
    <div class="box-body">
        <div class="card" style="padding: 2px;">
            <div class="card-header">
                <h2>Users Target</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <lebel>Month</lebel>
                            <select class="form-control" id="month">
                                <option value="">Select Month</option>
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <lebel>Year</lebel>
                            <select class="form-control" id="year">
                                <option value="">Select Year</option>
                                <option value="2015">2015</option>
                                <option value="2016">2016</option>
                                <option value="2017">2017</option>
                                <option value="2018">2018</option>
                                <option value="2019">2019</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                                <option value="2022">2022</option>
                                <option value="2023">2023</option>
                                <option value="2024">2024</option>
                                <option value="2025">2025</option>
                                <option value="2026">2026</option>
                                <option value="2027">2027</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="table-responsive m-t-40" >
                    <table id="UsersTarget" class="table table-striped table-condensed" style="font-size:14px;"></table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('foot-js')
    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script>
        $("#datepicker").datepicker( {
            format: "mm-yyyy",
            viewMode: "months",
            minViewMode: "months"
        });

        $(document).ready( function () {
            var d = new Date();
            var month = d.getMonth() + 1;
            var year = d.getFullYear();

            $("#month").val(month).css("background-color", "#7c9").css('color', 'white');
            $("#year").val(year).css("background-color", "#7c9").css('color', 'white');

            $('#UsersTarget').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{route('user-management.target.Get')}}',
                    type: 'POST',
                    data:function (d){
                        d._token="{{csrf_token()}}";
                        if ($('#month').val()!=""){
                            d.month=$('#month').val();
                        }
                        if ($('#year').val()!=""){
                            d.year=$('#year').val();
                        }
                    },
                },
                columns: [
                    { title:'User Name', data: 'username', name: 'username',"orderable": false, "searchable":true },
                    { title:'Call', data: 'targetCall', name: 'targetCall', "orderable": true, "searchable":true },
                    { title:'Contact', data: 'targetContact', name: 'targetContact', "orderable": true, "searchable":true },
                    { title:'High Possibility', data: 'targetHighPossibility', name: 'targetHighPossibility', "orderable": true, "searchable":true },
                    { title:'Lead Mine', data: 'targetLeadmine', name: 'targetLeadmine', "orderable": true, "searchable":true },
                    { title:'Usa', data: 'targetUsa', name: 'targetUsa', "orderable": true, "searchable":true },
                    { title:'Test', data: 'targetTest', name: 'targetTest', "orderable": true, "searchable":true },
                    { title:'File', data: 'targetFile', name: 'targetFile',"orderable": true, "searchable":true }
                ]
            });
        });

        $('#month').change(function(){
            $('#UsersTarget').DataTable().draw(true);
            if ($('#month').val()!=""){
                $('#month').css("background-color", "#7c9").css('color', 'white');
            }else {
                $('#month').css("background-color", "#FFF").css('color', 'black');
            }
        });

        $('#year').change(function(){
            $('#UsersTarget').DataTable().draw(true);
            if ($('#year').val()!=""){
                $('#year').css("background-color", "#7c9").css('color', 'white');
            }else {
                $('#year').css("background-color", "#FFF").css('color', 'black');
            }
        });

    </script>


@endsection
