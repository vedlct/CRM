@extends('main')

@section('content')
<br>


<div style="text-align: center;" class="modal" id="editLeadModal" >
    <div class="modal-dialog" style="max-width: 60%;">
        <div class="modal-content" >
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Payment</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body" id="">
                <div id="editLeadModalBody">



                </div>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>




<div class="card">
    <div class="card-header">
        <div class="form-group col-md-4">
            <select class="form-control" id="companyId" onchange="getLeadFromCompany()">
                <option value="">Select Company</option>
                @foreach($companies as $company)
                    <option value="{{$company->local_companyId}}">{{$company->companyName}}</option>
                @endforeach
            </select>

        </div>

    </div>

    <div class="card-body">

        <div class="table-responsive m-t-40">
            <table id="myTable" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th width="20%">Lead Name</th>
                    <th width="20%">Company Name</th>
                    <th width="15%">website</th>
                    <th width="15%">Number</th>
                    <th width="15%">Tnt Number</th>
                    <th width="10%">Category</th>
                    {{--<th width="5%">Status</th>--}}
                    <th width="10%">Action</th>

                </tr>
                </thead>
                <tbody>



                </tbody>
            </table>
        </div>




    </div>


</div>




@endsection
@section('bottom')
    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>
  <script>
      $(function() {
       table= $('#myTable').DataTable({
              processing: true,
              serverSide: true,
              stateSave: true,
              Filter: true,
              type:"POST",
              "ajax":{
                  "url": "{!! route('local.getSalesLead') !!}",
                  "type": "POST",
                  data:function (d){
                      d._token="{{csrf_token()}}";

                      d.companyId=$('#companyId').val();

                  }
              },
              columns: [
                  { data: 'leadName', name: 'leadName' },
                  { data: 'companyName', name: 'companyName' },
                  { data: 'website', name: 'website' },
                  { data: 'mobile', name: 'mobile'},
                  { data: 'tnt', name: 'tnt'},
                  { data: 'categoryName', name: 'categoryName'},
                  { "data": function(data){

                      return '<a class="btn btn-default btn-sm" data-panel-id="'+data.local_leadId+'" onclick="showPaymentModal(this)"><i class="fa fa-shopping-cart"></i></a>'
                          ;},
                      "orderable": false, "searchable":false, "name":"selected_rows" },
              ]
          });
      });
      function getLeadFromCompany(){

          table.ajax.reload();

      }

      function showPaymentModal(x) {
          var leadId=$(x).data('panel-id');


          $.ajax({
              type: 'POST',
              url: "{!! route('local.getPaymentInfo') !!}",
              cache: false,
              data: {_token: "{{csrf_token()}}",'leadId': leadId},
              success: function (data) {
                  $("#editLeadModalBody").html(data);
                  $("#editLeadModal").modal();
              }
          });

      }


  </script>



@endsection