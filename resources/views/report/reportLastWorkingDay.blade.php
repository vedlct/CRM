@extends('main')



@section('content')

<div class="row">
    <div class="col-sm-12 col-xl-12" style="padding:50px; 0">
        <h2 style="text-align: center; padding: 50px 50px 0 50px;">What Happened Yesterday?</h2>
    </div>
            <div class="col-sm-6 col-xl-2">

                <div class="card border">
                    <div class="card-body">
                        <h4 class="card-title">Less Caller</h4>
                        <table class="table">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Email Percentage (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($userEmailPercentages as $userEmailPercentage)
                            <tr>
                                <td>{{ $userEmailPercentage['userId'] }}</td>
                                <td>{{ number_format($userEmailPercentage['emailPercentage'], 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                    </div>
                </div>

            </div>

            <div class="col-sm-6 col-xl-2">
                <div class="card border">
                    <div class="card-body">
                        <h4 class="card-title">Email Ratio</h4>
                
                
                    </div>
                </div>

            </div>

            <div class="col-sm-6 col-xl-2">
                <div class="card border">
                    <div class="card-body">
                        <h4 class="card-title">Frequent Caller</h4>
                
                
                    </div>
                </div>

            </div>

            <div class="col-sm-6 col-xl-2">
                <div class="card border">
                    <div class="card-body">
                        <h4 class="card-title">Brake Taker</h4>
                
                
                    </div>
                </div>

            </div>

            <div class="col-sm-6 col-xl-2">
                <div class="card border">
                    <div class="card-body">
                        <h4 class="card-title">Slow Miner</h4>
                
                
                    </div>
                </div>

            </div>

            <div class="col-sm-6 col-xl-2">
                <div class="card border">
                    <div class="card-body">
                        <h4 class="card-title">Zero Contact</h4>
                        
                    </div>
                </div>
            </div>


        </div>



</div>





@endsection


@section('foot-js')
    <meta name="csrf-token" content="{{ csrf_token() }}" />


    <script>

       


    </script>

@endsection










