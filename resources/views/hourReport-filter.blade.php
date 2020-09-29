    <table id="managerDaily" class="table table-bordered table-responsive table-striped">
        <thead>
        <td>Name</td>
        </thead>
        <tbody>

        {{-- @foreach($wp as $user)
         <tr>
             <td>{{ $user->userId }}</td>
             @foreach($timeDiff as $t)
             <td>
                     {{ $t }}
                 </td>
             @endforeach
         </tr>
         @endforeach--}}

        @foreach($wp as $user)
            <tr>
                <td>
                    {{ $user->userId }}
                </td>

                @foreach($work->where('userid', $user->id) as $s)
                    <td>{{ $s->createtime }}</td>
                @endforeach


            </tr>
        @endforeach

        </tbody>
    </table>
