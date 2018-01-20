@extends('main')



@section('content')




    <div class="card">
        <div class="card-header" align="center"><h2>Update Your Report</h2></div>
        <div class="card-body">

        <div  style="float: left;width: 50%">
            <div class="form-group">
            <h4><b>Company Name : </b>{{$lead->companyName}}</h4>
            </div>

            <div class="form-group">
            <h4><b>Website : </b>{{$lead->website}}</h4>
            </div>
            <div class="form-group">
            <h4><b>Category : </b> {{$lead->category->categoryName}}</h4>
            </div>
            <div class="form-group">
            <h4><b>Contact Person : </b> {{$lead->personName}}</h4>
            </div>
            <div class="form-group">
            <h4><b>Designation : </b> {{$lead->designation}}</h4>
            </div>
            <div class="form-group">
            <h4><b>Number : </b> {{$lead->contactNumber}}</h4>
            </div>
            <div class="form-group">
            <h4><b>Email : </b> {{$lead->email}}</h4>
            </div>



            <div class="form-group">
                <label class="col-md-12"><b>Comment</b></label>
            <div class="col-md-8" style="position: absolute;height: 20%; width: 30%; overflow-y: scroll; border: solid black 1px;">
                <ul>
                @foreach($comments as $comment)
                        <li>{{$comment->comments}}</li>
                @endforeach
                </ul>
            </div>

            </div>







        </div>






        <div style="float: right;width: 50%">



            <form action="{{route('storeReport',['id'=>$lead->leadId])}}" method="post">
                {{csrf_field()}}


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

                <div class="form-group">
                    <label class="col-md-6"><b>Comment : </b></label>

                    <textarea class="col-md-8" rows="3" name="comment" required>

                    </textarea>
                </div>



                <div class="form-group">
                    <button type="submit" class="btn btn-primary form-group">Submit</button>
                </div>

            </form>





        </div>

        </div></div>








@endsection