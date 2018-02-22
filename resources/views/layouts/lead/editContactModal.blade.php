@foreach($leads as $lead)
<form  method="post" action="{{route('leadUpdate')}}">
    {{csrf_field()}}
    <div class="row">
        <div class="col-md-12" align="center">
            <label><b> Mined By: </b></label>  <div class="mined" id="mined"></div>
        </div>
        <div class="col-md-4">
            <label><b>Category:</b></label>
            <select class="form-control"  name="category" id="category">
                <option value="">Please Select</option>
                @foreach($categories as $category)
                    <option value="{{$category->categoryId}}">{{$category->categoryName}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <input type="hidden" name="leadId">
            <label><b>Company Name:</b></label>
            <input type="text" class="form-control" name="companyName" value="{{$lead->companyName}}">
        </div>

        <div class="col-md-4">
            <label><b>Email:</b></label>
            <input type="email" class="form-control" name="email" value="{{$lead->email}}">
        </div>
        <div class="col-md-4">
            <label><b>Contact Person:</b></label>
            <input type="text" class="form-control" name="personName" value="{{$lead->personName}}">
        </div>
        <div class="col-md-4">
            <label><b>Number:</b></label>
            <input type="text" class="form-control" name="number" value="{{$lead->contactNumber}}">
        </div>
        <div class="col-md-4">
            <label><b>Website:</b></label>
            <input type="text" class="form-control" name="website" value="{{$lead->website}}">
        </div>

        <div class="col-md-4">
            <label><b>Designation:</b></label>
            <input type="text" class="form-control" name="designation" value="{{$lead->designation}}">
        </div>


        <div class="col-md-4">
            <label><b>Country:</b></label>
            <select class="form-control"  name="country" id="country">
                @foreach($country as $c)
                    <option value="{{$c->countryId}}">{{$c->countryName}}</option>
                @endforeach
            </select>
            <br><br><br>
        </div>


        <div class="col-md-4">
            <label><b>Follow up Date:</b></label>
            <input type="text" class="form-control" name="designation" value="{{$lead->fDate}}">
        </div>



        <div class="col-md-6">
            <button class="btn btn-success" type="submit">Update</button>
        </div>
    </div>
</form>
    @endforeach