@extends('main')


@section('content')

    <div class="card" style="padding: 10px;">
        <div class="card-body">
            <form method="post" action="{{route('insertTeam')}}">
                {{@csrf_field()}}
                <label><b>Insert Team</b></label><br>
                @if ($errors->has('teamName'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('teamName') }}</strong>
                                    </span>
                @endif
            <input type="text" name="teamName"  style="border-radius: 10px" placeholder="insert team name">
            <button type="submit" class="btn btn-success">submit</button>
            </form>

            <br><br>


            <div style="max-width: 400px;">
                <h2 align="center"><b>Teams</b></h2>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Team Name</th>
                        <th>action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($teams as $team)
                    <tr>
                        <td>{{$team->teamName}}</td>
                        <td>
                         
                            <!-- Trigger the Edit modal with a button -->
                            <a href="#edit_modal" data-toggle="modal" class="btn btn-info btn-sm"
                               data-team-id="{{$team->teamId}}"
                               data-team-name="{{$team->teamName}}" style="float: left;">
                                <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>


                            <form  method="post" action="{{route('deleteTeam',['id' => $team->teamId])}}">
                                {{@csrf_field()}}
                                {{method_field('DELETE')}}
                                <button class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i></button>
                            </form>

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
        <div class="modal-dialog" style="max-width: 30%;">

            <form class="modal-content" method="post" action="{{route('teamUpdate')}}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" name="modal-title">Edit Team</h4>
                </div>
                <div class="modal-body">
                    {{csrf_field()}}
                    {{method_field('PUT')}}

                    <div class="row">
                        <input type="hidden" name="teamId">
                        <div class="col-md-4">

                            <label>Team Name:</label>
                            <input type="text" class="form-control" name="teamName" value="">
                            <br>
                        </div>



                        <div class="col-md-12">
                            <button class="btn btn-success" type="submit">Update</button>
                        </div>


                    </div>

                </div>



                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div></form>
            {{--<button>Leave</button>--}}
        </div>
    </div>



@endsection

@section('foot-js')
<script>
    
    $('#edit_modal').on('show.bs.modal', function(e) {

        //get data-id attribute of the clicked element
        var teamId = $(e.relatedTarget).data('team-id');
        var teamName = $(e.relatedTarget).data('team-name');
        


        //populate the textbox
        $(e.currentTarget).find('input[name="teamId"]').val(teamId);
        $(e.currentTarget).find('input[name="teamName"]').val(teamName);
        

    });
    
    
</script>

    
@endsection    