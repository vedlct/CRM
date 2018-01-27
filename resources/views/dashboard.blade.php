@extends('main')



@section('content')


    <div id="chart-div"></div>

    <?= $lava->render('PieChart', 'IMDB', 'chart-div') ?>




@endsection