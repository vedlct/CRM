@extends('main')

@section('content')




		  <div class="card" style="padding:10px;">

			  <div class="card-body">
				  <h2 class="card-title" align="center"><b>Followup List</b></h2>

                  <form method="POST" action="{{ route('follow-up.search') }}">
                      {{ csrf_field() }}
                      @component('layouts.search', ['title' => 'Search'])
                          @component('layouts.two-cols-date-search-row', ['items' => ['From Date', 'To Date'],
                          'oldVals' => [isset($searchingVals) ? $searchingVals['fromdate'] : '', isset($searchingVals) ? $searchingVals['todate'] : '']])
                          @endcomponent
                      @endcomponent
                  </form>


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
							  <th>Action</th>

						  </tr>
						  </thead>
						  <tbody>

						  @foreach($leads as $lead)
							  {{--@if($lead->followUpDate ==date('Y-m-d'))--}}
								  <tr>
								  {{--@else--}}
							  {{--<tr style="background-color:#ffcccc;">--}}
								  {{--@endif--}}

								  <td>{{$lead->companyName}}</td>
								  <td>{{$lead->category->categoryName}}</td>
								  <td>{{$lead->possibility->possibilityName}}</td>
								  <td>{{$lead->country->countryName}}</td>
								  <td>{{$lead->personName}}</td>
								  <td>{{$lead->contactNumber}}</td>

								  <td>
									  <!-- Trigger the modal with a button -->
									  <a href="#my_modal" data-toggle="modal" class="btn btn-success btn-sm"
										 data-lead-id="{{$lead->leadId}}"
										 data-lead-possibility="{{$lead->possibilityId}}">
										  <i class="fa fa-phone" aria-hidden="true"></i></a>

									  <!-- Trigger the Edit modal with a button -->
									  <a href="#edit_modal" data-toggle="modal" class="btn btn-info btn-sm"
										 data-lead-id="{{$lead->leadId}}"
										 data-lead-name="{{$lead->companyName}}"
										 data-lead-email="{{$lead->email}}"
										 data-lead-number="{{$lead->contactNumber}}"
										 data-lead-person="{{$lead->personName}}"
										 data-lead-website="{{$lead->website}}"
										 data-lead-mined="{{$lead->mined->firstName}}"
										 data-lead-category="{{$lead->category->categoryId}}">
										  <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

								  </td>
							  </tr>

						  @endforeach
						  </tbody>
					  </table>
				  </div>
			  </div>
		  </div>






		  <!-- Edit Modal -->
		  <div class="modal" id="edit_modal" style="">
			  <div class="modal-dialog" style="max-width: 60%;">
				  <div class="modal-content">
					  <div class="modal-header">
						  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						  <h4 class="modal-title" name="modal-title">Edit Lead</h4>
					  </div>
					  <div class="modal-body">
						  <form  method="post" action="{{route('leadUpdate')}}">
							  {{csrf_field()}}
							  <div class="row">
								  <div class="col-md-12" align="center">
									  <b > Mined By:   <div class="mined" id="mined"></div></b>
								  </div>
								  <div class="col-md-4">
									  <label>Category:</label>
									  <select class="form-control"  name="category" id="category">
										  <option value="">Please Select</option>
										  @foreach($categories as $category)
											  <option value="{{$category->categoryId}}">{{$category->categoryName}}</option>
										  @endforeach
									  </select>
								  </div>
								  <div class="col-md-4">
									  <input type="hidden" name="leadId">
									  <label>Company Name:</label>
									  <input type="text" class="form-control" name="companyName" value="">
								  </div>

								  <div class="col-md-4">
									  <label>Email:</label>
									  <input type="email" class="form-control" name="email" value="">
								  </div>
								  <div class="col-md-4">
									  <label>Contact Person:</label>
									  <input type="text" class="form-control" name="personName" value=""> <br><br><br>
								  </div>
								  <div class="col-md-4">
									  <label>Number:</label>
									  <input type="text" class="form-control" name="number" value="">
								  </div>
								  <div class="col-md-4">
									  <label>Website:</label>
									  <input type="text" class="form-control" name="website" value=""> <br><br><br>
								  </div>
								  <div class="col-md-6">
									  <button class="btn btn-success" type="submit">Update</button>
								  </div>
							  </div>
						  </form>
						  <br><br>
						  <form method="post" action="{{route('leaveLead')}}">
							  <div class="row">
								  {{csrf_field()}}

								  <div class=" form-group col-md-6">
									  <input type="hidden" name="leadId">
									  <label>Status:</label>
									  <select class="form-control"  name="Status" id="Status" required>
										  <option value="">Please Select</option>
										  @foreach($status as $s)
											  <option value="{{$s->statusId}}">{{$s->statusName}}</option>
										  @endforeach
									  </select>
								  </div>
								  <div class=" form-group col-md-6" style="margin-top: 3.2%">
									  <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure you want to leave this Lead?')">Leave</button>
								  </div>
								  </div>

						  </form>
					  </div>
					  <div class="modal-footer">
						  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					  </div>
				  </div>
			  </div>
		  </div> </div>









		  <!-- Call Modal -->
		  <div class="modal" id="my_modal" style="">
			  <div class="modal-dialog" style="max-width: 60%;">

				  <form class="modal-content" action="{{route('storeReport')}}" method="post">
					  <div class="modal-header">
						  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						  <h4 class="modal-title" name="modal-title">Calling Report</h4>
					  </div>
					  <div class="modal-body" style="padding: 20px;">
						  {{csrf_field()}}
						  <input type="hidden" name="leadId">

						  <div class="row">
							  <div class="col-md-6">
								  <div class="form-group" style=" margin-bottom: 5px;">
									  <label ><b>Calling Report : </b></label>
									  <select class="form-control" name="report" required>
										  <option value="4"><b>Follow Up</b></option>

										  {{--@foreach($callReports as $report)--}}
											  {{--<option value="{{$report->callingReportId}}">{{$report->report}}</option>--}}
										  {{--@endforeach--}}
									  </select>
								  </div>

								  <div class="form-group" style=" margin-bottom: 5px;">
									  <label ><b>Progress : </b></label>
									  <select class="form-control" name="progress" >
										  <option value=""><b>(select one)</b></option>
										  <option value="Test job">Test Job</option>
										  <option value="Closing">Closing</option>
									  </select>
									  <br>
								  </div>

								  <div class="form-group">
									  <label class=""><b>Follow Up Date : </b> <span id="exceed" style="color:red;display: none"><i>Already Exceed the limit 10</i></span></label>
									  <input class="form-control changedate" id="datepicker"  rows="3" name="followup" placeholder="pick Date">
								  </div>


								  <div class="form-group" style=" margin-bottom: 5px;">
									  <label class=""><b>Possibility : </b></label>
									  <select class="form-control"  name="possibility" id="possibility">
										  @foreach($possibilities as $p)
											  <option value="{{$p->possibilityId}}">{{$p->possibilityName}}</option>
										  @endforeach

									  </select>
								  </div>


								  <div class="form-group" style=" margin-bottom: 5px;">
									  <label class=""><b>Comment : </b></label>
									  <textarea class="form-control" rows="3" name="comment" required></textarea>
								  </div>
							  </div>
							  <div class="col-md-6">
								  <ul class="list-group" style="margin: 10px; "><br>
									  <div  style="height: 360px; width: 100%; overflow-y: scroll; border: solid black 1px;" id="comment">

									  </div>
								  </ul>
							  </div>

							  <div class="col-md-12"><br>
								  <button class="btn btn-success">Submit</button>
							  </div>
						  </div>


					  </div>
					  <div class="modal-footer">
						  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					  </div>
				  </form>
			  </div>
		  </div>




@endsection

@section('foot-js')

	<script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>

	<script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
	<script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>


	<script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>
	<meta name="csrf-token" content="{{ csrf_token() }}" />



	<script>

        //for Edit modal

        $('#edit_modal').on('show.bs.modal', function(e) {

            //get data-id attribute of the clicked element
            var leadId = $(e.relatedTarget).data('lead-id');
            var leadName = $(e.relatedTarget).data('lead-name');
            var email = $(e.relatedTarget).data('lead-email');
            var number = $(e.relatedTarget).data('lead-number');
            var personName = $(e.relatedTarget).data('lead-person');
            var website = $(e.relatedTarget).data('lead-website');
            var minedBy=$(e.relatedTarget).data('lead-mined');
            var category=$(e.relatedTarget).data('lead-category');


            //populate the textbox
            $('#category').val(category);
            $('div.mined').text(minedBy);
            $(e.currentTarget).find('input[name="leadId"]').val(leadId);
            $(e.currentTarget).find('input[name="companyName"]').val(leadName);
            $(e.currentTarget).find('input[name="email"]').val(email);
            $(e.currentTarget).find('input[name="number"]').val(number);
            $(e.currentTarget).find('input[name="personName"]').val(personName);
            $(e.currentTarget).find('input[name="website"]').val(website);
            $(e.currentTarget).find('#leave').attr('href', '/lead/leave/'+leadId);

        });

        $( function() {
            $( "#datepicker" ).datepicker();
        } );

        $( function() {
            $( "#fromdate" ).datepicker();
            $( "#todate" ).datepicker();
        } );


		// check followup limit

        $('.changedate').on('change',function(){
            var currentdate = $('.changedate').val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type:'post',
                url:'{{route('followupCheck')}}',
                data:{_token: CSRF_TOKEN,'currentdate':currentdate},
                success : function(data)
                {
                    if(data >= 10)
                    {
                        document.getElementById('exceed').style.display="inline";
                    }
                    else
                    {
                        document.getElementById('exceed').style.display="none";
                    }
                }
            });
        });


        //for Call Modal

        $('#my_modal').on('show.bs.modal', function(e) {

            //get data-id attribute of the clicked element
            var leadId = $(e.relatedTarget).data('lead-id');
            var possibility=$(e.relatedTarget).data('lead-possibility');


            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $(e.currentTarget).find('input[name="leadId"]').val(leadId);



            $('#possibility').val(possibility);
            //$(e.currentTarget).find('input[name="possibility"]').val(possibility);

            $.ajax({
                type : 'post' ,
                url : '{{route('getComments')}}',
                data : {_token: CSRF_TOKEN,'leadId':leadId} ,
                success : function(data){
                    $('#comment').html(data);
                    $("#comment").scrollTop($("#comment")[0].scrollHeight);
                }
            });

        });


        $(document).ready(function() {
            $('#myTable').DataTable({
                "processing": true
            });

        });





	</script>


@endsection






































