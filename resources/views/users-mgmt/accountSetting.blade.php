@extends('main')
<style>

.bg-light-red {
        background-color: #fa9775; 
    }

table {
  border-collapse: collapse; 
}

tr, td, th {
  text-align: center;
  vertical-align: middle;
}

</style>


@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->
    
    @php($user_Type = Session::get('userType'))


    <div class="content-page" >
        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row" >
                    <div class="col-12">
                        <div class="page-title-box">
                            <!-- <h4 class="page-title">User details</h4> -->
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <!-- table start -->
                <div class="row" style="margin-top: 20px;">
                    <!-- user details -->
                    <div class="col-sm-4 col-xl-3">
                        <div class="card">
                            <div class="card-body">


                                <p class="text-center">
                                    @if (!empty($user->picture))
                                        <img src="{{ asset('public/img/users/' . $user->picture) }}" alt="User Picture" class="img-fluid" style="margin-top: 10px;">
                                    @else
                                        <img src="{{ asset('public/img/users/' . 'default.jpg') }}" alt="User Picture" class="img-fluid" style="margin-top: 10px;">
                                    @endif
                                </p>
                                <p class=""><span style="font-weight:400">Status:</span> 
                                  @if ($user->active == 1) <span style="color: green;">Active</span> @else <span style="color: red;">Active</span>Inactive @endif</p>
                                <p class="mb-1"><span style="font-weight:400">Username: </span>
                                    {{$user->userId}}</p>
                                <p class="mb-1"><span style="font-weight:400">Full Name: </span>
                                    {{$user->firstName}} {{$user->lastName}}</p>
                                <!-- <p class="mb-1">Last Name: </p> -->
                                <p class="mb-1"><span style="font-weight:400">Designation: </span>
                                    @if ($user->designation) {{$user->designation->designationName}} @endif</p>
                                <p class="mb-1"><span style="font-weight:400">Phone: </span>
                                    {{$user->phoneNumber}}</p>
                                <p class="mb-1"><span style="font-weight:400">Gender: </span>
                                    @if ($user->gender == "M") Male @else Female @endif</p>
                                <p class="mb-1"><span style="font-weight:400">DOB: </span>
                                    {{ Carbon\Carbon::parse($user->dob)->format('F d, Y') }}</p>
                                <p class="mb-1"><span style="font-weight:400">Email: </span>
                                    {{$user->userEmail}}</p><br>

                                <a href="#edit_user_modal" data-toggle="modal" class="btn btn-custom"
                                data-id="{{$user->id}}"
                                       data-user-id="{{$user->userId}}"
                                       data-type-id="{{$user->typeId}}"
                                       data-rf-id="{{$user->rfID}}"
                                       data-user-email="{{$user->userEmail}}"
                                       data-password="{{$user->password}}"
                                       data-first-name="{{$user->firstName}}"
                                       data-last-name="{{$user->lastName}}"
                                       data-designation-id="{{$user->designationId}}"
                                       data-phone-number="{{$user->phoneNumber}}"
                                       data-dob="{{$user->dob}}"
                                       data-gender="{{$user->gender}}"
                                       data-active="{{$user->active}}"
                                       data-whitelist="{{$user->whitelist}}">
                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>  Update Profile</a>


                            </div>
                        </div>
                    </div>

                    <!-- user report and others -->
                    <div class="col-sm-8 col-xl-9">
                        <div class="card">
                            <div class="card-body">
                                    <br><hr>
                                        <div class="row">
                                            <div class="col-12">
                                                <h4 class="header-title mb-3">{{ $showCurrentMonth }} </h4>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead class="table-primary">
                                                        <tr>
                                                            <th></th>
                                                            <th width="12%">Conversation</th>
                                                            <th width="12%">Total Call</th>
                                                            <th width="12%">Followup</th>
                                                            <th width="12%">Test</th>
                                                            <th width="12%">Closed Deal</th>
                                                            <th width="12%">Lead Mine</th>
                                                            <th width="12%">Revenue</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody>
                                                        <tr>
                                                            <th>Target</th>
                                                        @foreach ($userTargets as $userTarget)
                                                            <td>{{$userTarget->conversation}}</td>
                                                            <td>{{$userTarget->targetCall}}</td>
                                                            <td>{{$userTarget->followup}}</td>
                                                            <td>{{$userTarget->targetTest}}</td>
                                                            <td>{{$userTarget->closelead}}</td>
                                                            <td>{{$userTarget->targetLeadmine}}</td>
                                                            <td>{{$userTarget->targetFile}}</td>
                                                        @endforeach
                                                        </tr>
                                                        <tr>
                                                            <th>Achievement</th>
                                                            <td>{{$totalConversationCalls}}</td>
                                                            <td>{{$totalProgressIds}}</td>
                                                            <td>{{$totalFollowUp}}</td>
                                                            <td>{{$totalTestProgress}}</td>
                                                            <td>{{$totalClosingProgress}}</td>
                                                            <td>{{$totalLeadMining}}</td>
                                                            <td>{{$totalRevenue}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>%</th>
                                                            @foreach ($userTargets as $userTarget)
                                                                <td class="percentage-cell">{{ number_format($totalConversationCalls ? ($totalConversationCalls / $userTarget->conversation * 100) : 0, 1) }}%</td>
                                                                <td class="percentage-cell">{{ number_format($totalProgressIds ? ($totalProgressIds / $userTarget->targetCall * 100) : 0, 1) }}%</td>
                                                                <td class="percentage-cell">{{ number_format($totalFollowUp ? ($totalFollowUp / $userTarget->followup * 100) : 0, 1) }}%</td>
                                                                <td class="percentage-cell">{{ number_format($totalTestProgress ? ($totalTestProgress / $userTarget->targetTest * 100) : 0, 1) }}%</td>
                                                                <td class="percentage-cell">{{ number_format($totalClosingProgress ? ($totalClosingProgress / $userTarget->closelead* 100) : 0, 1) }}%</td>
                                                                <td class="percentage-cell">{{ number_format($totalLeadMining ? ($totalLeadMining / $userTarget->targetLeadmine* 100) : 0, 1) }}%</td>
                                                                <td class="percentage-cell">{{ number_format($totalRevenue ? ($totalRevenue / $userTarget->targetFile * 100) : 0, 1) }}%</td>

                                                            @endforeach                                                        
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>


                                            <div class="col-12">
                                            <br><hr>
                                                <h4 class="header-title mb-3">{{ $showPreviousMonth }} </h4>
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead class="table-primary">
                                                        <tr>
                                                            <th></th>
                                                            <th width="12%">Conversation</th>
                                                            <th width="12%">Total Call</th>
                                                            <th width="12%">Followup</th>
                                                            <th width="12%">Test</th>
                                                            <th width="12%">Closed Deal</th>
                                                            <th width="12%">Lead Mine</th>
                                                            <th width="12%">Revenue</th>
                                                        </tr>
                                                        </thead>

                                                        <tbody>
                                                        <tr>
                                                            <th>Target</th>
                                                        @foreach ($userTargetPreviousMonth as $userTargetPM)
                                                            <td>{{$userTargetPM->conversation}}</td>
                                                            <td>{{$userTargetPM->targetCall}}</td>
                                                            <td>{{$userTargetPM->followup}}</td>
                                                            <td>{{$userTargetPM->targetTest}}</td>
                                                            <td>{{$userTargetPM->closelead}}</td>
                                                            <td>{{$userTargetPM->targetLeadmine}}</td>
                                                            <td>{{$userTargetPM->targetFile}}</td>
                                                        @endforeach
                                                        </tr>
                                                        <tr>
                                                            <th>Achievement</th>
                                                            <td>{{$totalConvoPreviousMonth}}</td>
                                                            <td>{{$totalCallPreviousMonth}}</td>
                                                            <td>{{$totalFollowUpPreviousMonth}}</td>
                                                            <td>{{$totalTestPreviousMonth}}</td>
                                                            <td>{{$totalClosingPreviousMonth}}</td>
                                                            <td>{{$totalLeadMiningPreviousMonth}}</td>
                                                            <td>{{$totalRevenuePreviousMonth}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>%</th>
                                                            @foreach ($userTargetPreviousMonth as $userTargetPM)
                                                                <td class="percentage-cell">{{ number_format($totalConvoPreviousMonth ? ($totalConvoPreviousMonth / $userTargetPM->conversation * 100) : 0, 1) }}%</td>
                                                                <td class="percentage-cell">{{ number_format($totalCallPreviousMonth ? ($totalCallPreviousMonth / $userTargetPM->targetCall * 100) : 0, 1) }}%</td>
                                                                <td class="percentage-cell">{{ number_format($totalFollowUpPreviousMonth ? ($totalFollowUpPreviousMonth / $userTargetPM->followup * 100) : 0, 1) }}%</td>
                                                                <td class="percentage-cell">{{ number_format($totalTestPreviousMonth ? ($totalTestPreviousMonth / $userTargetPM->targetTest * 100) : 0, 1) }}%</td>
                                                                <td class="percentage-cell">{{ number_format($totalClosingPreviousMonth ? ($totalClosingPreviousMonth / $userTargetPM->closelead* 100) : 0, 1) }}%</td>
                                                                <td class="percentage-cell">{{ number_format($totalLeadMiningPreviousMonth ? ($totalLeadMiningPreviousMonth / $userTargetPM->targetLeadmine* 100) : 0, 1) }}%</td>
                                                                <td class="percentage-cell">{{ number_format($totalRevenuePreviousMonth ? ($totalRevenuePreviousMonth / $userTargetPM->targetFile * 100) : 0, 1) }}%</td>

                                                            @endforeach                                                        
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end table -->
            </div>
            <!-- container -->
        </div>
        <!-- content -->






        

            
            <!-- Edit Modal -->
            <div class="modal" id="edit_user_modal" >
                <div class="modal-dialog" style="max-width: 60%;">
                    <div class="modal-content">

                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h4 class="modal-title">Update User's Info</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Modal body -->
                        <div class="modal-body">

                            <form class="form-horizontal" role="form" method="POST" action="{{ route('user-management.update', ['id' => 1]) }}" enctype="multipart/form-data">
                                <input type="hidden" name="_method" value="PUT">
                                {{ csrf_field() }}
                                <input id="id" type="hidden" class="form-control" name="id"  >
                                <input id="typeId" type="hidden" class="form-control" name="typeId"  >
                                <input id="userId" type="hidden" class="form-control" name="userId"  >
                                <input id="rfID" type="hidden" class="form-control" name="rfID"  >
                                <input id="active" type="hidden" class="form-control" name="active"  >
                                <input id="whitelist" type="hidden" class="form-control" name="whitelist"  >

                                <div class="row">

                                    <div class="form-group col-md-4">
                                        <label for="firstName">First Name:</label>

                                        <input id="firstName" type="text" class="form-control" name="firstName" required>

                                        @if ($errors->has('firstName'))
                                            <span class="help-block">
												<strong>{{ $errors->first('firstName') }}</strong>
											</span>
                                        @endif
                                    </div>


                                    <div class="form-group col-md-4">
                                        <label for="lastName">Last Name:</label>
                                        <input id="lastName" type="text" class="form-control" name="lastName" required>

                                        @if ($errors->has('lastName'))
                                            <span class="help-block">
											<strong>{{ $errors->first('lastName') }}</strong>
										</span>
                                        @endif
                                    </div>



                                    <div class="form-group col-md-4">
                                        <label for="designationId">Designation:</label>
                                        <select id="designationId" name="designationId" class="form-control form-control-warning">
                                            <option value="">Select Designation</option>
                                            <option value="105" {{ old('designationId') == 105 ? 'selected' : '' }}>Managing Director</option>
                                            <option value="142" {{ old('designationId') == 142 ? 'selected' : '' }}>Senior Manager</option>
                                            <option value="98" {{ old('designationId') == 98 ? 'selected' : '' }}>HR Manager</option>
                                            <option value="104" {{ old('designationId') == 105 ? 'selected' : '' }}>Manager</option>
                                            <option value="18" {{ old('designationId') == 142 ? 'selected' : '' }}>Deputy Manager</option>
                                            <option value="2" {{ old('designationId') == 98 ? 'selected' : '' }}>Assistant Manager</option>
                                            <option value="141" {{ old('designationId') == 105 ? 'selected' : '' }}>Senior Executive</option>
                                            <option value="43" {{ old('designationId') == 142 ? 'selected' : '' }}>Executive</option>
                                            <option value="103" {{ old('designationId') == 98 ? 'selected' : '' }}>Junior Executive</option>
                                            <option value="153" {{ old('designationId') == 105 ? 'selected' : '' }}>Trainee Executive</option>
                                            <option value="100" {{ old('designationId') == 142 ? 'selected' : '' }}>Intern</option>
                                        </select>
                                        @if ($errors->has('designationId'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('designationId') }}</strong>
                                            </span>
                                        @endif
                                    </div>



                                    <div class="form-group col-md-4">
                                        <label for="userEmail">Email:</label>
                                        <input id="userEmail" type="email" class="form-control" name="userEmail" required>

                                        @if ($errors->has('userEmail'))
                                            <span class="help-block">
											<strong>{{ $errors->first('userEmail') }}</strong>
										</span>
                                        @endif
                                    </div>


                                    <div class="form-group col-md-4">
                                        <label for="phoneNumber">Phone Number:</label>
                                        <input id="phoneNumber" type="text" class="form-control" name="phoneNumber">
                                        @if ($errors->has('phoneNumber'))
                                            <span class="help-block">
											<strong>{{ $errors->first('phoneNumber') }}</strong>
										</span>
                                        @endif
                                    </div>


                                    <div class="form-group col-md-4">
                                        <label for="dob">Date Of Birth:</label>
                                        <input id="dob" type="text" class="form-control" name="dob">
                                        @if ($errors->has('dob'))
                                            <span class="help-block">
											<strong>{{ $errors->first('dob') }}</strong>
										</span>
                                        @endif
                                    </div>


                                    <div class="form-group col-md-4">
                                        <label for="gender">Gender:</label>
                                        <select id="gender" name="gender" class="form-control form-control-warning">

                                            <option value="M">Male</option>
                                            <option value="F">Female</option>

                                        </select>
                                        @if ($errors->has('gender'))
                                            <span class="help-block">
											<strong>{{ $errors->first('gender') }}</strong>
										</span>
                                        @endif

                                    </div>

                                    <div class="form-group col-md-8">
                                        <label for="picture">Picture:</label>
                                        <input id="picture" type="file" class="form-control" name="picture">
                                        @if ($errors->has('picture'))
                                            <span class="help-block">
											<strong>{{ $errors->first('picture') }}</strong>
										</span>
                                        @endif

                                    </div>



                                    <div class="form-group col-md-6">
                                        <label for="password">Password (min 6 characters):</label>
                                        <input id="password" type="password" class="form-control" name="password">
                                        @if ($errors->has('password'))
                                            <span class="help-block">
											<strong>{{ $errors->first('password') }}</strong>
										</span>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="password-confirm">Repeat Password:</label>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                                    </div>



                                    <div class="form-group col-md-4">
                                        <button type="submit" class="btn btn-success">
                                            Update
                                        </button>
                                    </div>
                                </div>

                            </form>

                        </div>

                    </div>
                </div>
            </div>








@endsection


@section('foot-js')
    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>

    <script>

        

        $(function() {
            $('#dob').datepicker({
                dateFormat: 'yy-mm-dd', // Format the date as 'yyyy-mm-dd'
                changeMonth: true,
                changeYear: true,
                yearRange: "-60:+0" 
            });
        });


        //for Edit modal

        $('#edit_user_modal').on('show.bs.modal', function(e) {

            //get data-id attribute of the clicked element
            var id = $(e.relatedTarget).data('id');
            var userId = $(e.relatedTarget).data('user-id');
            var typeId = $(e.relatedTarget).data('type-id');
            var rfID = $(e.relatedTarget).data('rf-id');
            var userEmail = $(e.relatedTarget).data('user-email');
            //var password = $(e.relatedTarget).data('password');
            var firstName = $(e.relatedTarget).data('first-name');
            var lastName = $(e.relatedTarget).data('last-name');
            var phoneNumber = $(e.relatedTarget).data('phone-number');
            var dob = $(e.relatedTarget).data('dob');
            var gender = $(e.relatedTarget).data('gender');
            var active = $(e.relatedTarget).data('active');
            var whitelist = $(e.relatedTarget).data('whitelist');
            var designationId = $(e.relatedTarget).data('designation-id');

            //alert(userId);
            //populate the textbox
            $(e.currentTarget).find('#id').val(id);
            $(e.currentTarget).find('#userId').val(userId);
            $(e.currentTarget).find('#typeId').val(typeId);
            $(e.currentTarget).find('#rfID').val(rfID);
            $(e.currentTarget).find('#userEmail').val(userEmail);
            //$(e.currentTarget).find('#password').val(password);
            $(e.currentTarget).find('#firstName').val(firstName);
            $(e.currentTarget).find('#lastName').val(lastName);
            $(e.currentTarget).find('#phoneNumber').val(phoneNumber);
            $(e.currentTarget).find('#dob').val(dob);
            $(e.currentTarget).find('#gender').val(gender);
            $(e.currentTarget).find('#active').val(active);
            $(e.currentTarget).find('#whitelist').val(whitelist);
            $(e.currentTarget).find('#designationId').val(designationId);

        });

    
    document.addEventListener('DOMContentLoaded', function() {
        // Get all elements with the class "percentage-cell"
        const percentageCells = document.querySelectorAll('.percentage-cell');

        // Loop through each cell and apply background color based on condition
        percentageCells.forEach(cell => {
            const percentage = parseFloat(cell.innerText);
            if (percentage < 50) {
                cell.classList.add('bg-light-red'); // Add the class for red background
            }
        });
    });


</script>


@endsection
