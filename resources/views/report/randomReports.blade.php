@extends('main')

<style>
  .card {
    transition: transform 0.5s ease;
  }

  .card:hover {
    transform: scale(1.05);
  }

  .mainrow {
    padding: 0 60px;
  }


</style>

@section('content')



    <div class="row mainrow">
        <div class="col-md-12">
            <h1 class="text-center mb-4" style="padding: 30px 0 0 0;">Random Reports </h1>
            <h4 class="text-center mb-4" style="padding: -20px 0 30px 0;">Since January 1st, 2023 </h4>

                <div class="card"  style="padding: 40px;">
                <h3 class="card-title" align="center">My Weekly, Monthly and Yearly Comparison</h3>

                    <div class="table-responsive m-t-40">

                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Timeframe</th>
                                    <th>Calls</th>
                                    <th>Contact</th>
                                    <th>Call to Contact</th>
                                    <th>Conversation</th>
                                    <th>Call to Convo</th>
                                    <th>Tests</th>
                                    <th>Call to Test</th>
                                    <th>Contact to Test</th>
                                    <th>Convo to Test</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Current Year</td>
                                    <td>{{ $totalOwnCall }}</td>
                                    <td>{{ $totalOwnContact }}</td>
                                    <td>{{ number_format($callToContact, 1) }}%</td>
                                    <td>{{ $totalOwnConvo }}</td>
                                    <td>{{ number_format($callToConvo, 1) }}%</td>
                                    <td>{{ $totalOwnTest }}</td>
                                    <td>{{ number_format($callToTest, 1) }}%</td>
                                    <td>{{ number_format($contactToTest, 1) }}%</td>
                                    <td>{{ number_format($convoToTest, 1) }}%</td>
                                </tr>
                                <tr>
                                    <td>Current Month</td>
                                    <td>{{ $monthlyOwnCall }}</td>
                                    <td>{{ $monthlyOwnContact }}</td>
                                    <td>{{ number_format($callToContactMonthly, 1) }}%</td>
                                    <td>{{ $monthlyOwnConvo }}</td>
                                    <td>{{ number_format($callToConvoMonthly, 1) }}%</td>
                                    <td>{{ $monthlyOwnTest }}</td>
                                    <td>{{ number_format($callToTestMonthly, 1) }}%</td>
                                    <td>{{ number_format($contactToTestMonthly, 1) }}%</td>
                                    <td>{{ number_format($convoToTestMonthly, 1) }}%</td>
                                </tr>
                                <tr>
                                    <td>Current Week</td>
                                    <td>{{ $weeklyOwnCall }}</td>
                                    <td>{{ $weeklyOwnContact }}</td>
                                    <td>{{ number_format($callToContactWeekly, 1) }}%</td>
                                    <td>{{ $weeklyOwnConvo }}</td>
                                    <td>{{ number_format($callToConvoWeekly, 1) }}%</td>
                                    <td>{{ $weeklyOwnTest }}</td>
                                    <td>{{ number_format($callToTestWeekly, 1) }}%</td>
                                    <td>{{ number_format($contactToTestWeekly, 1) }}%</td>
                                    <td>{{ number_format($convoToTestWeekly, 1) }}%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>




            <div class="row">

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Current Week's Top Scorer</h4>
                            <p class="card-text">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td>Total Calls</td>
                                                <td>{{$maxThisWeekCall  ?? 0 }}</td>
                                            </tr>
                                            <tr>
                                                <td>Total Contacts</td>
                                                <td>{{$maxThisWeekContact  ?? 0 }}</td>
                                            </tr>
                                            <tr>
                                                <td>Total Conversation</td>
                                                <td>{{$maxThisWeekConvo  ?? 0 }}</td>
                                            </tr>
                                            <tr>
                                                <td>Total Free Trial</td>
                                                <td>{{$maxThisWeekTest  ?? 0 }}</td>
                                            </tr>
                                            <tr>
                                                <td>Total Lead Mining</td>
                                                <td>{{$maxThisWeekLeadMining  ?? 0 }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Current Month's Top Scorer</h4>
                            <p class="card-text">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                        <tr>
                                            <td>Total Calls</td>
                                            <td>{{ $maxThisMonthCall ?? 0 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Contacts</td>
                                            <td>{{ $maxThisMonthContact ?? 0 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Conversation</td>
                                            <td>{{ $maxThisMonthConvo ?? 0 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Free Trial</td>
                                            <td>{{ $maxThisMonthTest ?? 0 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Lead Mining</td>
                                            <td>{{ $maxThisMonthLeadMining ?? 0 }}</td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Current Year's Top Scorer</h4>
                            <p class="card-text">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td>Total Calls</td>
                                                <td>{{$maxTotalCall ?? 0 }}</td>
                                            </tr>
                                            <tr>
                                                <td>Total Contact</td>
                                                <td>{{$maxTotalContact ?? 0 }}</td>
                                            </tr>
                                            <tr>
                                                <td>Total Conversation</td>
                                                <td>{{$maxTotalConvo ?? 0 }}</td>
                                            </tr>
                                            <tr>
                                                <td>Total Free Trial</td>
                                                <td>{{$maxTotalTest ?? 0 }}</td>
                                            </tr>
                                            <tr>
                                                <td>Total Lead Mining</td>
                                                <td>{{$maxTotalLeadMining ?? 0 }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </p>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>



@endsection

@section('foot-js')

<script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>

<script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
<script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>


<script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>
<meta name="csrf-token" content="{{ csrf_token() }}" />


<!-- Additional JavaScript code goes here -->
<script>
  const cards = document.querySelectorAll('.card');

  cards.forEach(card => {
    card.addEventListener('mouseover', () => {
      card.classList.add('hover');
    });

    card.addEventListener('mouseout', () => {
      card.classList.remove('hover');
    });
  });

  $(document).ready(function() {
            $('#myTable').DataTable({
                "processing": true,
                stateSave: true,
            });

        });
  
</script>


@endsection
