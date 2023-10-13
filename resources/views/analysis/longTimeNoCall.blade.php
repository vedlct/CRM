@extends('main')



@section('content')

@php($userType = Session::get('userType'))

    <div class="card" style="padding:10px;">
        <div class="card-body">
        <h2  align="center"><b>Long Time No Update</b></h2>
        @if ( $userType =='SUPERVISOR' || $userType =='ADMIN')
            <h5 class="card-subtitle" align="center">List of leads that are not touched in last 6 months or more but in My Lead. </h5>
        @else
            <h5 class="card-subtitle" align="center">List of leads that are not touched in last 3 months or more but in My Lead. </h5>
        @endif

            <div class="col-md-5" style="float:left;">
                @if ( $userType =='SUPERVISOR' || $userType =='ADMIN')
                    <form method="POST" action="{{ route('exportLongTimeNoCall') }}">
                        {{ csrf_field() }}
                        <button class="btn btn-primary" type="submit">Export The List</button>
                    </form>
                @endif    
                <br><br>
            </div>


            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th width="5%">Select</th>
                        <th width="5%">Lead Id</th>
                        <th width="10%">Company Name</th>
                        <th width="8%">Category</th>
                        <th width="10%">website</th>
                        <th width="8%">Country</th>
                        <th width="8%">Contact Number</th>
                        <th width="7%">IPP</th>
                        <th width="10%">Last Comment</th>
                        <th width="7%">Marketer</th>
                        <th width="10%">Action</th>

                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
              
                </table>
            </div>

            <input type="checkbox" id="selectall" onClick="selectAll(this)" /><b>Select All</b>

        </div>
    </div>


@if ( $userType =='SUPERVISOR' || $userType =='ADMIN')
    <div class="row">
        <div class="form-group col-md-6">
            <label ><b>Assign To:</b></label>
                <select class="form-control"  name="assignTo" id="otherCatches2" style="width: 40%">
                    <option value="">select</option>
                    @foreach($users as $user)
                        <option value="{{$user->id}}">{{$user->firstName}} {{$user->lastName}}</option>
                    @endforeach
                </select>
        </div>
    <div>
@endif



@endsection

@section('foot-js')

    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>

    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>


    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script src="{{ url('public/js/custom-alert.js') }}"></script>


    <script>



    $(document).ready(function() {
            $('#myTable').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                ajax: {
                    url: "{!! route('getLongTimeNoCall') !!}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}"
                    }
                },
                columns: [
                    {
                        data: 'check',
                        name: 'check',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, row) {
                            return '<input type="checkbox" class="checkboxvar" name="checkboxvar[]" value="' + row.leadId + '">';
                        }
                    },    
                    { data: 'leadId', name: 'leadId' },
                    { data: 'companyName', name: 'companyName' },
                    { data: 'category.categoryName', name: 'category.categoryName' },
                    { data: 'website', name: 'website' },
                    { data: 'country.countryName', name: 'country.countryName' },
                    { data: 'contactNumber', name: 'contactNumber' },
                    {
                        data: 'ippStatus',name: 'ippStatus',
                        render: function(data, type, full, meta) {
                        return data === 1 ? 'Yes' : 'No';
                        }
                    },                    
                    { data: 'workprogress_created_at', name: 'workprogress_created_at' },
                    { data: 'firstName', name: 'firstName' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
        });


            $(document).on('click', '.lead-view-btn', function(e) {
                e.preventDefault();

                var leadId = $(this).data('lead-id');
                var newWindowUrl = '{{ url('/account') }}/' + leadId;

                window.open(newWindowUrl, '_blank');
            });


        function selectAll(source) {
            checkboxes = document.getElementsByName('checkboxvar[]');
            for (var i in checkboxes) {
                checkboxes[i].checked = source.checked;
            }
        }

        
        $("#otherCatches2").change(function() {

            var chkArray = [];
            var userId=$(this).val();
            $('.checkboxvar:checked').each(function (i) {

                chkArray[i] = $(this).val();
            });
            //alert(chkArray)
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            // $("#inp").val(JSON.stringify(chkArray));
            // $( "#assign-form" ).submit();
            jQuery('input:checkbox:checked').parents("tr").remove();
            $(this).prop('selectedIndex',0);

            $.ajax({
                type : 'post' ,
                url : '{{route('assignStore')}}',
                data : {_token: CSRF_TOKEN,'leadId':chkArray,'userId':userId} ,
                success : function(data){
                    console.log(data);
                    if(data == 'true'){
                        successAlert('Leads are assigned successfully');
                        // $('#alert').html(' <strong>Success!</strong> Assigned');
                        // $('#alert').show();

                    }
                }
            });

        });

    </script>


@endsection