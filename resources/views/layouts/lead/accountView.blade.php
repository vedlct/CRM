@extends('main')
<style>
    .kdm {
    background-color: lightblue;
    color: black !important;
    padding: 10px;
    }

</style>

@section('content')
    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->


    
    <div class="content-page">
        <div class="content">
            <!-- Start Content-->
            <div class="container-fluid">
                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box" style="padding: 20px 0;">
                            <h2 class="page-title" style="text-align: center;">{{$lead->companyName}}</h2>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <!-- content start -->
                <div class="row">
                    <!-- profile card -->
                    <div class="col-md-6 col-lg-4 col-xxl-3 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="border-bottom pb-2">Compnay Information</h5>
                                <p>
                                    <b class="text-secondary">Company Name:</b>
                                    {{$lead->companyName}}
                                </p>
                                <p>
                                    <b class="text-secondary">Lead Id:</b>
                                    {{$lead->leadId}}
                                </p>
                                <p>
                                    <b class="text-secondary">Staus:</b>
                                    {{$lead->status->statusName}}
                                </p>
                                <p>
                                    <b class="text-secondary">Strength (Possibility):</b>
                                    @if ($lead)
                                        @php
                                            $leadPossibility = $possibilities->firstWhere('possibilityId', $lead->possibilityId);
                                            $possibilityName  = $leadPossibility ? $leadPossibility->possibilityName  : 'Unknown Possibility';
                                        @endphp

                                            {{ $possibilityName  }}
                                    @else
                                            Possibility not found.
                                    @endif
                                </p>

                                <p>
                                    <b class="text-secondary">Pipeline:</b>
                                    @if ($pipeline->isEmpty())
                                        Not in Sales Pipeline
                                    @else
                                        @foreach ($pipeline as $item)
                                            {{$item->stage}}
                                        @endforeach
                                    @endif
                               </p>

                                <div class="mb-3">
                                    <a 
                                        href="#call_modal" 
                                        class="btn btn-info" 
                                        data-toggle="modal" 
                                        data-lead-id="{{$lead->leadId}}" 
                                        data-lead-name="{{$lead->companyName}}"
                                        data-lead-possibility="{{$lead->possibilityId}}" 
                                        data-lead-probability="{{$lead->probabilityId}}"
                                    >Calling</a>

                                    <a 
                                        href="#lead_activities" 
                                        class="btn btn-primary" 
                                        data-toggle="modal" 
                                        data-lead-id="{{$lead->leadId}}" 
                                        data-lead-name="{{$lead->companyName}}"
                                    >Activities</a>
                                    
                                    <a href="#edit_modal" class="btn btn-secondary" data-toggle="modal" 
                                        data-lead-id="{{$lead->leadId}}" 
                                        data-lead-name="{{$lead->companyName}}"
                                        data-lead-email="{{$lead->email}}"
                                        data-lead-number="{{$lead->contactNumber}}"
                                        data-lead-person="{{$lead->personName}}"
                                        data-lead-website="{{$lead->website}}"
                                        data-lead-category="{{$lead->category->categoryId}}"
                                        data-lead-country="{{$lead->countryId}}"
                                        data-lead-designation="{{$lead->designation}}"
                                        data-lead-linkedin="{{$lead->linkedin}}"
                                        data-lead-founded="{{$lead->founded}}"
                                        data-lead-process="{{$lead->process}}"
                                        data-lead-volume="{{$lead->volume}}"
                                        data-lead-frequency="{{$lead->frequency}}"
                                        data-lead-employee="{{$lead->employee}}"
                                        data-lead-ipp="{{$lead->ippStatus}}"
                                        data-lead-comments="{{$lead->comments}}"
                                        data-lead-possibility="{{$lead->possibilityId}}" 
                                        data-lead-probability="{{$lead->probabilityId}}"
                                    >Edit</a>

                                    @if ($pipeline->isEmpty() && $lead->contactedUserId == auth()->id())
                                    <a href="#" class="btn btn-outline-dark" 
                                        data-toggle="modal" 
                                        data-target="#set_pipeline"
                                        data-lead-id="{{ $lead->leadId }}"
                                        data-lead-name="{{ $lead->companyName }}" 
                                        data-pipeline-stage="{{ $lead->stage }}"                                                                                
                                        >Set Pipeline</a>
                                    @endif  

                                </div>

                                <h4 class="text-decoration-underline font-info pb-2">Profile:</h4>

                                <p>
                                    <b class="text-secondary">Location:</b>
                                    {{$lead->country->countryName}}
                                </p>
                                <p>
                                    <b class="text-secondary">HQ Phone:</b>
                                    {{$lead->contactNumber}}
                                </p>
                                <!-- <p>
                                    <b class="text-secondary">Other Phone:</b>
                                    +880185574457
                                </p> -->
                                <p>
                                    <b class="text-secondary">KDM Name(s):</b>
                                    {{$lead->personName}}
                                </p>
                                <p>
                                    <b class="text-secondary">Email:</b>
                                    {{$lead->email}}
                                </p>
                                <p>
                                    <b class="text-secondary">Category:</b>
                                    @if ($lead)
                                        @php
                                            $leadCategory = $categories->firstWhere('categoryId', $lead->categoryId);
                                            $categoryName = $leadCategory ? $leadCategory->categoryName : 'Unknown Category';
                                        @endphp

                                            {{ $categoryName }}
                                    @else
                                            Category not found.
                                    @endif
                                </p>
                                <!-- <p>
                                    <b class="text-secondary">Sub Category:</b>
                                    Software Development
                                </p> -->
                                <!-- <p>
                                    <b class="text-secondary">No. of Images Online:</b>
                                    322
                                </p> -->
                                <h4 class="text-decoration-underline font-info pb-2">Links:</h4>
                                <p>
                                    <b>Web:</b>
                                    <a href="{{$lead->website}}" target="_blank"> {{$lead->website}}</a>
                                </p>
                                <!-- <p>
                                    <b>FB:</b>
                                    <a href="#">facebook.com</a>
                                </p> -->
                                <p>
                                    <b>Linkedin:</b>
                                    <a href="{{$lead->linkedin}}" target="_blank"> {{$lead->linkedin}}</a>
                                </p>
                                <p>
                                    <b class="text-secondary">Extra Information:</b>
                                    {{$lead->comments}}
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- tab card -->
                    <div class="col-md-6 col-lg-4 col-xxl-6 mb-3">
                        <div class="card">
                            <div class="card-body">

                                <!-- <ul class="nav nav-tabs border-tab mb-0" id="top-tab" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#comments" role="tab" aria-selected="false">Call Reports</a>
                                        <div class="material-border"></div>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#followups" role="tab" aria-selected="false">Followups</a>
                                        <div class="material-border"></div>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#contacts" role="tab" aria-selected="true">Contacts</a>
                                        <div class="material-border"></div>
                                    </li>
                                </ul> -->

                                <ul class="nav nav-tabs border-tab mb-0" id="top-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#comments" role="tab" aria-selected="false" id="comments-tab">Call Reports</a>
                                        <div class="material-border"></div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#followups" role="tab" aria-selected="false" id="followups-tab">Followups</a>
                                        <div class="material-border"></div>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-bs-toggle="tab" href="#contacts" role="tab" aria-selected="true" id="contacts-tab">Contacts</a>
                                        <div class="material-border"></div>
                                    </li>
                                </ul>         

                                <div class="tab-content" id="top-tabContent">
                                    <div class="tab-pane fade active show" id="comments" role="tabpanel">

                                        <!-- comments -->
                                        @foreach ($allComments as $comment)
                                        <hr>
                                        <div class="alert alert-primary p-4">
                                            <p class="text-dark mb-2">{{$comment->comments}}</p>
                                            <div class="media mb-0">
                                                <div class="media-body">
                                                    <p class="mb-1"><span style="color: green;">- {{$comment->firstName}} {{$comment->lastName}}</span> at {{$comment->created_at}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>

                                    <!-- followup tab -->
                                    <div class="tab-pane fade" id="followups" role="tabpanel">
                                        <hr>
                                        <div class="alert alert-success p-4">
                                            @foreach ($latestFollowups as $followup)
                                                <b>Latest Followup Date: {{$followup->lastFollowUpDate}}</b>
                                            @endforeach

                                        </div>
                                        <hr>                                        
                                        
                                        <div class="alert alert-secondary p-4">
                                            <h4>Call Statistics:</h4><br>
                                            @foreach ($followupCounter as $counter)
                                                 {{$counter->userId}} - {{$counter->userCounter}}</b><br>
                                            @endforeach

                                        </div>                                        
                                        <hr>
                                        <h3>Previous Followup Dates:</h3>

                                        @foreach ($previousFollowups as $previousFollowup)
                                        <div class="alert alert-info p-4">
                                            <p class="text-dark mb-2">Followup date: {{$previousFollowup->followUpDate}}</p>
                                                    <p>- set by {{$previousFollowup->firstName}} 
                                                        <span style="color: blue;"> 
                                                        @if ($previousFollowup->workStatus == 1)
                                                            Worked
                                                        @else
                                                            Not Worked
                                                        @endif</span></p>
                                        </div>
                                        @endforeach

                                    </div>


                                    <!-- contacts tab -->
                                    <div class="tab-pane fade" id="contacts" role="tabpanel">
                                        <p class="my-1"><br>

                                        <a href="#create_employee" class="btn btn-info" data-toggle="modal" 
                                            data-lead-id="{{$lead->leadId}}" 
                                            data-lead-name="{{$lead->companyName}}"
                                            data-lead-email="{{$lead->email}}"
                                            data-lead-number="{{$lead->contactNumber}}"
                                            data-lead-person="{{$lead->personName}}"
                                            data-lead-website="{{$lead->website}}"
                                            data-lead-category="{{$lead->category->categoryId}}"
                                            data-lead-country="{{$lead->countryId}}"
                                            data-lead-designation="{{$lead->designation}}"
                                            data-lead-linkedin="{{$lead->linkedin}}"
                                            data-lead-founded="{{$lead->founded}}"
                                            data-lead-process="{{$lead->process}}"
                                            data-lead-volume="{{$lead->volume}}"
                                            data-lead-frequency="{{$lead->frequency}}"
                                            data-lead-employee="{{$lead->employee}}"
                                            data-lead-ipp="{{$lead->ippStatus}}"
                                            data-lead-comments="{{$lead->comments}}"
                                            data-lead-possibility="{{$lead->possibilityId}}" 
                                            data-lead-probability="{{$lead->probabilityId}}"
                                        >Create Contact</a>


                                        </p>
                                        @foreach ($employees as $employee)
                                            <hr>
                                            @if ($employee->iskdm == 1)
                                            <div class="row kdm" >
                                            @else
                                            <div class="row">
                                            @endif
                                            <div class="col-md-6">
                                                    <p>
                                                        <b class="text-secondary">Is it KDM:</b>
                                                        @if ($employee->iskdm == 1) Yes @else No @endif
                                                    </p>
                                                    <p>
                                                        <b class="text-secondary">Name:</b>
                                                        {{$employee->name}}
                                                    </p>
                                                    <p>
                                                        <b class="text-secondary">Designation:</b>
                                                        {{$employee->designation->designationName}}
                                                    </p>
                                                    <p>
                                                        <b class="text-secondary">Phone:</b>
                                                        {{$employee->number}}
                                                    </p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>
                                                        <a href="#edit_employee">Edit Employee</a>
                                                    </p>
                                                    <p>
                                                        <b class="text-secondary">Status:</b>
                                                        @if ($employee->jobstatus ==1) Active @else Left Job @endif
                                                    </p>

                                                    <p>
                                                        <b class="text-secondary">Email:</b>
                                                        {{$employee->email}}
                                                    </p>

                                                    <p>
                                                        <b class="text-secondary">Country:</b>
                                                        {{$employee->country->countryName}}
                                                    </p>
                                            </div>
                                            <div class="col-md-12">
                                                    <p>
                                                        <b class="text-secondary">Linkedin:</b>
                                                        {{$employee->linkedin}}
                                                    </p>

                                            </div>

                                        </div>
                                        @endforeach
                                        <!-- <div class="row">
                                            <div class="col-md-6">
                                                <p>
                                                    <b class="text-secondary">Created by:</b>
                                                    6 July 2022 3:50 PM
                                                </p>
                                                <p>
                                                    <b class="text-secondary">Updated by:</b>
                                                    6 July 2022 3:50 PM
                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p>
                                                    <b class="text-secondary">Created at:</b>
                                                    6 July 2022 3:50 PM
                                                </p>
                                                <p>
                                                    <b class="text-secondary">Updated at:</b>
                                                    6 July 2022 3:50 PM
                                                </p>
                                            </div>
                                        </div> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- other info card -->
                    <div class="col-md-6 col-lg-4 col-xxl-3 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="border-bottom pb-2">Other Informations</h5>
                                <p>
                                    <b class="text-secondary">File Volume:</b>
                                    {{$lead->volume}}
                                </p>
                                <p>
                                    <b class="text-secondary">Frequency:</b>
                                    {{$lead->frequency}}
                                </p>
                                <p>
                                    <b class="text-secondary">Current Process:</b>
                                    {{$lead->process}}
                                </p>
                                <p>
                                    <b class="text-secondary">Employee Size:</b>
                                    {{$lead->employee}}
                                <p>
                                    <b class="text-secondary">Founded:</b>
                                    {{$lead->founded}}
                                </p>
                                <!-- <p>
                                    <b class="text-secondary">Season:</b>
                                    {{$lead->season}}
                                </p> -->
                                <p>
                                    <b class="text-secondary">IPP?:</b>
                                    @if ($lead->ippStatus == 1)
                                        Yes
                                    @else
                                        No
                                    @endif
                                </p>
                                <p>
                                    <b class="text-secondary">Closing Probability:</b>
                                    @if ($lead)
                                        @php
                                            $leadProbability = $probabilities->firstWhere('probabilityId', $lead->probabilityId);
                                            $probabilityName  = $leadProbability ? $leadProbability->probabilityName  : 'Unknown';
                                        @endphp

                                            {{ $probabilityName }}
                                    @else
                                            Probability not found.
                                    @endif

                                </p>
                                <p>
                                    <b class="text-secondary">Did a test?:</b>
                                    @if ($didTestWithUs->isNotEmpty())
                                        @foreach ($didTestWithUs as $workprogress)
                                            <span style="color:green; font-weight: 500;">Yes</span> on {{ $workprogress->created_at }}
                                        @endforeach
                                    @else
                                        Not Yet
                                    @endif
                                </p>
                                <p>
                                    <b class="text-secondary">Operated in:</b>
                                    <a href="#" role="button" data-bs-toggle="modal" data-bs-target="#operatedIn" class="text-decoration-underline">Country List</a>
                                </p>
                                <!-- modal -->
                                <!-- Modal -->
                                <div class="modal fade" id="operatedIn" tabindex="-1" aria-labelledby="operatedIn" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Operated in</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Demo Country
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-primary">Save changes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <p>
                                    <b class="text-secondary">Parent Company:</b>

                                </p>
                                <p>
                                    <b class="text-secondary">Sub Brands:</b>

                                </p>
                                <h4 class="text-decoration-underline font-info pb-2">Account Updates:</h4>
                                <p>
                                    <b class="text-secondary">Current Marekter:</b>
                                    @if ($users->isEmpty())
                                        No one is chasing this!
                                    @else
                                        @foreach ($users as $user)
                                            {{$user->firstName}} {{$user->lastName}}
                                        @endforeach
                                    @endif
                                </p>
                                <p>
                                    <b class="text-secondary">Mined by:</b>
                                    {{$lead->mined->firstName}} {{$lead->mined->lastName}}
                                </p>
                                <p>
                                    <b class="text-secondary">Created Date:</b>
                                    {{$lead->created_at}}
                                </p>
                                @if ($latestUpdate)
                                <p>
                                    <b class="text-secondary">Last Updated by:</b>
                                        {{$latestUpdate->firstName}} {{$latestUpdate->lastName}}
                                </p>
                                <p>
                                    <b class="text-secondary">Update Date:</b>
                                        {{$latestUpdate->activities_created_at}}
                                </p>
                                @else
                                        <i>No one has edited this account yet</i>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                <!-- content end -->

            </div>
            <!-- container -->
        </div>
        <!-- content -->
    </div>







   <!--ALL Activities-->
    
   <div class="modal" id="lead_activities" >
        <div class="modal-dialog" style="max-width: 30%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" name="modal-title">All Activities</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <b>Company Name:</b>
                            <input type="text" name="companyName" readonly>
                            <div class="form-group">
                                <ul class="list-group" style="margin: 10px; "><br>
                                    <div  style="height: 460px; width: 100%; overflow-y: scroll; border: solid black 1px;" id="activity">

                                    </div>
                                </ul>
                            </div>

                        </div>

                    </div>
                </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>



    <!-- Call Modal -->

    <div class="modal" id="call_modal">
        <div class="modal-dialog" style="max-width: 30%;">
            <style>
                th.ui-datepicker-week-end,
                td.ui-datepicker-week-end {
                    display: none;
                }
            </style>
            <form class="modal-content" action="{{route('storeReport')}}" method="post">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" name="modal-title">Calling Report</h4>
                </div>
                <div class="modal-body" >
                    {{csrf_field()}}
                    <input type="hidden" name="leadId">

                    <div class="row">

                            <div class="form-group col-md-6" >
                                <label ><b>Call Status : </b></label>
                                <select class="form-control" id="reporttest" name="report" required>
                                    <option value=""><b>(select one)</b></option>

                                </select>
                            </div>

                            <div class="form-group col-md-6">
                                <label ><b>Progress : </b></label>
                                <select class="form-control" name="progress" >
                                    <option value=""><b>(select one)</b></option>
                                    <option value="Test Job">Test Job</option>
                                    <option value="Closing">Closing</option>
                                </select>
                                <br>
                            </div>

                            <div class="col-md-12">
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


                            <div class="form-group">
                                <label class=""><b>Possibility : </b></label>
                                <select class="form-control"  name="possibility" id="possibility">
                                    @foreach($possibilities as $p)
                                    <option value="{{$p->possibilityId}}">{{$p->possibilityName}}</option>
                                    @endforeach
                                    </select>
                            </div>


                            <div class="form-group">
                                <label class=""><b>Closing Probability : </b></label>
                                <select class="form-control"  name="probability" id="probability">
                                    <option value=""><b>(select one)</b></option>
                                    @foreach($probabilities as $p)
                                        <option value="{{$p->probabilityId}}">{{$p->probabilityName}}</option>
                                    @endforeach

                                </select>
                            </div>


                            <div class="form-group">
                                <label class=""><b>Comment* </b></label>
                                <textarea class="form-control" rows="3" name="comment" required></textarea>
                            </div>
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
                            <!-- <div class="col-md-12" align="center">
                                <label><b> Mined By: </b></label>  <div class="mined" id="mined"></div><br>
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
                                <label><b>Category:</b></label>
                                <select class="form-control"  name="category" id="category">
                                    <option value="">Please Select</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->categoryId}}">{{$category->categoryName}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label><b>Country:</b></label>
                                <select class="form-control"  name="country" id="country">
                                    @foreach($country as $c)
                                        <option value="{{$c->countryId}}">{{$c->countryName}}</option>
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
                                <br><br>
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




                            <div class="col-md-4">
                                <label><b>Contact Person:</b></label>
                                <input type="text" class="form-control" name="personName" value="">
                            </div>

                            <div class="col-md-4">
                                <label><b>Designation:</b></label>
                                <input type="text" class="form-control" name="designation" value="">
                            </div>

                            <div class="col-md-4">
                                <label><b>Email:</b></label>
                                <input type="email" class="form-control" name="email" value="">
                                <br><br>
                            </div>



                            <div class="col-md-6">
                                <label><b>Extra Information:</b></label>
                                <textarea class="form-control" id="comments" name="comments"></textarea>
                            </div>

                            <div class="col-md-3">
                                <label><b>LinkedIn Profile:</b></label>
                                <input type="text" class="form-control" name="linkedin" value="">
                            </div>

                            <div class="col-md-3">
                                <label ><b>Is it your IPP?</b></label>
                                <select class="form-control" name="ippStatus"  id="ippStatus">
                                    <!-- <option value="">(select one)</option> -->
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>


                            
                            <div class="col-md-6">
                                <button class="btn btn-success" type="submit">Update</button>
                            </div>
                        </div>
                    </form>
                    <br><br>
                    <form method="post" action="{{route('leaveLead')}}" id="leaveLeadForm">
                        <div class="row">
                            {{csrf_field()}}

                            <input type="hidden" name="leadId">
                            <div class="form-group col-md-4">

                                <label><b>Status:</b> Select status and cick Leave button</label>
                                <select class="form-control"  name="Status" id="Status" onchange="changeLeadStatus(this)" required>
                                    <option value="">Please Select</option>
                                    @foreach($status as $s)
                                        <option value="{{$s->statusId}}">{{$s->statusName}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4" id="newFileField"></div>
                            <div class="form-group col-md-4" style="margin-top: 3.2%">
                                <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure you want to leave this Lead?')">Leave</button>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <!-- <div class="mineIdDate" id="mineIdDate" align="left"></div> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; -->
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>





<!--Modal for Create New Sales Pipeline-->
<div class="modal" id="set_pipeline">
  <div class="modal-dialog" style="max-width: 400px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Set Sales Pipeline</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form  method="post" action="{{ route('createPipeline') }}">
        {{csrf_field()}}

          <div class="form-group">
            <label for="leadId">Lead Id:</label>
            <input type="text" class="form-control" name="leadId" id="leadId" value="" readonly>
          </div>
          <div class="form-group">
            <label for="companyName">Company:</label>
            <input type="text" class="form-control" name="companyName" id="companyName" value="" readonly>
          </div>

          <div class="form-group">
            <label for="stage">Select Stage:</label>
            <select id="stage" name="stage" class="form-control">
              <option value="Contact">Contact</option>
              <option value="Conversation">Conversation</option>
              <option value="Possibility">Test Possibility</option>
              <option value="Test">Received Test</option>
              <option value="Closed">Deal Closed</option>
              <option value="Lost">Lost the Deal</option>
            </select>
          </div>
          <div class="text-right">
            <button class="btn btn-success" type="submit">Set</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>




<!-- Create Employee  Modal -->
<div class="modal" id="create_employee">
  <div class="modal-dialog" style="max-width: 40%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Create Employee</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form  method="post" action="{{ route('createEmployee') }}">
        {{csrf_field()}}

        <div class="row">
        <div class="col-md-6">
            <div class="form-group">
            <label for="leadId">Lead Id:</label>
            <input type="text" class="form-control" name="leadId" id="leadId" value="" readonly>
            </div>

            <div class="form-group">
            <label for="name">Employee Name:</label>
            <input type="text" class="form-control" name="name" id="name" value="">
            </div>

            <div class="form-group">
            <label for="designationId">Designation:</label>
            <select id="designationId" name="designationId" class="form-control form-control-warning">
                    @foreach($designations as $designation)
                        <option value="{{$designation->designationId}}">{{$designation->designationName}}</option>
                    @endforeach

            </select>
            </div>

            <div class="form-group">
            <label for="number">Contact Number:</label>
            <input type="text" class="form-control" name="number" id="number" value="">
            </div>

            <div class="form-group">
            <label for="jobstatus">Is KDM?</label>
            <select id="jobstatus" name="jobstatus" class="form-control">
                <option value="0" {{ $user->jobstatus == 0 ? 'selected' : '' }}>Left Job</option>
                <option value="1" {{ $user->jobstatus == 1 ? 'selected' : '' }}>Active</option>
            </select>
            </div>
            
        </div>
        <div class="col-md-6">
            <div class="form-group">
            <label for="companyName">Company:</label>
            <input type="text" class="form-control" name="companyName" id="companyName" value="" readonly>
            </div>

            <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" name="email" id="email" value="">
            </div>


            <div class="form-group">
            <label for="countryId">Country:</label>
            <select id="countryId" name="countryId" class="form-control form-control-warning">
                    @foreach($country as $c)
                        <option value="{{$c->countryId}}">{{$c->countryName}}</option>
                    @endforeach
            </select>
            </div>


            <div class="form-group">
            <label for="linkedin">Linkedin:</label>
            <input type="text" class="form-control" name="linkedin" id="linkedin" value="">
            </div>

            <div class="form-group">
            <label for="iskdm">Is KDM?</label>
            <select id="iskdm" name="iskdm" class="form-control">
                <option value="0" {{ $user->iskdm == 0 ? 'selected' : '' }}>No</option>
                <option value="1" {{ $user->iskdm == 1 ? 'selected' : '' }}>Yes</option>
            </select>
            </div>

        </div>
        </div>


          <div class="text-right">
            <button class="btn btn-success" type="submit">Create</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

    <script src="{{url('js/jconfirm.js')}}"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>




<script>

    //CHANGE THE TABS of Call Reports, Followup and Contacts

        var commentsTabLink = document.getElementById('comments-tab');

        // Activate the "Followups" tab
        var tab = new bootstrap.Tab(commentsTabLink);
        tab.show();



        // ACTIVITIES MODAL
        $('#lead_activities').on('show.bs.modal', function(e) {

            var leadId = $(e.relatedTarget).data('lead-id');
            var leadName = $(e.relatedTarget).data('lead-name');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $(e.currentTarget).find('input[name="companyName"]').val(leadName);

            $.ajax({
                type : 'post' ,
                url : '{{route('getActivities')}}',
                data : {_token: CSRF_TOKEN,'leadId':leadId} ,
                success : function(data){

                    $("#activity").html(data);
                    $("#activity").scrollTop($("#activity")[0].scrollHeight);
                }
            });

        });


        // CALL MODAL TO GIVE CALL ENTRIES
        $('#call_modal').on('show.bs.modal', function(e) {
            var leadId = $(e.relatedTarget).data('lead-id');
            var possibility=$(e.relatedTarget).data('lead-possibility');
            var probability=$(e.relatedTarget).data('lead-probability');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $(e.currentTarget).find('input[name="leadId"]').val(leadId);

            $('#possibility').val(possibility);
            $('#probability').val(probability);
            
            $.ajax({
                type : 'post' ,
                url : '{{route('getCallingReport')}}',
                data : {_token: CSRF_TOKEN,'leadId':leadId} ,
                success : function(data){
                    document.getElementById("reporttest").innerHTML = data;
                }
            });
            
            $.ajax({
                type : 'post',
                url : '{{route('editcontactmodalshow')}}',
                data : {_token:CSRF_TOKEN,'leadId':leadId} ,
                success : function(data){
                    console.log(data);
                    if(data !=''){
                        $('#follow-show').html('Current follow-up on  '+data.followUpDate);}
                }
            });
        });


    // CREATE PIPELINE MODAL
    $('#set_pipeline').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var leadId = button.data('lead-id');
        var companyName = button.data('lead-name');
        var pipelineStage = button.data('pipeline-stage'); // Get the pipeline-stage attribute

        // Set the values in the input fields
        $('#leadId').val(leadId);
        $('#companyName').val(companyName);
            
        // Set the value in the select element
        $('#stage').val(pipelineStage);
    });




// DATE PICKER ON CALL MODAL
        $( function() {
            $( "#datepicker" ).datepicker();
        } );



        // CHECK FOLLOWUP DATE TO SEE PREVIOUS FOLLOWUPS
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



            // EDIT MODAL DATA
            $('#edit_modal').on('show.bs.modal', function(e) {
            //var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
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
            var designation=$(e.relatedTarget).data('lead-designation');
            var country=$(e.relatedTarget).data('lead-country');
            var founded=$(e.relatedTarget).data('lead-founded');
            var employee=$(e.relatedTarget).data('lead-employee');
            var volume=$(e.relatedTarget).data('lead-volume');
            var frequency=$(e.relatedTarget).data('lead-frequency');
            var process=$(e.relatedTarget).data('lead-process');
            var ippStatus=$(e.relatedTarget).data('lead-ipp');
            var createdAt=$(e.relatedTarget).data('lead-created');
            var comments=$(e.relatedTarget).data('lead-comments');

            //populate the textbox
            $('#category').val(category);
            // $('div.mineIdDate').text(leadId+' was mined by '+minedBy+' at '+createdAt);
            $('#country').val(country);

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
            $(e.currentTarget).find('#ippStatus').val(ippStatus);
            $('#comments').val(comments);

            @if(Auth::user()->typeId == 4 || Auth::user()->typeId == 5 )
            $(e.currentTarget).find('input[name="companyName"]').attr('readonly', true);
            @endif

        });

        //CHNAGE STATUS ON EDIT LEAD
        function changeLeadStatus(x){
            var value=$(x).val();
            if(value == 6){
                // alert(value);
                $('#newFileField').html('<label><b>New Files* :</b></labe><input type="number" class="form-control" name="newFile" required>');
            }
            else {
                $('#newFileField').html('');
            }
        }




    // CREATE EMPLOYEE
    $('#create_employee').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var leadId = button.data('lead-id');
        var companyName = button.data('lead-name');
        var pipelineStage = button.data('pipeline-stage'); 

        // Set the values in the input fields
        $('#leadId').val(leadId);
        $('#companyName').val(companyName);
    });



</script>

@endsection