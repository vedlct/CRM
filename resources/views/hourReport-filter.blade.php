<table id="managerDaily" class="table table-bordered table-striped">
    <thead>
        <th>Name</th>
        <th>Times</th>
    </thead>
    <tbody>
        @foreach($wp as $user)
        <tr>
            <td>
                {{ $user->userId }}
            </td>
            <td>
                @php
                    $previousTime = null;
                @endphp
                @foreach($work->where('userid', $user->id) as $s)
                    @php
                        $currentTime = strtotime($s->createtime);
                        if ($previousTime !== null) {
                            $timeDiff = abs($currentTime - $previousTime) / 60; 
                            if ($timeDiff <= 1) {
                                echo '<strong style="color: blue">' . $s->createtime . '</strong>';
                            } else if ($timeDiff >= 15) {
                                echo '<strong style="color: red">' . $s->createtime . '</strong>';
                            } else {
                                echo $s->createtime;
                            }
                        } else {
                            echo $s->createtime;
                        }
                        $previousTime = $currentTime;
                    @endphp
                    ||
                @endforeach
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
    
    
    
    
    <!-- <table id="managerDaily" class="table table-bordered table-striped">
        <thead>
        <th>Name</th>
        <th>Times</th>
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
    </table> -->
