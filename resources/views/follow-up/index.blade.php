@extends('main')

@section('content')



		  <div class="card" style="padding: 20px">

			  <div class="card-body">
				  <h2 class="card-title" align="center"><b>Followup List</b></h2>

                  <form id="serchf" method="POST" action="{{ route('follow-up.search')}}">
                      {{ csrf_field() }}
                      @component('layouts.search', ['title' => 'Search'])
                          @component('layouts.two-cols-date-search-row', ['items' => ['From Date', 'To Date'],
                          'oldVals' => [isset($searchingVals) ? $searchingVals['fromdate'] : '', isset($searchingVals) ? $searchingVals['todate'] : '']])
                          @endcomponent
                      @endcomponent

                  </form>

				  {{--<input id="fromdate" name="fromDate" placeholder="from">--}}
				  {{--<input id="todate" name="toDate" placeholder="to">--}}
				  {{--<button onclick="search()">Search</button>--}}

				{{--  <div class="row">
					  <table class="table table-bordered table-striped">
						  <thead>
						  <tr>
							  <th>time diff</th>
						  </tr>
						  </thead>
						  <tbody>
						  @foreach($totalDuration as $t)
							  <tr>
								  <td>{{ $t }}</td>
							  </tr>
						  @endforeach
						  </tbody>
					  </table>
				  </div>--}}

				  <div class="table-responsive m-t-40">
					  <table id="myTable" class="table table-bordered table-striped">
						  <thead>
						  <tr>
							  <th width="5%">Id</th>
							  <th width="15%">Company Name</th>
							  <th>Category</th>
							  <th>Possibility</th>
							  <th>Probability</th>
							  <th>Country</th>
							  <th width="5%">Contact Person</th>
							  <th>Contact Number</th>
							  <th>Time</th>
							  <th width="8%">Action</th>

						  </tr>
						  </thead>
						  <tbody>

						  @foreach($leads as $lead)
							  @if($lead->followUpDate >=date('Y-m-d'))
								  <tr>
								  @else
							  <tr style="background-color:#ffcccc;">
								  @endif

								  <td width="5%">{{$lead->leadId}}</td>
								  <td width="15%">{{$lead->companyName}}</td>
								  <td>{{$lead->category->categoryName}}</td>
								  <td>{{$lead->possibility->possibilityName}}</td>
								  <td>@if(!empty($lead->probability->probabilityName)){{$lead->probability->probabilityName}}@endif</td>
								  <td>{{$lead->country->countryName}}</td>
								  <td width="5%">{{$lead->personName}}</td>
									  <td><a href="skype::{{$lead->contactNumber."?call"}}">{{$lead->contactNumber}}</a></td>
									  <td>{{$lead->time}}</td>

								  <td width="8%">
									  <!-- Trigger the modal with a button -->
									  <a href="#my_modal" data-toggle="modal" class="btn btn-success btn-sm"
										 data-lead-id="{{$lead->leadId}}"
										 data-lead-possibility="{{$lead->possibilityId}}"
										 data-lead-probability="{{$lead->probabilityId}}"
										 data-follow-id="{{$lead->followId}}">
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
										 data-lead-category="{{$lead->category->categoryId}}"
										 data-lead-country="{{$lead->countryId}}"
										 data-lead-designation="{{$lead->designation}}"
										 data-lead-linkedin="{{$lead->linkedin}}"
										 data-lead-founded="{{$lead->founded}}"
										 data-lead-employee="{{$lead->employee}}"
										 data-lead-volume="{{$lead->volume}}"
										 data-lead-frequency="{{$lead->frequency}}"
										 data-lead-process="{{$lead->process}}"
										 data-lead-comments="{{$lead->comments}}"

									  >
										  <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									  <!-- Trigger the Statistics modal with a button -->
									  <a href="#stat_modal" data-toggle="modal" class="btn btn-dark btn-sm"
										 data-lead-id="{{$lead->leadId}}"
										 data-follow-id="{{$lead->followId}}">
										  <i class="fa fa-square-o" aria-hidden="true"></i></a>

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

							    @if(isset($fromDate) && isset($toDate))
								  <input type="hidden" value="{{$fromDate}}" name="fromDate">
								  <input type="hidden" value="{{$toDate}}" name="toDate">

							 	 @endif


                   <div class="row">

                        <!-- <div class="col-md-9" float="left">
                            <b > Mined By:   <div class="mined" id="mined"></div></b>
                        </div>
                        <div class="col-md-3" float="right">
                            <b > Lead ID:   <div class="leadId" id="leadId"></div></b>
                            <br><br>
                        </div> -->

                        <div class="col-md-3">
                                <input type="hidden" name="leadId">
                                <label><b>Company:</b></label>
                                <input type="text" class="form-control" name="companyName" value="">
                            </div>

                            <div class="col-md-3">
                                <label><b>Phone:</b></label>
                                <input type="text" class="form-control" name="number" value="">
                            </div>

							<div class="col-md-2">
									  <label>Country:</label>
									  <select class="form-control"  name="country" id="country">
										  @foreach($country as $c)
											  <option value="{{$c->countryId}}">{{$c->countryName}}</option>
										  @endforeach
									  </select>
									  <br><br><br>
								  </div>

                            <div class="col-md-2">
                                <label><b>Category:</b></label>
                                <select class="form-control"  name="category" id="category">
                                    <option value="">Please Select</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->categoryId}}">{{$category->categoryName}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label><b>Founded:</b></label>
                                <input type="text" class="form-control" name="founded" value="">
                                <br><br>
                            </div>




                            <div class="col-md-3">
                                <label><b>Website:</b></label>
                                <input type="text" class="form-control" name="website" value="">
                            </div>

                            <div class="col-md-3">
                                <label><b>Current Process:</b></label>
                                <input type="text" class="form-control" name="process" value="">
                            </div>

                            <div class="col-md-2">
                                <label><b>File Volume:</b></label>
                                <input type="text" class="form-control" name="volume" value="">
                            </div>

                            <div class="col-md-2">
                                <label><b>Frequency:</b></label>
                                <input type="text" class="form-control" name="frequency" value="">
                            </div>

                            <div class="col-md-2">
                                <label><b>Employee Size:</b></label>
                                <input type="text" class="form-control" name="employee" value="">
                                <br><br>
                            </div>



                            <div class="col-md-3">
                                <label><b>Contact Person:</b></label>
                                <input type="text" class="form-control" name="personName" value="">
                            </div>

                            <div class="col-md-3">
                                <label><b>Designation:</b></label>
                                <input type="text" class="form-control" name="designation" value="">
                            </div>

                            <div class="col-md-3">
                                <label><b>Email:</b></label>
                                <input type="email" class="form-control" name="email" value="">
                            </div>

                            <div class="col-md-3">
                                <label><b>LinkedIn Profile:</b></label>
                                <input type="text" class="form-control" name="linkedin" value="">
                                <br><br>
                            </div>



                            <div class="col-md-8">
                                <label><b>Comments:</b></label>
                                <textarea class="form-control" id="comments" name="comments"></textarea>
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
                    <div class="mineIdDate" id="mineIdDate" align="left"></div> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div></form>
	        </div>
        </div>



							  <!-- <div class="row">
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
									  <input type="text" class="form-control" name="personName" value="">
								  </div>
								  <div class="col-md-4">
									  <label>Number:</label>
									  <input type="text" class="form-control" name="number" value="">
								  </div>
								  <div class="col-md-4">
									  <label>Website:</label>
									  <input type="text" class="form-control" name="website" value="">
								  </div>


								  <div class="col-md-4">
									  <label>Designation:</label>
									  <input type="text" class="form-control" name="designation" value="">
								  </div>

								  <div class="col-md-4">
									  <label>Country:</label>
									  <select class="form-control"  name="country" id="country">
										  @foreach($country as $c)
											  <option value="{{$c->countryId}}">{{$c->countryName}}</option>
										  @endforeach
									  </select>
									  <br><br><br>
								  </div>
								  <div class="col-md-8">
									  <label><b>Comment:</b></label>
									  <textarea class="form-control" id="comments" name="comments"></textarea>
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
			  </div> -->

			</div>




		  <!-- Call Modal -->
		  <div class="modal" id="my_modal" style="">
			  <div class="modal-dialog" style="max-width: 60%;">
				  <style>
					  th.ui-datepicker-week-end,
					  td.ui-datepicker-week-end {
						  display: none;
					  }
				  </style>
				  <form class="modal-content" action="{{route('storeFollowupReport')}}" method="post">
					  <div class="modal-header">
						  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						  <h4 class="modal-title" name="modal-title">Calling Report</h4>
					  </div>
					  <div class="modal-body" style="padding: 20px;">
						  {{csrf_field()}}
						  <input type="hidden" name="leadId">
						  <input type="hidden" name="followId">

						  @if(isset($fromDate) && isset($toDate))
							  <input type="hidden" value="{{$fromDate}}" name="fromDate">
							  <input type="hidden" value="{{$toDate}}" name="toDate">


						  @endif


						  <div class="row">
							  <div class="col-md-6">
								  <div class="form-group" style=" margin-bottom: 5px;">
									  <label ><b>Calling Report : </b></label>
									  <select class="form-control" name="report" id="reporttest" required>
										  {{--<option value="4"><b>Follow Up</b></option>--}}

										  {{--@foreach($callReports as $report)--}}
											  {{--@if($report->callingReportId == '4')--}}
											  {{--<option value="{{$report->callingReportId}}" selected>{{$report->report}}</option>--}}
											  {{--@else--}}
												  {{--<option value="{{$report->callingReportId}}" >{{$report->report}}</option>--}}
											  {{--@endif--}}
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

								  <div class="row">
									  <div class="form-group col-md-6">
										  <label class=""><b>Follow Up Date : </b></label>
										  <input class="form-control changedate" id="datepicker"  rows="3" name="followup" placeholder="pick Date">
									  </div>

									  <div class="form-group col-md-6">
										  <label class=""><b>Time: </b> </label>
										  <input class="form-control" name="time" placeholder="pick Time">
									  </div>
									  <div class="col-md-12" style="text-align: center; font-weight: bold;">
										  <span id="exceed" style="color:indigo;display: none"><i></i></span>
										  <span id="total" style="color: #00aa88; display: none"></span>
										  <span id="enoughfortoday" style="color:red;display: none"><i></i></span>
									  </div>
								  </div>


								  <div class="col-md-12" style="text-align: center; font-weight: bold;">
									  <span id="follow-show" style="color:grey;"><i></i></span>
								  </div>


								  <div class="form-group" style=" margin-bottom: 5px;">
									  <label class=""><b>Possibility : </b></label>
									  <select class="form-control"  name="possibility" id="possibility">
										  <option value=""><b>(select one)</b></option>
									  @foreach($possibilities as $p)
											  <option value="{{$p->possibilityId}}">{{$p->possibilityName}}</option>
										  @endforeach

									  </select>
								  </div>

								  <div class="form-group" style="margin-bottom: 5px">
									  <label ><b>Probability:</b></label>
									  <select class="form-control" id="probability" name="probability">
										  <option value=""><b>(select one)</b></option>
									  @foreach($probabilities as $probability)
											  <option value="{{$probability->probabilityId}}">{{$probability->probabilityName}}</option>
										  @endforeach
									  </select>
								  </div>

								  <div class="form-group" style=" margin-bottom: 5px;">
									  <label class=""><b>Comment* </b></label>
									  <textarea class="form-control" rows="3" name="comment" required></textarea>
								  </div>
							  </div>
							  
							  <div class="col-md-6">
								  <ul class="list-group" style="margin: 10px; ">
								  <h4 class="modal-title" name="modal-title">Previous Comments</h4>
									  <div  style="height: 500px; width: 100%; overflow-y: scroll; border: solid black 1px;" id="comment">

									  </div>
								  </ul>

							  </div>

							  <!-- <div class="col-md-3">
								  <ul class="list-group" style="margin: 10px; ">
										<b>Previous Follow up dates</b>
										<div style="height: 380px; width: 100%; overflow-y: scroll; border: solid black 1px;" id="previousfollowupdates">

										</div>
									</ul>
									<ul class="list-group" style="margin: 20px; ">
										<b>Call Statistics per marketer</b>
										<p>Here you will see who reached out to this company for how many times.</p>
										<div style="height: 100px; width: 100%; overflow-y: scroll; border: solid black 1px;" id="counter">

										</div>
									</ul>

							  </div> -->

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



		<!-- Statistics Modal -->
		  <div class="modal" id="stat_modal" style="">
			  <div class="modal-dialog" style="max-width: 50%;">

			  <form class="modal-content">			  
					  <div class="modal-body" style="padding: 20px;">
						  {{csrf_field()}}
						  <input type="hidden" name="leadId">
						  <input type="hidden" name="followId">

						  <div class="row">
							  <div class="col-md-6">
								  <ul class="list-group" >
										<h3>Previous Follow up dates</h3><br>
										<div style="height: 500px; width: 100%; overflow-y: scroll; border: solid black 1px;" id="previousfollowupdates">

										</div>
									</ul>

							  </div>

							<div class="col-md-6">

							  	<ul class="list-group" >
										<h3>Call Statistics per marketer</h3><br>
										<!-- <p>Here you will see who reached out to this company for how many times.</p> -->
										<div style="height: 500px; width: 100%; overflow-y: scroll; border: solid black 1px;" id="counter">

										</div>
								</ul>
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

		//search with date



		function search() {
		    var fromdate=document.getElementById('fromdate').value;
		    var todate=document.getElementById('todate').value;

		    if(fromdate !='' || todate !=''){

                window.location.href = '/follow-up/search/'+fromdate+'/'+todate;
			}


        }



        //for Edit modal

        $('#edit_modal').on('show.bs.modal', function(e) {

           //get data-id attribute of the clicked element
            var leadId = $(e.relatedTarget).data('lead-id');
            var leadName = $(e.relatedTarget).data('lead-name');
            var email = $(e.relatedTarget).data('lead-email');
            var number = $(e.relatedTarget).data('lead-number');
            var personName = $(e.relatedTarget).data('lead-person');
            var website = $(e.relatedTarget).data('lead-website');
            var linkedin=$(e.relatedTarget).data('lead-linkedin');
            var minedBy=$(e.relatedTarget).data('lead-mined');
            var category=$(e.relatedTarget).data('lead-category');
            var country=$(e.relatedTarget).data('lead-country');
            var designation=$(e.relatedTarget).data('lead-designation');
            var founded=$(e.relatedTarget).data('lead-founded');
            var employee=$(e.relatedTarget).data('lead-employee');
            var volume=$(e.relatedTarget).data('lead-volume');
            var frequency=$(e.relatedTarget).data('lead-frequency');
            var process=$(e.relatedTarget).data('lead-process');
            var comments=$(e.relatedTarget).data('lead-comments');
            var createdAt=$(e.relatedTarget).data('lead-created');


            //populate the textbox
            $('#category').val(category);
            $('#country').val(country);
            // $('div.mined').text(minedBy);
            $('div.mineIdDate').text(leadId+' was mined by '+minedBy+' at '+createdAt);

            $(e.currentTarget).find('input[name="leadId"]').val(leadId);
            $(e.currentTarget).find('input[name="companyName"]').val(leadName);
            $(e.currentTarget).find('input[name="email"]').val(email);
            $(e.currentTarget).find('input[name="number"]').val(number);
            $(e.currentTarget).find('input[name="personName"]').val(personName);
            $(e.currentTarget).find('input[name="website"]').val(website);
            $(e.currentTarget).find('input[name="linkedin"]').val(linkedin);
            $(e.currentTarget).find('input[name="designation"]').val(designation);
            $(e.currentTarget).find('input[name="founded"]').val(founded);
            $(e.currentTarget).find('input[name="employee"]').val(employee);
            $(e.currentTarget).find('input[name="volume"]').val(volume);
            $(e.currentTarget).find('input[name="frequency"]').val(frequency);
            $(e.currentTarget).find('input[name="process"]').val(process);
            $('#comments').val(comments);

//            $(e.currentTarget).find('#leave').attr('href', '/lead/leave/'+leadId);

        });

        $( function() {
            $( "#datepicker" ).datepicker();
        } );

        $( function() {
            $( "#fromdate" ).datepicker();
            $( "#todate" ).datepicker();
        } );


		// check followup limit

       /* $('.changedate').on('change',function(){
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
*/


		// $('.changedate').on('change',function(){
		// 	var currentdate = $('.changedate').val();
		// 	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
		// 	$.ajax({
		// 		type:'post',
		// 		url:'{{route('followupCheck')}}',
		// 		data:{_token: CSRF_TOKEN,'currentdate':currentdate},
		// 		success : function(data)
		// 		{
		// 			if(data >= 10)
		// 			{
		// 				document.getElementById('total').innerHTML='ON '+ currentdate +  ' Already Have '+ data +' followup';
		// 				document.getElementById('exceed').style.display="inline";
		// 			}
		// 			else
		// 			{
		// 				document.getElementById('exceed').style.display="none";
		// 				document.getElementById('total').style.display="inline";
		// 				document.getElementById('total').innerHTML='On this date you already have '+ data +' followups';
		// 			}
		// 		}
		// 	});
		// });




			$('.changedate').on('change', function() {
				var currentdate = $('.changedate').val();
				var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
				
				$.ajax({
					type: 'post',
					url: '{{route('followupCheck')}}',
					data: {
						_token: CSRF_TOKEN,
						'currentdate': currentdate
					},
					success: function(data) {
						if (data > 15) {
							$('#exceed').hide();
							$('#total').hide();
							$('#enoughfortoday').text('Sorry, Followups Overloaded on ' + currentdate).show();
							$('.changedate').datepicker('setDate', null); // Clear the selected date
						} else if (data > 10 && data < 15) {
							$('#total').hide();
							$('#enoughfortoday').hide();
							$('#exceed').text('Warning: on ' + currentdate + ' you already have ' + data + ' followup').show();
						} else {
							$('#enoughfortoday').hide();
							$('#exceed').hide();
							$('#total').text('On this date you have ' + data + ' followups').show();
						}
					}
				});
			});




        //for Call Modal

        $('#my_modal').on('show.bs.modal', function(e) {

            //get data-id attribute of the clicked element
            var leadId = $(e.relatedTarget).data('lead-id');
            var possibility=$(e.relatedTarget).data('lead-possibility');
            var probability=$(e.relatedTarget).data('lead-probability');
            var followup=$(e.relatedTarget).data('follow-id');


            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $(e.currentTarget).find('input[name="leadId"]').val(leadId);
            $(e.currentTarget).find('input[name="followId"]').val(followup);

            $('#possibility').val(possibility);
            $('#probability').val(probability);
            //$(e.currentTarget).find('input[name="possibility"]').val(possibility);

            // $.ajax({
            //     type : 'post' ,
            //     url : '{{route('getComments')}}',
            //     data : {_token: CSRF_TOKEN,'leadId':leadId} ,
            //     success : function(data){
            //         $('#comment').html(data);
            //         $("#comment").scrollTop($("#comment")[0].scrollHeight);
            //     }
            // });

            $.ajax({
                type: 'post',
                url: '{{ route('getComments') }}',
                data: {_token: CSRF_TOKEN, 'leadId': leadId},
                success: function(data) {
                    $('#comment').html(data.comments);
                    $("#comment").scrollTop($("#comment")[0].scrollHeight);

                    // var counterHtml = '';

                    // // Loop through the counter data
                    // $.each(data.counter, function(index, counter) {
                    //     counterHtml += '<div><strong>' + counter.userId + '</strong> tried <strong>' + counter.userCounter + '</strong> times</div>';
                    // });

                    // // Set the counter HTML to the counter div
                    // $('#counter').html(counterHtml);

                    // // Set the Previous Followup  HTML to the previousfollowupdates div
					// $('#previousfollowupdates').html(data.previousFollowups);
                    // $("#previousfollowupdates").scrollTop($("#previousfollowupdates")[0].scrollHeight);


                }
            });


            $.ajax({
                type : 'post' ,
                url : '{{route('editcontactmodalshow')}}',
                data : {_token:CSRF_TOKEN,'leadId':leadId} ,
                success : function(data){
                    // $('#txtHint').html(data);
                    console.log(data);
//                    $('#follow-show').val(data.followUpDate);
                    if(data !=''){
                        $('#follow-show').html('Current follow-up on '+data.followUpDate);}

                }
            });
            $.ajax({
                type : 'post' ,
                url : '{{route('getCallingReport')}}',
                data : {_token: CSRF_TOKEN,'leadId':leadId} ,
                success : function(data){

                    document.getElementById("reporttest").innerHTML = data;

                }
            });


        });


        $(document).ready(function() {
            $('#myTable').DataTable({
                "bSort": false
			});

        });



        $('#stat_modal').on('show.bs.modal', function(e) {

            //get data-id attribute of the clicked element
            var leadId = $(e.relatedTarget).data('lead-id');
            var followup=$(e.relatedTarget).data('follow-id');

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'post',
                url: '{{ route('getFollowupsCounter') }}',
                data: {_token: CSRF_TOKEN, 'leadId': leadId},
                success: function(data) {
                    // Set the Previous Followup  HTML to the previousfollowupdates div
					$('#previousfollowupdates').html(data.previousFollowups);
                    $("#previousfollowupdates").scrollTop($("#previousfollowupdates")[0].scrollHeight);

                    var counterHtml = '';

                    // Loop through the counter data
					$.each(data.counter, function(index, counter) {
					counterHtml += '<li style="list-style-type: disc; margin-left: 20px;"><strong>' + counter.userId + '</strong> tried <strong>' + counter.userCounter + '</strong> times</li>';
					});

                    // Set the counter HTML to the counter div
                    $('#counter').html(counterHtml);

                }
            });
        });



	</script>

@endsection






































