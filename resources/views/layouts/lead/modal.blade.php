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

                <div class="" style=" height: 10%; width: 30%; overflow-y: scroll; border: solid black 1px;" id="comment">

                </div>

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