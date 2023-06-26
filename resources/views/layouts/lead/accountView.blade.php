@extends('main')


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
                                    <b class="text-secondary">Lead Id:</b>
                                    {{$lead->leadId}}
                                </p>
                                <p>
                                    <b class="text-secondary">Company Name:</b>
                                    {{$lead->companyName}}
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

                                <div class="mb-3">
                                    <a href="#call_modal" class="btn btn-info">Calling</a>

                                    <a href="#lead_activities" class="btn btn-primary" data-toggle="modal" data-lead-id="{{$lead->leadId}}" data-lead-name="{{$lead->companyName}}">Activities</a>
                                    
                                    <a href="#edit_modal" class="btn btn-secondary">Edit</a>
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
                                    <b class="text-secondary">KDM:</b>
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
                                <ul class="nav nav-tabs border-tab mb-0" id="top-tab" role="tablist">
                                    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#comments" role="tab" aria-selected="false">Call Reports</a>
                                        <div class="material-border"></div>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#followups" role="tab" aria-selected="false">Followups</a>
                                        <div class="material-border"></div>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#contacts" role="tab" aria-selected="true">Contacts</a>
                                        <div class="material-border"></div>
                                    </li>
                                </ul>
                                <div class="tab-content" id="top-tabContent">
                                    <div class="tab-pane fade active show" id="comments" role="tabpanel">
                                        <!-- comments -->
                                        <div class="alert alert-primary p-2">
                                            <h4>By Riz</h4>
                                            <p class="text-dark mb-2">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                            <div class="media mb-0">
                                                <div class="media-body">
                                                    <p class="mb-1">6 July 2022 3:50 PM</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="alert alert-primary p-2">
                                            <h4>By Steven</h4>
                                            <p class="text-dark mb-2">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                            <div class="media mb-0">
                                                <div class="media-body">
                                                    <p class="mb-1">6 July 2022 3:50 PM</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="alert alert-primary p-2">
                                            <h4>By Riz</h4>
                                            <p class="text-dark mb-2">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                            <div class="media mb-0">
                                                <div class="media-body">
                                                    <p class="mb-1">6 July 2022 3:50 PM</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- followup tab -->
                                    <div class="tab-pane fade" id="followup" role="tabpanel">
                                        <div class="alert alert-primary p-2">
                                            <p class="mb-2">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                            <div class="media mb-0">
                                                <div class="media-body d-flex justify-content-between">
                                                    <p class="mb-1">6 July 2022 3:50 PM</p>
                                                    <p class="mb-1">By Riz</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="alert alert-primary p-2">
                                            <p class="mb-2">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                            <div class="media mb-0">
                                                <div class="media-body d-flex justify-content-between">
                                                    <p class="mb-1">6 July 2022 3:50 PM</p>
                                                    <p class="mb-1">By Riz</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- contacts tab -->
                                    <div class="tab-pane fade" id="contacts" role="tabpanel">
                                        <p class="my-1">
                                            <a href="#" class="btn btn-primary">Create Contact</a>
                                        </p>
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p>
                                                    <b class="text-secondary">Full Name:</b>
                                                    Riz
                                                </p>
                                                <p>
                                                    <b class="text-secondary">Email Address:</b>
                                                    riz@tcl.com
                                                </p>
                                                <p>
                                                    <b class="text-secondary">Linkedin:</b>

                                                </p>
                                                <p>
                                                    <b class="text-secondary">Employe Status:</b>

                                                </p>
                                            </div>
                                            <div class="col-md-6">
                                                <p>
                                                    <b class="text-secondary">Designation:</b>
                                                    Sales Executive
                                                </p>
                                                <p>
                                                    <b class="text-secondary">Phone Number:</b>
                                                    +880187544889
                                                </p>
                                                <p>
                                                    <b class="text-secondary">Country:</b>
                                                    Bangladesh
                                                </p>
                                                <p>
                                                    <b class="text-secondary">Notes:</b>
                                                    Notes about this.
                                                </p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
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
                                        </div>
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
                                            $probabilityName  = $leadProbability ? $leadProbability->probabilityName  : 'Unknown Probability';
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
                                    <a href="#" role="button" data-bs-toggle="modal" data-bs-target="#operatedIn" class="text-decoration-underline">Bangladesh</a>
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
                                                Bangladesh
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
        <div class="modal-dialog" style="max-width: 60%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" name="modal-title">All Activities</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                    <b>Company Name:</b>
                    <input type="text" name="companyName" readonly>
                        </div>

                        <div class="col-md-6">
                        <div class="form-group">
                        <label class=""><b>Activities : </b></label>

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






@endsection

@section('foot-js')

    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>

    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>


    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>

    <script src="{{url('js/jconfirm.js')}}"></script>

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>




<script>





</script>

@endsection