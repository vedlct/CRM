@extends('main')

@section('content')

<style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f4f7f9;
        margin: 20px;
    }

    h1 {
        text-align: center;
        font-size: 2.5rem;
        color: #333;
        padding: 50px 0;
    }

    .card {
        border: none;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        background-color: #fff;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .card-title {
        background-color: #f8f9fa;
        padding: 15px;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        margin-bottom: 0;
        font-size: 1.25rem;
        font-weight: bold;
    }

    .badge {
        font-size: 0.9rem;
        padding: 5px 10px;
    }

    .card-body {
        padding: 20px;
    }

    .list-group-item {
        border: none;
        padding: 10px 15px;
        font-size: 1rem;
        color: #555;
        background-color: #fff;
    }

    .list-group-item:hover {
        background-color: #f1f1f1;
    }

    .change-log-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .change-log-card {
        flex: 1 1 calc(33.333% - 20px);
        min-width: 300px;
    }

    @media (max-width: 768px) {
        .change-log-card {
            flex: 1 1 calc(50% - 20px);
        }
    }

    @media (max-width: 480px) {
        .change-log-card {
            flex: 1 1 100%;
        }
    }
</style>

<h1>Change Logs</h1>



<div class="change-log-container">
    <div class="card change-log-card">
        <div class="card-title">
            <span class="badge badge-info">2.18.00</span> - 21 July 2024
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">New - Added Not Interested Leads in the Analysis Home</li>
            </ul>
        </div>
    </div>


<div class="change-log-container">
    <div class="card change-log-card">
        <div class="card-title">
            <span class="badge badge-success">2.17.00</span> - 20 July 2024
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Updated - Added date function in the Filter Leads</li>
            </ul>
        </div>
    </div>

    <div class="card change-log-card">
        <div class="card-title">
            <span class="badge badge-warning">2.16.00</span> - 16 July 2024
        </div>
        <div class="card-body">
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Updated - Added revenue column in the Revenue page</li>
                <li class="list-group-item">Updated - Added whitelist column in the User page</li>
            </ul>
        </div>
    </div>




    <div class="card change-log-card">
            <div class="card-title">
                <span class="badge badge-warning">2.15.00</span> - 28 June 2024
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Updated - Dashboard Target vs Achievement - Removed Followup, Added Contact</li>
                    <li class="list-group-item">Updated - Dashboard Chart - updated as per new target</li>
                </ul>
            </div>
        </div>

        <div class="card change-log-card">
            <div class="card-title">
                <span class="badge badge-warning">2.15.00</span> - 07 May 2024
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Updated - Added filters in the All Free Trail pages to find the test leads easily.</li>
                </ul>
            </div>
        </div>

        <div class="card change-log-card">
            <div class="card-title">
                <span class="badge badge-warning">2.14.02</span> - 16 April 2024
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Added - Role in the User Management table</li>
                </ul>
            </div>
        </div>

        <div class="card change-log-card">
            <div class="card-title">
                <span class="badge badge-warning">2.14.01</span> - 03 April 2024
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Bug Fixing - Free Trial Page</li>
                </ul>
            </div>
        </div>

        <div class="card change-log-card">
            <div class="card-title">
                <span class="badge badge-success">2.14.00</span> - 01 April 2024
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">New Feature - Test Leads have a new look now. Added a table so that user and admin can update the test leads</li>
                </ul>
            </div>
        </div>

        <div class="card change-log-card">
            <div class="card-title">
                <span class="badge badge-info">2.13.00</span> - 15 February 2024
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">New Feature - Added Test Leads that are not closed yet</li>
                    <li class="list-group-item">New Feature - Added Revenue page to enter revenue details</li>
                    <li class="list-group-item">Bug Fixed - Managers can assign leads from Assign Filtered Leads</li>
                </ul>
            </div>
        </div>

        <div class="card change-log-card">
            <div class="card-title">
                <span class="badge badge-success">2.12.00</span> - 15 November 2023
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">New Feature - Added new Filter Leads option where users can see the date of last comment of filtered leads.</li>
                </ul>
            </div>
        </div>

        <div class="card change-log-card">
            <div class="card-title">
                <span class="badge badge-success">2.11.00</span> - 30 October 2023
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Update - Personal analysis for all users</li>
                </ul>
            </div>
        </div>

        <div class="card change-log-card">
            <div class="card-title">
                <span class="badge badge-info">2.10.00</span> - 11 October 2023
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">New Feature - Added assign to on Long Time No See page for Supervisor</li>
                    <li class="list-group-item">Bug Fixing - Change logs</li>
                </ul>
            </div>
        </div>

        <div class="card change-log-card">
            <div class="card-title">
                <span class="badge badge-info">2.10.00</span> - 11 October 2023
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">New Feature - Now we get the leads where we forget to set Followup</li>
                    <li class="list-group-item">Bug Fixing - Update personal analysis to remove total contact</li>
                </ul>
            </div>
        </div>

        <div class="card change-log-card">
            <div class="card-title">
                <span class="badge badge-warning">2.09.02</span> - 09 October 2023
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Bug Fixing - Personal Analysis Long Time No Chase</li>
                </ul>
            </div>
        </div>

        <div class="card change-log-card">
            <div class="card-title">
                <span class="badge badge-warning">2.09.01</span> - 03 October 2023
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Bug Fixing - Lead Status on My Lead</li>
                    <li class="list-group-item">Bug Fixing - Set 20+ follow up on Followup page</li>
                </ul>
            </div>
        </div>

        <div class="card change-log-card">
            <div class="card-title">
                <span class="badge badge-info">2.09.00</span> - 25 September 2023
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">New Feature - Personal Analysis</li>
                    <li class="list-group-item">New Feature - Last Working Day Report</li>
                    <li class="list-group-item">Bug Fixing - Increase the daily followup number to 30</li>
                    <li class="list-group-item">Bug Fixing - Can update the user's target for any month</li>
                </ul>
            </div>
        </div>

        <div class="card change-log-card">
            <div class="card-title">
                <span class="badge badge-info">2.08.00</span> - 19 September 2023
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">New Feature - Add User Profile</li>
                    <li class="list-group-item">New Feature - Untouched leads - accessed by supervisors</li>
                </ul>
            </div>
        </div>

        <div class="card change-log-card">
            <div class="card-title">
                <span class="badge badge-warning">2.07.01</span> - 15 September 2023
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Bug Fixing - Parent Company. Made the page loading faster</li>
                    <li class="list-group-item">Bug Fixing - Followup analysis</li>
                </ul>
            </div>
        </div>

        <div class="card change-log-card">
            <div class="card-title">
                <span class="badge badge-info">2.07.00</span> - 12 September 2023
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">New Feature - Add more random reports</li>
                    <li class="list-group-item">New Feature - Graphical Presentations in Analysis</li>
                    <li class="list-group-item">Bug Fixing - Follow up Analysis</li>
                </ul>
            </div>
        </div>

        <div class="card change-log-card">
            <div class="card-title">
                <span class="badge badge-info">2.06.00</span> - 4 September 2023
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">New Feature - Managers and Supervisors can set the Parent company for sub brands</li>
                    <li class="list-group-item">New Feature - Upon set, users can see if current lead is a parent company or actually is a sub brand of another company</li>
                    <li class="list-group-item">New Feature - Introduced follow up analysis</li>
                    <li class="list-group-item">Bug Fixing - Fixed the My Lead Dashboard page loading issues</li>
                </ul>
            </div>
        </div>

        <div class="card change-log-card">
            <div class="card-body">
                <h5 class="card-title">
                    <span class="badge badge-info">2.05.00</span> - 25 August 2023
                </h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">New Feature - Now supervisors and admins can see the existing Individual Messages that are not read yet by the users.</li>
                    <li class="list-group-item">Bug Fixed - Sales pipeline report on Random Report All.</li>
                    <li class="list-group-item">New Feature - Users can update joining date now.</li>
                </ul>
            </div>
        </div>

        <div class="card change-log-card">
            <div class="card-body">
                <h5 class="card-title">
                    <span class="badge badge-info">2.04.00</span> - 23 August 2023
                </h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">New Feature - Individual Message to the user via Database.</li>
                    <li class="list-group-item">New Feature - Removed Left Side Bar and added Top Bar.</li>
                </ul>
            </div>
        </div>

        <div class="card change-log-card">
            <div class="card-body">
                <h5 class="card-title">
                    <span class="badge badge-info">2.03.00</span> - 21 August 2023
                </h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">New Feature - Excel Download button on Ipp List.</li>
                    <li class="list-group-item">New Feature - Random Reports All - Sales Pipeline Report Table.</li>
                    <li class="list-group-item">Bug Fixed - All Conversations.</li>
                </ul>
            </div>
        </div>

        <div class="card change-log-card">
            <div class="card-body">
                <h5 class="card-title">
                    <span class="badge badge-info">2.02.00</span> - 9 August 2023
                </h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">New Feature - New Top Bar.</li>
                    <li class="list-group-item">Updated - Random Reports with chasing categories and random statistics.</li>
                    <li class="list-group-item">Bug Fixed - Account View.</li>
                </ul>
            </div>
        </div>

        <div class="card change-log-card">
            <div class="card-body">
                <h5 class="card-title">
                    <span class="badge badge-info">2.01.01</span> - 3 August 2023
                </h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Bug Fixed - contactedUserId will be Null if supervisors filter the lead.</li>
                    <li class="list-group-item">CSS Fixed - Top Bar.</li>
                    <li class="list-group-item">Added a graph in the Target vs Achievement Report.</li>
                </ul>
            </div>
        </div>

        <div class="card change-log-card">
            <div class="card-body">
                <h5 class="card-title">
                    <span class="badge badge-info">2.01.00</span> - 2 August 2023
                </h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">New Feature - Target Vs Achievement of full team for Admin and Managers.</li>
                    <li class="list-group-item">Added a new alert box on Assign Lead pages.</li>
                </ul>
            </div>
        </div>

        <div class="card change-log-card">
            <div class="card-body">
                <h5 class="card-title">
                    <span class="badge badge-info">2.0.01</span> - 1 August 2023
                </h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Added Remove Employee button on Employee table.</li>
                    <li class="list-group-item">Bug Fixed - Account View.</li>
                    <li class="list-group-item">Converted tables into Server Side.</li>
                </ul>
            </div>
        </div>

        <div class="card change-log-card">
            <div class="card-body">
                <h5 class="card-title">
                    <span class="badge badge-info">2.0</span> - 26 July 2023
                </h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Launched new version of CRM with a new look.</li>
                    <li class="list-group-item">Bug Fixed - User Profile.</li>
                </ul>
            </div>
        </div>
        

</div>

@endsection

@section('foot-js')
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
@endsection
