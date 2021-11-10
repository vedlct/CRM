<br>

<div class="table-responsive">
    <table class="table table-bordered table-striped" id="assigndatatable">
        <thead>
        <th>User</th>
        <th>Lead Name</th>
        <th>Company Name</th>
        <th>Category</th>
        <th>Area</th>
        <th>AssignBy</th>
        <th>Date</th>


        </thead>
        <tbody>
        @foreach($assigns as $assign)
            <tr>
                <td>{{$assign->userName}}</td>
                <td>{{$assign->leadName}}</td>
                <td>{{$assign->companyName}}</td>
                <td>{{$assign->categoryName}}</td>
                <td>{{$assign->areaName}}</td>
                <td>{{$assign->userAssignBy}}</td>
                <td>{{$assign->assignDate}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>



<script>
    $(function() {
        dataTable = $('#assigndatatable').DataTable();
    });

</script>