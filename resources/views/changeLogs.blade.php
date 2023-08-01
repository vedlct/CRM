@extends('main')
<style>
body {
    font-family: Arial, sans-serif;
    margin: 20px;
}

.changelog {
    max-width: 600px;
    margin: 0 auto;
}

h1 {
    text-align: center;
}
.card {
    border: 1px solid #ccc;
    border-radius: 10px;
    margin-bottom: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.card-title {
    padding: 10px;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    margin-bottom: 0;
}

.card-body {
    padding: 20px;
}

.card-body .list-group-item {
    border: none;
    padding: 5px 10px;
    font-size: 14px;
}
    
</style>

@section('content')

<div class="row mainrow">
    <div class="col-md-12">
        <h1 class="text-center mb-4" style="padding: 30px 0;">Change Logs</h1>






        

        <div class="card change-log-card">
            <div class="card-body">
            <h5 class="card-title"><span class="badge badge-info">2.0.01</span> - 1 August 2023</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Add Remove Employee button on Employee table.</li>
                    <li class="list-group-item">Bug fixed on Account View.</li>
                    <li class="list-group-item">Converted tables into Server Side.</li>
                </ul>
            </div>
        </div>


        <div class="card change-log-card">
            <div class="card-body">
            <h5 class="card-title"><span class="badge badge-info">2.0</span> - 26 July 2023</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">LUANCH NEW VERSION OF CRM WITH NEW LOOK.</li>
                    <li class="list-group-item">Bug fixed on User Profile.</li>
                </ul>
            </div>
        </div>
    </div>
</div>


@endsection

@section('foot-js')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

@endsection
