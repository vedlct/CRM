<div class="table-responsive">
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
                    @php($tempBill=0)
                    @foreach($bills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==1)
                            @php($tempBill+=$bill->total)
                            @php($grandTotal+=$bill->total)
                            @break
                        @endif
                    @endforeach
                    @foreach($oldBills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==1)
                            @php($tempBill+=$bill->total)
                            @php($grandTotal+=$bill->total)
                            @break
                        @endif
                    @endforeach
                    {{$tempBill}}
                </td>
                <td>
                    @php($tempBill=0)
                    @foreach($bills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==2)
                            @php($tempBill+=$bill->total)
                            @php($grandTotal+=$bill->total)
                            @break
                        @endif
                    @endforeach
                    @foreach($oldBills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==2)
                            @php($tempBill+=$bill->total)
                            @php($grandTotal+=$bill->total)
                            @break
                        @endif
                    @endforeach
                    {{$tempBill}}
                </td>
                <td>
                    @php($tempBill=0)
                    @foreach($bills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==3)
                            @php($tempBill+=$bill->total)
                            @php($grandTotal+=$bill->total)
                            @break
                        @endif
                    @endforeach
                    @foreach($oldBills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==3)
                            @php($tempBill+=$bill->total)
                            @php($grandTotal+=$bill->total)
                            @break
                        @endif
                    @endforeach
                    {{$tempBill}}

                </td>
                <td>
                    @php($tempBill=0)
                    @foreach($bills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==4)
                            @php($tempBill+=$bill->total)
                            @php($grandTotal+=$bill->total)
                            @break
                        @endif
                    @endforeach
                    @foreach($oldBills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==4)
                            @php($tempBill+=$bill->total)
                            @php($grandTotal+=$bill->total)
                            @break
                        @endif
                    @endforeach
                    {{$tempBill}}

                </td>
                <td>
                    @php($tempBill=0)
                    @foreach($bills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==5)
                            @php($tempBill+=$bill->total)
                            @php($grandTotal+=$bill->total)
                            @break
                        @endif
                    @endforeach
                    @foreach($oldBills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==5)
                            @php($tempBill+=$bill->total)
                            @php($grandTotal+=$bill->total)
                            @break
                        @endif
                    @endforeach
                    {{$tempBill}}

                </td>
                <td>
                    @php($tempBill=0)
                    @foreach($bills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==6)
                            @php($tempBill+=$bill->total)
                            @php($grandTotal+=$bill->total)
                            @break
                        @endif
                    @endforeach
                    @foreach($oldBills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==6)
                            @php($tempBill+=$bill->total)
                            @php($grandTotal+=$bill->total)
                            @break
                        @endif
                    @endforeach
                    {{$tempBill}}

                </td>
                <td>
                    @php($tempBill=0)
                    @foreach($bills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==7)
                            @php($tempBill+=$bill->total)
                            @php($grandTotal+=$bill->total)
                            @break
                        @endif
                    @endforeach
                    @foreach($oldBills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==7)
                            @php($tempBill+=$bill->total)
                            @php($grandTotal+=$bill->total)
                            @break
                        @endif
                    @endforeach
                    {{$tempBill}}

                </td>
                <td>
                    @php($tempBill=0)
                    @foreach($bills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==8)
                            @php($tempBill+=$bill->total)
                            @php($grandTotal+=$bill->total)
                            @break
                        @endif
                    @endforeach
                    @foreach($oldBills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==8)
                            @php($tempBill+=$bill->total)
                            @php($grandTotal+=$bill->total)
                            @break
                        @endif
                    @endforeach
                    {{$tempBill}}

                </td>
                <td>
                    @php($tempBill=0)
                    @foreach($bills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==9)
                            @php($tempBill+=$bill->total)
                            @php($grandTotal+=$bill->total)
                            @break
                        @endif
                    @endforeach
                    @foreach($oldBills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==9)
                            @php($tempBill+=$bill->total)
                            @php($grandTotal+=$bill->total)
                            @break
                        @endif
                    @endforeach
                    {{$tempBill}}

                </td>
                <td>
                    @php($tempBill=0)
                    @foreach($bills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==10)
                            @php($tempBill+=$bill->total)
                            @php($grandTotal+=$bill->total)
                            @break
                        @endif
                    @endforeach
                    @foreach($oldBills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==10)
                            @php($tempBill+=$bill->total)
                            @php($grandTotal+=$bill->total)
                            @break
                        @endif
                    @endforeach
                    {{$tempBill}}

                </td>
                <td>
                    @php($tempBill=0)
                    @foreach($bills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==11)
                            @php($tempBill+=$bill->total)
                            @php($grandTotal+=$bill->total)
                            @break
                        @endif
                    @endforeach
                    @foreach($oldBills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==11)
                            @php($tempBill+=$bill->total)
                            @php($grandTotal+=$bill->total)
                            @break
                        @endif
                    @endforeach
                    {{$tempBill}}

                </td>
                <td>
                    @php($tempBill=0)
                    @foreach($bills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==12)
                            @php($tempBill+=$bill->total)
                            @php($grandTotal+=$bill->total)
                            @break
                        @endif
                    @endforeach
                    @foreach($oldBills as $bill)
                        @if($bill->local_companyId == $company->local_companyId && $bill->month==12)
                            @php($tempBill+=$bill->total)
                            @php($grandTotal+=$bill->total)
                            @break
                        @endif
                    @endforeach
                    {{$tempBill}}

                </td>

                <td>
                    {{$grandTotal}}
                </td>


            </tr>
        @endforeach
    </tbody>
</table>
</div>