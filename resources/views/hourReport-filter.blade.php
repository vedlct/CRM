    <table id="managerDaily" class="table table-bordered table-responsive table-striped">
        <thead>
        <td>Name</td>
        </thead>
        <tbody>
        @foreach($wp as $user)
            <tr>
                <td>
                    {{ $user->userId }}
                </td>
                <td>
                @foreach($work->where('userid', $user->id) as $s)
                    {{ $s->createtime." || " }}
                @endforeach
                </td>

            </tr>
        @endforeach

        </tbody>
    </table>
