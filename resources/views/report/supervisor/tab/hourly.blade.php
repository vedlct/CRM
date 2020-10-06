<div class="card" style="padding:10px;">

    <div class="card-body">
        <h2 class="card-title" align="center"><b>Hour Report</b></h2>

        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <input type="date" onchange="day()" id="selectedDay" class="form-control ">
                </div>
            </div>
            <div class="table-responsive">
                <table id="managerDaily" class="table table-bordered table-responsive table-striped">
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
                                    {{ $s->createtime." || "  }}
                                @endforeach
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>

            <div id="hourFilter"></div>
        </div>
    </div>
</div>

<script>
    function day() {
        $("#managerDaily").hide();
        var selectedDay = document.getElementById("selectedDay").value;
        $.ajax({
            type: 'POST',
            url: "{!! route('hour.report-filter') !!}",
            cache: false,
            data: {_token: "{{csrf_token()}}", 'selectedDay': selectedDay},
            success: function (data) {
                // alert(data);
                $("#hourFilter").html(data);
            }
        });
    }
</script>





































