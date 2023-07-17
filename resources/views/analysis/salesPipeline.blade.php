@extends('main')

<style>

.card-container {
  margin-bottom: 10px;
}

.card-body,
.card-footer {
  font-size: 13px;
}

.card a {
  text-decoration: none;
  color: inherit;
}

.card a:hover {
  text-decoration: underline;
}


.card-body {
  max-height: 160px;
  height: auto;
  overflow-y: auto;
}

.card-title {
  font-size: 16px;
  font-weight: 500;
  margin-bottom: 10px;
}

.card-footer {
  padding: 2px !important;
  background-color: #f8f9fa;
  border-top: 1px solid #dee2e6;
}

.card-footer small {
  color: #6c757d;
}

</style>


@section('content')

    <div class="row" style="padding: 30px;">
        <div class="col-md-2">
            <div class="card h-100">
                <div class="card-header bg-secondary text-white">
                    Contact
                    <span class="badge badge-pill badge-white">({{ $pipeline['Contact']['total'] }})</span>
                </div>

                @foreach ($pipeline['Contact']['leads'] as $lead)
                <div class="card-body" data-leadid="{{ $lead->leadId }}">
                        <h5 class="card-text">{{ $lead->website }}</h5>
                        <p class="card-text">
                            <span style="float:left;">Ipp: @if ($lead->ippStatus == 1) Yes @else No @endif</span>
                            <span style="float:right;">{{ $lead->possibilityName }}</span>
                        </p><br><br>
                        <p>
                            <span style="float:left;"><a href="account/{{ $lead->leadId }}" target="_blank"> {{ $lead->leadId }} </a></span> 
                            <span style="float:right;"> <a href="#" data-toggle="modal" data-target="#change_stage"
                                        data-pipeline-id="{{ $lead->pipelineId }}" data-leadid="{{ $lead->leadId }}"
                                        data-leadname="{{ $lead->companyName }}" data-pipeline-stage="{{ $lead->stage }}"
                                        >Change Stage</a>
                            </span>
                        </p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">
                        </small>
                </div>
                @endforeach
            </div>
        </div>

        <div class="col-md-2">
            <div class="card h-100">
                <div class="card-header bg-dark text-white">
                    Conversation
                    <span class="badge badge-pill badge-white">({{ $pipeline['Conversation']['total'] }})</span>
                </div>

                @foreach ($pipeline['Conversation']['leads'] as $lead)
                <div class="card-body" data-leadid="{{ $lead->leadId }}">
                        <h5 class="card-text">{{ $lead->website }}</h5>
                        <p class="card-text">
                            <span style="float:left;">Ipp: @if ($lead->ippStatus == 1) Yes @else No @endif</span>
                            <span style="float:right;">{{ $lead->possibilityName }}</span>
                        </p><br><br>
                        <p>
                            <span style="float:left;"><a href="account/{{ $lead->leadId }}" target="_blank"> {{ $lead->leadId }} </a></span> 
                            <span style="float:right;"> <a href="#" data-toggle="modal" data-target="#change_stage"
                                        data-pipeline-id="{{ $lead->pipelineId }}" data-leadid="{{ $lead->leadId }}"
                                        data-leadname="{{ $lead->companyName }}" data-pipeline-stage="{{ $lead->stage }}"
                                        >Change Stage</a>
                            </span>
                        </p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">
                        </small>
                </div>
                @endforeach
            </div>
        </div>


    <div class="col-md-2">
        <!-- Positive Possibility card -->
        <div class="card h-100">
            <div class="card-header bg-info text-white">
                Positive Possibility
                <span class="badge badge-pill badge-white">({{ $pipeline['Possibility']['total'] }})</span>
            </div>

            @foreach ($pipeline['Possibility']['leads'] as $lead)
                <div class="card-body" data-leadid="{{ $lead->leadId }}">
                        <h5 class="card-text">{{ $lead->website }}</h5>
                        <p class="card-text">
                            <span style="float:left;">Ipp: @if ($lead->ippStatus == 1) Yes @else No @endif</span>
                            <span style="float:right;">{{ $lead->possibilityName }}</span>
                        </p><br><br>
                        <p>
                            <span style="float:left;"><a href="account/{{ $lead->leadId }}" target="_blank"> {{ $lead->leadId }} </a></span> 
                            <span style="float:right;"> <a href="#" data-toggle="modal" data-target="#change_stage"
                                        data-pipeline-id="{{ $lead->pipelineId }}" data-leadid="{{ $lead->leadId }}"
                                        data-leadname="{{ $lead->companyName }}" data-pipeline-stage="{{ $lead->stage }}"
                                        >Change Stage</a>
                            </span>
                        </p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">
                        </small>
                </div>
            @endforeach

        </div>
    </div>

    <div class="col-md-2">
        <!-- Test Received card -->
        <div class="card h-100">
            <div class="card-header bg-success text-white">
                Test Received
                <span class="badge badge-pill badge-white">({{ $pipeline['Test']['total'] }})</span>
            </div>

            @foreach ($pipeline['Test']['leads'] as $lead)
                <div class="card-body" data-leadid="{{ $lead->leadId }}">
                        <h5 class="card-text">{{ $lead->website }}</h5>
                        <p class="card-text">
                            <span style="float:left;">Ipp: @if ($lead->ippStatus == 1) Yes @else No @endif</span>
                            <span style="float:right;">{{ $lead->possibilityName }}</span>
                        </p><br><br>
                        <p>
                            <span style="float:left;"><a href="account/{{ $lead->leadId }}" target="_blank"> {{ $lead->leadId }} </a></span> 
                            <span style="float:right;"> <a href="#" data-toggle="modal" data-target="#change_stage"
                                        data-pipeline-id="{{ $lead->pipelineId }}" data-leadid="{{ $lead->leadId }}"
                                        data-leadname="{{ $lead->companyName }}" data-pipeline-stage="{{ $lead->stage }}"
                                        >Change Stage</a>
                            </span>
                        </p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">
                        </small>
                </div>
            @endforeach

        </div>
    </div>

    <div class="col-md-2">
        <!-- Closed card -->
        <div class="card h-100">
            <div class="card-header bg-primary text-white">
                Closed
                <span class="badge badge-pill badge-white">({{ $pipeline['Closed']['total'] }})</span>
            </div>

            @foreach ($pipeline['Closed']['leads'] as $lead)
                <div class="card-body" data-leadid="{{ $lead->leadId }}">
                        <h5 class="card-text">{{ $lead->website }}</h5>
                        <p class="card-text">
                            <span style="float:left;">Ipp: @if ($lead->ippStatus == 1) Yes @else No @endif</span>
                            <span style="float:right;">{{ $lead->possibilityName }}</span>
                        </p><br><br>
                        <p>
                            <span style="float:left;"><a href="account/{{ $lead->leadId }}" target="_blank"> {{ $lead->leadId }} </a></span> 
                            <span style="float:right;"> <a href="#" data-toggle="modal" data-target="#change_stage"
                                        data-pipeline-id="{{ $lead->pipelineId }}" data-leadid="{{ $lead->leadId }}"
                                        data-leadname="{{ $lead->companyName }}" data-pipeline-stage="{{ $lead->stage }}"
                                        >Change Stage</a>
                            </span>
                        </p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">
                        </small>
                </div>
            @endforeach

        </div>
    </div>

    <div class="col-md-2">
        <!-- Not Closed card -->
        <div class="card h-100">
        <div class="card-header bg-danger text-white">
            Lost Deal
            <span class="badge badge-pill badge-white">({{ $pipeline['Lost']['total'] }})</span>
        </div>

        @foreach ($pipeline['Lost']['leads'] as $lead)
                <div class="card-body" data-leadid="{{ $lead->leadId }}">
                        <h5 class="card-text">{{ $lead->website }}</h5>
                        <p class="card-text">
                            <span style="float:left;">Ipp: @if ($lead->ippStatus == 1) Yes @else No @endif</span>
                            <span style="float:right;">{{ $lead->possibilityName }}</span>
                        </p><br><br>
                        <p>
                            <span style="float:left;"><a href="account/{{ $lead->leadId }}" target="_blank"> {{ $lead->leadId }} </a></span> 
                            <span style="float:right;"> <a href="#" data-toggle="modal" data-target="#change_stage"
                                        data-pipeline-id="{{ $lead->pipelineId }}" data-leadid="{{ $lead->leadId }}"
                                        data-leadname="{{ $lead->companyName }}" data-pipeline-stage="{{ $lead->stage }}"
                                        >Change Stage</a>
                            </span>
                        </p>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">
                        </small>
                </div>
            @endforeach


        </div>
    </div>


</div>


<!-- Modal for Changing Stage of Sales Pipeline-->
<div class="modal" id="change_stage">
  <div class="modal-dialog" style="max-width: 400px;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Change Stage</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form  method="post" action="{{ route('updatePipeline') }}">
        {{csrf_field()}}

            <input type="hidden" class="form-control" name="pipelineId" id="pipelineId" value="" >

          <div class="form-group">
            <label for="leadId">Lead Id:</label>
            <input type="text" class="form-control" name="leadId" id="leadId" value="" disabled>
          </div>
          <div class="form-group">
            <label for="companyName">Company:</label>
            <input type="text" class="form-control" name="companyName" id="companyName" value="" disabled>
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
            <button class="btn btn-success" type="submit">Update</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-danger" onclick="removePipeline()">Remove</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



<!--Modal for Create New Sales Pipeline-->
<!-- <div class="modal fade" id="create_pipeline_modal" tabindex="-1" role="dialog" aria-labelledby="createPipelineModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPipelineModalLabel">Create Sales Pipeline</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('createPipeline') }}" method="POST">
                {{ csrf_field() }}
                    <div class="form-group">
                        <label for="companyName">Company Name</label>
                        <select class="form-control" id="companyName" name="companyName" required>
                            <option value="">Select a company name</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="website">Website</label>
                        <input type="text" class="form-control" id="website" name="website" readonly>
                    </div>
                    <div class="form-group">
                        <label for="stage">Stage</label>
                        <select class="form-control" id="stage" name="stage" required>
                            <option value="Contact">Contact</option>
                            <option value="Conversation">Conversation</option>
                            <option value="Possibility">Test Possibility</option>
                            <option value="Test">Test Received</option>
                            <option value="Closed">Deal Closed</option>
                            <option value="Lost">Lost the Deal</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create</button>
                </form>
            </div>
        </div>
    </div>
</div> -->



@endsection

@section('foot-js')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}" />


<script>


    $('#change_stage').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget);
        var leadId = button.data('leadid');
        var companyName = button.data('leadname');
        var pipelineId = button.data('pipeline-id');
        var pipelineStage = button.data('pipeline-stage'); // Get the pipeline-stage attribute

        // Set the values in the input fields
        $('#leadId').val(leadId);
        $('#companyName').val(companyName);
        $('#pipelineId').val(pipelineId);
            
        // Set the value in the select element
        $('#stage').val(pipelineStage);
    });






//   function redirectToLead(element) {
//     var leadId = element.getAttribute('data-leadid');
//     var companyName = element.getAttribute('data-leadname');
//     var url = 'account/' + leadId;
//     window.location.href = url;
//   }

  


    function removePipeline() {
        // Get the pipelineId value
        var pipelineId = $('#pipelineId').val();

        // Show a confirmation warning before proceeding
        if (!confirm("Are you sure you want to remove this from pipeline?")) {
            return; // Exit the function if user clicks "Cancel"
        }
        
        // Make an Ajax request to update the workStatus
        $.ajax({
            url: "{{ route('removePipeline') }}",
            type: "POST",
            data: { pipelineId: pipelineId },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response); // You can do something here, like showing a success message

                // Hide the modal
                $('#change_stage').modal('hide');

                // window.location.reload();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText); // You can display an error message or handle the error as needed
            }
        });
    }

    $('#change_stage').on('hidden.bs.modal', function() {
        $('.modal-backdrop').remove();
        window.location.reload();
    });





        

</script>


@endsection
