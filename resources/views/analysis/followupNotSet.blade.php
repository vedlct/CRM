@extends('main')

@section('content')
    <div class="card">
        <div class="card-body">
            <h2 align="center"><b>Not Set Followups</b></h2>
            <p align="center">You will find all leads where you forget to set followup but still holding them.</p>

            <div class="table-responsive m-t-40">
                <table id="followUpTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>Lead Id</th>
                            <th>Company Name</th>
                            <th>Website</th>
                            <th>Contact Number</th>
                            <th>Country</th>
                            <th>Category</th>
                            <th>Current Marketer</th>
                            <th>Last Follow Up</th>
                            <th>Latest Commment Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

            <input type="checkbox" id="selectall" onClick="selectAll(this)" /><b>Select All</b>
        </div>
    </div>



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



@endsection

@section('foot-js')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="{{ url('public/js/custom-alert.js') }}"></script>

    <script>

        
        $(document).ready(function () {
            $('#followUpTable').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                ajax: {
                    url: "{{ route('getFollowupNotSet') }}",
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
                    { data: 'leadId', name: 'leadId', searchable: true, orderable: true },
                    { data: 'companyName', name: 'companyName', searchable: true, orderable: true },
                    { data: 'website', name: 'website', searchable: true, orderable: true },
                    { data: 'contactNumber', name: 'contactNumber', searchable: true, orderable: true },
                    { data: 'countryName', name: 'countryName', searchable: true, orderable: true },
                    { data: 'categoryName', name: 'categoryName', searchable: true, orderable: true },
                    {
                        data: 'fullName',
                        name: 'fullName',
                        searchable: true,
                        orderable: true,
                        render: function (data, type, full, meta) {
                            return data; // Display full name
                        }
                    },
                    { data: 'lastFollowUpDate', name: 'lastFollowUpDate', searchable: true, orderable: true },
                    { data: 'workprogress_created_at', name: 'workprogress_created_at', searchable: true, orderable: true },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, full, meta) {
                            return '<a href="#" class="btn btn-info btn-sm lead-view-btn" data-lead-id="' + full.leadId + '">View Lead</a>';
                        }
                    }
                ]
            });
        });




        function selectAll(source) {
            checkboxes = document.getElementsByName('checkboxvar[]');
            for (var i in checkboxes) {
                checkboxes[i].checked = source.checked;
            }
        }


        $(document).on('click', '.lead-view-btn', function (e) {
            e.preventDefault();

            var leadId = $(this).data('lead-id');
            var newWindowUrl = '{{ url('/account') }}/' + leadId;

            window.open(newWindowUrl, '_blank');
        });

        
        
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
