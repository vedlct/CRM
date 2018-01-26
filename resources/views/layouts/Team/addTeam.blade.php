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


            <div class="container">
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
                            <button class="btn btn-info btn-sm" style="float: left;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
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






@endsection