<form action="{{route('local.storeLead')}}" method="POST">
<div class="row">
        {{csrf_field()}}
    <input type="hidden" name="local_leadId" value="{{$lead->local_leadId}}">
        <br>
        <div class="form-group col-md-5">
            <label class="control-label " ><b>Company Name</b></label>

            {!! $errors->first('companyName', '<p class="help-block">:message</p>') !!}

            <input type="text" class="form-control" id="" placeholder="Enter Company Name" name="companyName" value="{{$lead->companyName}}" required>
        </div>


        <div class="form-group col-md-5">
            <label class="control-label" ><b>Website</b></label>
            {!! $errors->first('website', '<p class="help-block">:message</p>') !!}
            <input type="text" class="form-control" value="{{$lead->website}}" name="website" placeholder="Enter url" >

        </div>

        <div class="form-group col-md-5" style="">
            <label class="control-label" ><b>Contact Person</b></label>
            {!! $errors->first('personName', '<p class="help-block">:message</p>') !!}
            <input type="text" class="form-control" value="{{$lead->contactPerson}}" id="" name="personName" placeholder="name" >

        </div>


        <div class="form-group col-md-5">
            <label class="control-label" ><b> Email:</b></label>
            {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
            <input type="email" class="form-control" value="{{$lead->email}}" name="email" id="email" placeholder="Enter email">

        </div>

        <div class="form-group col-md-5">
            <label class="control-label" ><b>Mobile Number</b></label>
            <span id="exceed" style="color:red;display: none"><i>This number already exist</i></span></label>
            {!! $errors->first('personNumber', '<p class="help-block">:message</p>') !!}
            <input type="text" class="form-control numbercheck" id="personNumber" value="{{$lead->mobile}}" name="mobile" placeholder="Enter Phone Number" required>
        </div>

        <div class="form-group col-md-5">
            <label class="control-label" ><b>Tnt Number</b></label>

            <input type="text" class="form-control numbercheck" id="personNumber" value="{{$lead->tnt}}" name="tnt" placeholder="Enter Phone Number" required>
        </div>




        <div class="form-group col-md-5" style="">
            <label ><b>Category:</b></label>
            <select class="form-control" id="" name="category" >
                @foreach($categories as $cat)
                    <option value="{{$cat->categoryId}}" @if($lead->categoryId == $cat->categoryId) selected @endif>{{$cat->categoryName}}</option>

                @endforeach
            </select>
        </div>




        <div class="form-group col-md-5">

            <label for="sel1"><b>Area:</b></label>
            <select class="form-control" id="" name="areaId" required>
                <option value="">Select Area</option>
                @foreach($areas as $area)
                    <option value="{{$area->areaId}}" @if($lead->areaId == $area->areaId) selected @endif>{{$area->areaName}}</option>

                @endforeach
            </select>
        </div>

        <div class="form-group col-md-5">

            <label for="sel1"><b>Address:</b></label>
            <textarea name="address" class="form-control">{{$lead->address}}</textarea>
        </div>

        <div class="form-group col-md-5" style="">
            <label ><b>Possibility:</b></label>
            <select class="form-control" id="" name="possibility">
                @foreach($possibilities as $possibility)
                    <option value="{{$possibility->possibilityId}}" @if($lead->possibilityId == $possibility->possibilityId) selected @endif>{{$possibility->possibilityName}}</option>

                @endforeach
            </select>

        </div>





        <div class="form-group col-md-10">
            <label class="control-label " ><b>Comments</b></label>

            {!! $errors->first('comment', '<p class="help-block">:message</p>') !!}

            <textarea name="comment" rows="4"  class="form-control">{{$lead->comment}}
            </textarea>
        </div>


        <button type="submit" class="btn btn-success btn-md" style="width: 30%; margin-left: 20px;">Insert</button>

    </div>


</form>