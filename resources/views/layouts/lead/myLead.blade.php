

@extends('main')


@section('content')


    <div class="card" style="padding:10px;">
        <div class="card-body">
            <h4 class="card-title">My List</h4>

            <div class="table-responsive m-t-40">
                <table id="myTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>Category</th>
                        <th>Possibility</th>
                        <th>Country</th>
                        <th>Contact Person</th>
                        <th>Contact Number</th>
                        <th>Call</th>


                    </tr>
                    </thead>
                    <tbody>

                    @foreach($leads as $lead)
                        <tr>
                            <td>{{$lead->companyName}}</td>
                            <td>{{$lead->category->categoryName}}</td>
                            <td>{{$lead->possibility->possibilityName}}</td>
                            <td>{{$lead->country->countryName}}</td>
                            <td>{{$lead->personName}}</td>
                            <td>{{$lead->contactNumber}}</td>

                            {{--<td><a href="{{route('report',['id'=>$lead->leadId])}}" class="btn btn-info btn-sm"><i class="fa fa-phone" aria-hidden="true"></i></a></td>--}}
                            <td>
                                <!-- Trigger the modal with a button -->
                                <a href="#my_modal" data-toggle="modal" class="btn btn-info btn-sm"

                                   data-lead-id="{{$lead->leadId}}">
                                <i class="fa fa-phone" aria-hidden="true"></i></a>



                            </td>


                        </tr>

                    @endforeach




                    </tbody>
                </table>
            </div>
        </div>
    </div>




    <!-- Modal -->
    <div class="modal" id="my_modal" style="">
        <div class="modal-dialog">

            <form class="modal-content" action="{{route('storeReport')}}" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" name="modal-title">Calling Report</h4>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    <input type="hidden" name="leadId">





                    <div class="form-group">
                        <label class="col-md-4"><b>Calling Report : </b></label>
                        <select class="form-control col-md-8" name="report" required>
                            <option value=""><b>(select one)</b></option>

                            @foreach($callReports as $report)
                                <option value="{{$report->callingReportId}}">{{$report->report}}</option>
                            @endforeach
                        </select>

                    </div>

                    <div class="form-group">
                        <label class="col-md-4"><b>Response : </b></label>
                        <input class="form-control col-md-8" placeholder="insert the response" name="response" required>
                    </div>

                    <div class="form-group">
                        <label class="col-md-4"><b>Progress : </b></label>
                        <select class="form-control col-md-8" name="progress" required>
                            <option value=""><b>(select one)</b></option>
                            <option value="Test job">Test job</option>
                            <option value="Closing">Closing</option>
                        </select>

                    </div>
                        <ul>
                       <div class="" style=" height: 100px; width: 80%; overflow-y: scroll; border: solid black 1px;" id="comment">

                       </div>

                        </ul>

                    <div class="form-group">
                        <label class="col-md-6"><b>Comment : </b></label>


                        <textarea class="col-md-8" rows="3" name="comment" required>

                    </textarea>
                    </div>
                               <button class="btn btn-success">Submit</button>

                   </div>










                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
                </form>
        </div>
    </div>



@endsection

@section('foot-js')

    <script src="{{asset('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>



    <script src="{{asset('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>



    <script src="{{asset('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />



    <script>

        $('#my_modal').on('show.bs.modal', function(e) {

            //get data-id attribute of the clicked element
            var leadId = $(e.relatedTarget).data('lead-id');
//            alert(leadId);
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $(e.currentTarget).find('input[name="leadId"]').val(leadId);

            $.ajax({
                type : 'post' ,
                url : '{{route('getComments')}}',
                data : {_token: CSRF_TOKEN,'leadId':leadId} ,
                success : function(data){
                    console.log(data);
                    $('#comment').html(data)

                    //alert(data);
                }
            });


        });


        $(document).ready(function() {
            $('#myTable').DataTable();

        });


        //        $('#edit-modal').on('show.bs.modal', function(e) {
        //
        //            var $modal = $(this),
        //                esseyId = e.relatedTarget.id;
        //            esseyName = e.relatedTarget.name;
        //
        //            $modal.find('#modalTitle').html(esseyName);
        //            $modal.find('#inp').val(esseyId);
        //
        //        })


    </script>


@endsection