@extends('main')

@section('content')

<div class="card" style="padding:10px;">
        <div class="card-body">
        <h2 class="card-title" align="center"><b>List of Keywords</b></h2>

            <div class="table-responsive m-t-40">
                <table id="keywordTable" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>English</th>
                        <th>Germany </th>
                        <th>Itlian </th>
                        <th >Spanish </th>
                        <th >Dutch </th>
                        <th >Danish </th>
                        <th >Swedish</th>
                        <th >Action</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($keywords as $keyword)
                        <tr>
                            <td >{{$keyword->english}}</td>
                            <td >{{$keyword->german}}</td>
                            <td >{{$keyword->italy}}</td>
                            <td >{{$keyword->spain}}</td>
                            <td >{{$keyword->netherlands}}</td>
                            <td >{{$keyword->denmark}}</td>
                            <td >{{$keyword->sweden}} 
                            </td>
                            <td >
                                <!-- Trigger the Edit modal with a button -->
                                <a href="#edit_modal" data-toggle="modal" class="btn btn-info btn-sm"
                                   data-keyword-id="{{$keyword->keywordId}}"
                                   data-keyword-english="{{$keyword->english}}"                                   
                                   data-keyword-german="{{$keyword->german}}"
                                   data-keyword-italy="{{$keyword->italy}}"
                                   data-keyword-spain="{{$keyword->spain}}"
                                   data-keyword-netherlands="{{$keyword->netherlands}}"
                                   data-keyword-denmark="{{$keyword->denmark}}"
                                   data-keyword-sweden="{{$keyword->sweden}}"
                                >
                                   <i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>

                            </td>

                        </tr>

                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>



    <!-- Edit Modal -->
    <div class="modal" id="edit_modal" style="">
        <div class="modal-dialog" style="max-width: 60%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title" name="modal-title">Edit Keyword</h4>
                </div>
                <div class="modal-body">
                    <form  method="post" action="{{route('updateKeyword')}}">
                        {{csrf_field()}}
                        <div class="row">

                            <div class="col-md-12">
                                <input type="hidden" name="keywordId">
                                <label><b>English:</b></label>
                                <input type="text" class="form-control" name="english" value="">
                                <br><br>
                            </div>

                            <div class="col-md-6">
                                <label><b>Germany</b></label>
                                <input type="text" class="form-control" name="german" value="">
                                <br><br>
                            </div>

                            <div class="col-md-6">
                                <label><b>Italian</b></label>
                                <input type="text" class="form-control" name="italy" value="">
                                <br><br>
                            </div>

                            <div class="col-md-6">
                                <label><b>Spanish</b></label>
                                <input type="text" class="form-control" name="spain" value="">
                                <br><br>
                            </div>

                            <div class="col-md-6">
                                <label><b>Dutch</b></label>
                                <input type="text" class="form-control" name="netherlands" value="">
                                <br><br>
                            </div>

                            <div class="col-md-6">
                                <label><b>Danish</b></label>
                                <input type="text" class="form-control" name="denmark" value="">
                                <br><br>
                            </div>

                            <div class="col-md-6">
                                <label><b>Swedish</b></label>
                                <input type="text" class="form-control" name="sweden" value="">
                                <br><br>
                            </div>

                            <div class="col-md-6">
                                <button class="btn btn-success" type="submit">Update</button>
                            </div>
                        </div>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

<script>
    $(document).ready(function() {
            $('#keywordTable').DataTable({
                "processing": true,
                stateSave: true,
            });

        });


        $('#edit_modal').on('show.bs.modal', function(e) {
//            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var keywordId = $(e.relatedTarget).data('keyword-id');
            var english = $(e.relatedTarget).data('keyword-english');
            var german = $(e.relatedTarget).data('keyword-german');
            var italy = $(e.relatedTarget).data('keyword-italy');
            var spain = $(e.relatedTarget).data('keyword-spain');
            var netherlands = $(e.relatedTarget).data('keyword-netherlands');
            var denmark=$(e.relatedTarget).data('keyword-denmark');
            var sweden=$(e.relatedTarget).data('keyword-sweden');

            $(e.currentTarget).find('input[name="keywordId"]').val(keywordId);
            $(e.currentTarget).find('input[name="english"]').val(english);
            $(e.currentTarget).find('input[name="german"]').val(german);
            $(e.currentTarget).find('input[name="italy"]').val(italy);
            $(e.currentTarget).find('input[name="spain"]').val(spain);
            $(e.currentTarget).find('input[name="netherlands"]').val(netherlands);
            $(e.currentTarget).find('input[name="denmark"]').val(denmark);
            $(e.currentTarget).find('input[name="sweden"]').val(sweden);

            @if(Auth::user()->typeId == 4 || Auth::user()->typeId == 5 )
            $(e.currentTarget).find('input[name="english"]').attr('readonly', true);
            //$(e.currentTarget).find('input[name="website"]').attr('readonly', true);
            @endif

        });


</script>

@endsection
