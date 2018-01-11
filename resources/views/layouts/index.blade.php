@extends('main')

    @section('content')


        <!-- Page Header-->
        <header class="page-header">
            <div class="container-fluid">
                <h2 class="no-margin-bottom">Dashboard</h2>
            </div>
        </header>

        <!-- Dashboard Counts Section-->
        <section class="dashboard-counts no-padding-bottom">
            <div class="container-fluid">
                <div class="row bg-white has-shadow">
                    <!-- Item -->
                    <div class="col-xl-3 col-sm-6">
                        <div class="item d-flex align-items-center">
                            <div class="icon bg-violet"><i class="icon-user"></i></div>
                            <div class="title"><span>New<br>Clients</span>
                                <div class="progress">
                                    <div role="progressbar" style="width: 25%; height: 4px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-violet"></div>
                                </div>
                            </div>
                            <div class="number"><strong>25</strong></div>
                        </div>
                    </div>
                    <!-- Item -->
                    <div class="col-xl-3 col-sm-6">
                        <div class="item d-flex align-items-center">
                            <div class="icon bg-red"><i class="icon-padnote"></i></div>
                            <div class="title"><span>Work<br>Orders</span>
                                <div class="progress">
                                    <div role="progressbar" style="width: 25%; height: 4px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-red"></div>
                                </div>
                            </div>
                            <div class="number"><strong>70</strong></div>
                        </div>
                    </div>
                    <!-- Item -->
                    <div class="col-xl-3 col-sm-6">
                        <div class="item d-flex align-items-center">
                            <div class="icon bg-green"><i class="icon-bill"></i></div>
                            <div class="title"><span>New<br>Invoices</span>
                                <div class="progress">
                                    <div role="progressbar" style="width: 25%; height: 4px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-green"></div>
                                </div>
                            </div>
                            <div class="number"><strong>44</strong></div>
                        </div>
                    </div>
                    <!-- Item -->
                    <div class="col-xl-3 col-sm-6">
                        <div class="item d-flex align-items-center">
                            <div class="icon bg-orange"><i class="icon-check"></i></div>
                            <div class="title"><span>Open<br>Cases</span>
                                <div class="progress">
                                    <div role="progressbar" style="width: 25%; height: 4px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" class="progress-bar bg-orange"></div>
                                </div>
                            </div>
                            <div class="number"><strong>35</strong></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>




        <!-- Dashboard Header Section    -->
        <section class="dashboard-header">
            <div class="container-fluid">
                <div class="row">
                    <!-- Statistics -->
                    <div class="statistics col-lg-3 col-12">
                        <div class="statistic d-flex align-items-center bg-white has-shadow">
                            <div class="icon bg-red"><i class="fa fa-tasks"></i></div>
                            <div class="text"><strong>234</strong><br><small>Applications</small></div>
                        </div>
                        <div class="statistic d-flex align-items-center bg-white has-shadow">
                            <div class="icon bg-green"><i class="fa fa-calendar-o"></i></div>
                            <div class="text"><strong>152</strong><br><small>Interviews</small></div>
                        </div>
                        <div class="statistic d-flex align-items-center bg-white has-shadow">
                            <div class="icon bg-orange"><i class="fa fa-paper-plane-o"></i></div>
                            <div class="text"><strong>147</strong><br><small>Forwards</small></div>
                        </div>
                    </div>
                    <!-- Line Chart            -->
                    <div class="chart col-lg-6 col-12">
                        <div class="line-chart bg-white d-flex align-items-center justify-content-center has-shadow">
                            <canvas id="lineCahrt"></canvas>
                        </div>
                    </div>
                    <div class="chart col-lg-3 col-12">
                        <!-- Bar Chart   -->
                        <div class="bar-chart has-shadow bg-white">
                            <div class="title"><strong class="text-violet">95%</strong><br><small>Current Server Uptime</small></div>
                            <canvas id="barChartHome"></canvas>
                        </div>
                        <!-- Numbers-->
                        <div class="statistic d-flex align-items-center bg-white has-shadow">
                            <div class="icon bg-green"><i class="fa fa-line-chart"></i></div>
                            <div class="text"><strong>99.9%</strong><br><small>Success Rate</small></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    @endsection