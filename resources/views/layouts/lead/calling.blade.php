@extends('main')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-primary text-white">Outbound Call</div>
                        {{csrf_field()}}

                        <div class="card-body">
                            <div class="mb-3">
                                <label for="phoneNumber" class="form-label">Enter Phone Number:</label>
                                <input type="tel" class="form-control" id="phoneNumber" placeholder="Enter phone number">
                            </div>
                            <button id="dialButton" class="btn btn-success">Dial</button>
                            <button id="endCallButton" class="btn btn-danger" disabled>End Call</button>

                            <div class="mt-4">
                                <h5>Conversation</h5>
                                <div id="callStatus" class="mb-2">Call Status: Idle</div>
                                <textarea id="conversation" class="form-control" rows="5" disabled></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('foot-js')

<meta name="csrf-token" content="{{ csrf_token() }}" />

<script>
    document.getElementById('dialButton').addEventListener('click', () => {
    const phoneNumber = document.getElementById('phoneNumber').value;

    $.ajax({
        type: 'POST',
        url: '{{ route('initiateCall') }}',
        data: { phone_number: phoneNumber },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            console.log(response.message);
        },
        error: function(error) {
            console.error('Call initiation failed:', error.responseText);
        }
    });
    
});

    </script>
@endsection
