<h4 align="center">Add Company</h4>
<form method="post" action="{{route('local.addCompany')}}">
    {{csrf_field()}}
    <input type="hidden" name="local_companyId" value="{{$company->local_companyId}}">
    <div class="row">
        <div class="form-group col-md-4">
            <label>Company Name</label>
            <input class="form-control" name="companyName" value="{{$company->companyName}}" placeholder="name">
        </div>

        <div class="form-group col-md-4">
            <label>Website</label>
            <input class="form-control" name="website" value="{{$company->website}}" placeholder="www">
        </div>

        <div class="form-group col-md-4">
            <label>Contact Person</label>
            <input class="form-control" name="contactPerson" value="{{$company->contactPerson}}" placeholder="person name">
        </div>

        <div class="form-group col-md-4">
            <label>Email</label>
            <input class="form-control" name="email" value="{{$company->email}}" placeholder="email">
        </div>

        <div class="form-group col-md-4">
            <label>Contact Number</label>
            <input class="form-control" name="mobile" value="{{$company->mobile}}" placeholder="mobile">
        </div>




        <div class="form-group col-md-4">
            <label>Tnt Number</label>
            <input class="form-control" name="tnt" value="{{$company->tnt}}" placeholder="tnt">
        </div>


        <div class="form-group col-md-4">
            <label>Area</label>
            <select class="form-control" name="areaId" required>
                <option value="">Select Area</option>
                @foreach($areas as $area)
                    <option value="{{$area->areaId}}" @if($area->areaId == $company->areaId) selected @endif>{{$area->areaName}}</option>
                @endforeach
            </select>

        </div>

        <div class="form-group col-md-4">
            <label>Address</label>
            <textarea class="form-control" name="address" placeholder="address..." rows="5">{{$company->address}}</textarea>
        </div>



        <div class="col-md-12">
            <button class="btn btn-success">update</button>
        </div>

    </div>
</form>

