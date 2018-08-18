<table class="table table-bordered table-striped">
    <thead>
    <th>Company</th>
    <th>Jan</th>
    <th>Feb</th>
    <th>Mar</th>
    <th>Apr</th>
    <th>May</th>
    <th>Jun</th>
    <th>Jul</th>
    <th>Aug</th>
    <th>Sep</th>
    <th>Oct</th>
    <th>Nov</th>
    <th>Dec</th>
    <th>Total</th>

    </thead>
    <tbody>

        @foreach($companies as $company)
            @php($grandTotal=0)
            <tr>
                <td>{{$company->companyName}}</td>
                <td>
                    @foreach($bills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==1)
                            {{$bill->total}}
                            @php($grandTotal+=$bill->total)
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach($bills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==2)
                            {{$bill->total}}
                            @php($grandTotal+=$bill->total)
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach($bills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==3)
                            {{$bill->total}}
                            @php($grandTotal+=$bill->total)
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach($bills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==4)
                            {{$bill->total}}
                            @php($grandTotal+=$bill->total)
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach($bills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==5)
                            {{$bill->total}}
                            @php($grandTotal+=$bill->total)
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach($bills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==6)
                            {{$bill->total}}
                            @php($grandTotal+=$bill->total)
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach($bills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==7)
                            {{$bill->total}}
                            @php($grandTotal+=$bill->total)
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach($bills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==8)
                            {{$bill->total}}
                            @php($grandTotal+=$bill->total)
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach($bills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==9)
                            {{$bill->total}}
                            @php($grandTotal+=$bill->total)
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach($bills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==10)
                            {{$bill->total}}
                            @php($grandTotal+=$bill->total)
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach($bills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==11)
                            {{$bill->total}}
                            @php($grandTotal+=$bill->total)
                        @endif
                    @endforeach
                </td>
                <td>
                    @foreach($bills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==12)
                            {{$bill->total}}
                            @php($grandTotal+=$bill->total)
                        @endif
                    @endforeach
                </td>

                <td>
                    {{$grandTotal}}
                </td>


            </tr>
        @endforeach
    </tbody>
</table>