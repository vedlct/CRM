<div class="row">
    <div class="col-md-4">
        <form method="post" action="{{route('local.insertOldSalePayment')}}">
            {{csrf_field()}}
            <div class="row">
                <input type="hidden" name="leadId" value="{{$leadId}}">
                <div class="form-group col-md-12">
                    <label>Payment</label>
                    <input type="number" class="form-control" name="total" placeholder="TK" required>
                </div>
                <div class="form-group col-md-12">
                    <label>Date</label>
                    <input type="text" class="form-control datepicker" name="date" placeholder="date" required>
                </div>

                <div class="form-group col-md-12">
                    <label></label>
                    <button class="btn btn-success">Insert</button>
                </div>

                <br><br>
                <div class="form-group col-md-12">
                    <label>Total Bill  {{$sales->bill}} Tk</label>
                    <br>
                    <label>Total Paid  {{$totalPayment}} Tk</label>
                    <br>
                    <label>Pending  {{$sales->bill-$totalPayment}} Tk</label>

                </div>

            </div>
        </form>

    </div>




    <div class="col-md-8">
        <div style="width: 100%; height: 400px;overflow-y: scroll;border: 1px solid black;">
            <table class="table table-striped">
                <tbody>
                @foreach($payments as $payment)
                    <tr>
                        <td>
                            {{$payment->total}}
                        </td>
                        <td>
                            {{$payment->firstName}}
                        </td>
                        <td>
                            {{$payment->date}}
                        </td>
                    </tr>
                @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

<script>
    $('.datepicker').datepicker();
</script>