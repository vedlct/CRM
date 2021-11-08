<div class="table-responsive">
    <table class="table table-bordered table-striped" id="assigndatatable">
        <thead>
        <th>Lead Name</th>
        <th>Company Name</th>
        <th>Category</th>
        <th>Area</th>
        <th>Payment</th>
        <th>Date</th>
        </thead>
        <tbody>
            @foreach($bills as $bill)
                <tr>
                    <th>{{$bill->leadName}}</th>
                    <th>{{$bill->companyName}}</th>
                    <th>{{$bill->categoryName}}</th>
                    <th>{{$bill->areaName}}</th>
                    <th>{{$bill->paymentInserted}}</th>
                    <th>{{$bill->paymentDate}}</th>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>