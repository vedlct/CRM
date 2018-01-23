@extends('main')

@section('content')

    <!-- Page Header-->
    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Test List</h2>
        </div>
    </header>


    <div style="padding: 10px;">


        <table class="table table-hover" style="background-color:white; ">
            <thead>
            <tr>
                <th>Agent Name</th>
                <th>Company Name</th>
                <th>Category</th>
                <th>Possibilities</th>
                <th>Country</th>
                <th>Contact Person</th>
                <th>Web Address</th>
                <th>Details</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>John</td>
                <td>Doe</td>
                <td>Agency</td>
                <td>Star</td>
                <td>Bangladesh</td>
                <td>john@example.com</td>
                <td>gmail.com</td>
                <td><a href=""><i class="fa fa-plus-square-o" aria-hidden="true"></i></a></td>

            </tr>
            <tr>
                <td>John</td>
                <td>Doe</td>
                <td>Agency</td>
                <td>Star</td>
                <td>Bangladesh</td>
                <td>john@example.com</td>
                <td>gmail.com</td>
                <td><a href=""><i class="fa fa-plus-square-o" aria-hidden="true"></i></a></td>
            </tr>
            <tr>
                <td>John</td>
                <td>Doe</td>
                <td>Agency</td>
                <td>Star</td>
                <td>Bangladesh</td>
                <td>john@example.com</td>
                <td>gmail.com</td>
                <td><a href=""><i class="fa fa-plus-square-o" aria-hidden="true"></i></a></td>
            </tr>
            </tbody>
        </table>




    </div>


    <!-- Button to Open the Modal -->
    <a href="{{route('modal')}}" rel="modal" class="btn btn-success">Hello!</a>


    <div id="modal" class="modal fade"
         tabindex="-1" role="dialog" aria-labelledby="plan-info" aria-hidden="true">
        <div class="modal-dialog modal-full-screen">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close"
                            data-dismiss="modal" aria-hidden="true">
                        <span class="glyphicon glyphicon-remove-circle"></span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- /# content goes here -->
                    Loading...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>





@endsection
@section('foot-js')
<script>

    $('a[rel=modal]').on('click', function(evt) {
        evt.preventDefault();
        var modal = $('#modal').modal();
        modal
            .find('.modal-body')
            .load($(this).attr('href'), function (responseText, textStatus) {
                if ( textStatus === 'success' ||
                    textStatus === 'notmodified')
                {
                    modal.show();
                }
            });
    });

</script>

    @endsection