<form action="{{route('local.storeLead')}}" method="POST">
<div class="row">
        {{csrf_field()}}
    <input type="hidden" name="local_leadId" value="{{$lead->local_leadId}}">
        <br>
        <div class="form-group col-md-5">
            <label class="control-label " ><b>Lead Name</b></label>

            {!! $errors->first('leadName', '<p class="help-block">:message</p>') !!}

            <input type="text" class="form-control" id="" placeholder="Enter Company Name" name="leadName" value="{{$lead->leadName}}" required>
        </div>

        <div class="form-group col-md-5">
            <label class="control-label " ><b>Company Name</b></label>
            <select class="form-control" name="local_companyId" required>
                <option value="">Select Company</option>
                @foreach($companies as $company)
                    <option value="{{$company->local_companyId}}" @if($company->local_companyId == $lead->local_companyId) selected @endif>{{$company->companyName}}</option>
                @endforeach
            </select>
        </div>


        {{--<div class="form-group col-md-5">--}}
            {{--<label class="control-label" ><b>Website</b></label>--}}
            {{--{!! $errors->first('website', '<p class="help-block">:message</p>') !!}--}}
            {{--<input type="text" class="form-control" value="{{$lead->website}}" name="website" placeholder="Enter url" >--}}

        {{--</div>--}}

        {{--<div class="form-group col-md-5" style="">--}}
            {{--<label class="control-label" ><b>Contact Person</b></label>--}}
            {{--{!! $errors->first('personName', '<p class="help-block">:message</p>') !!}--}}
            {{--<input type="text" class="form-control" value="{{$lead->contactPerson}}" id="" name="personName" placeholder="name" >--}}

        {{--</div>--}}


        {{--<div class="form-group col-md-5">--}}
            {{--<label class="control-label" ><b> Email:</b></label>--}}
            {{--{!! $errors->first('email', '<p class="help-block">:message</p>') !!}--}}
            {{--<input type="email" class="form-control" value="{{$lead->email}}" name="email" id="email" placeholder="Enter email">--}}

        {{--</div>--}}

        {{--<div class="form-group col-md-5">--}}
            {{--<label class="control-label" ><b>Mobile Number</b></label>--}}
            {{--<span id="exceed" style="color:red;display: none"><i>This number already exist</i></span></label>--}}
            {{--{!! $errors->first('personNumber', '<p class="help-block">:message</p>') !!}--}}
            {{--<input type="text" class="form-control numbercheck" id="personNumber" value="{{$lead->mobile}}" name="mobile" placeholder="Enter Phone Number" required>--}}
        {{--</div>--}}

        {{--<div class="form-group col-md-5">--}}
            {{--<label class="control-label" ><b>Tnt Number</b></label>--}}

            {{--<input type="text" class="form-control numbercheck" id="personNumber" value="{{$lead->tnt}}" name="tnt" placeholder="Enter Phone Number" required>--}}
        {{--</div>--}}




        <div class="form-group col-md-5" style="">
            <label ><b>Category:</b></label>
            <select class="form-control" id="" name="category" >
                @foreach($categories as $cat)
                    <option value="{{$cat->categoryId}}" @if($lead->categoryId == $cat->categoryId) selected @endif>{{$cat->categoryName}}</option>

                @endforeach
            </select>
        </div>




        {{--<div class="form-group col-md-5">--}}

            {{--<label for="sel1"><b>Area:</b></label>--}}
            {{--<select class="form-control" id="" name="areaId" required>--}}
                {{--<option value="">Select Area</option>--}}
                {{--@foreach($areas as $area)--}}
                    {{--<option value="{{$area->areaId}}" @if($lead->areaId == $area->areaId) selected @endif>{{$area->areaName}}</option>--}}

                {{--@endforeach--}}
            {{--</select>--}}
        {{--</div>--}}

        {{--<div class="form-group col-md-5">--}}

            {{--<label for="sel1"><b>Address:</b></label>--}}
            {{--<textarea name="address" class="form-control">{{$lead->address}}</textarea>--}}
        {{--</div>--}}

        <div class="form-group col-md-5" style="">
            <label ><b>Possibility:</b></label>
            <select class="form-control" id="" name="possibility">
                @foreach($possibilities as $possibility)
                    <option value="{{$possibility->possibilityId}}" @if($lead->possibilityId == $possibility->possibilityId) selected @endif>{{$possibility->possibilityName}}</option>

                @endforeach
            </select>

        </div>

    <div class="form-group col-md-5">
        <label class="control-label " ><b>Bill</b></label>

        {!! $errors->first('leadName', '<p class="help-block">:message</p>') !!}

        <input type="text" class="form-control" id="" placeholder="Enter bill" name="bill" value="{{$lead->bill}}" required>
    </div>





        {{--<div class="form-group col-md-10">--}}
            {{--<label class="control-label " ><b>Comments</b></label>--}}

            {{--{!! $errors->first('comment', '<p class="help-block">:message</p>') !!}--}}

            {{--<textarea name="comment" rows="4"  class="form-control">{{$lead->comment}}--}}
            {{--</textarea>--}}
        {{--</div>--}}





    </div>
@php($tempCount=1)
    <div id="allServicesl" >
        <label ><b>Services:</b></label>
        @foreach($localServices as $ls)
        <div class="form-group col-md-6" style="" id="TextBoxDiv{{$tempCount}}">
            <select class="form-control"  name="services[]" required>
                <option value="">Select service</option>
                @foreach($services as $service)
                    <option value="{{$service->local_serviceId}}" @if($ls->serviceId ==$service->local_serviceId ) selected @endif>{{$service->serviceName}}</option>
                @endforeach
            </select>
        </div>
            @php($tempCount++)
        @endforeach

        @if($localServices->isEmpty())
            <div class="form-group col-md-6" id="" style="" >
                <select class="form-control"  name="services[]" required>
                    <option value="">Select service</option>
                    @foreach($services as $service)
                        <option value="{{$service->local_serviceId}}">{{$service->serviceName}}</option>
                    @endforeach
                </select>
            </div>

        @endif

    </div>

    <button type="button" id="addButton" class="btn btn-info" onclick="addmore()">add more</button>
    <button type="button" id="removeButton" class="btn btn-danger"  onclick="remove()">remove</button>

    <button type="submit" class="btn btn-success btn-md" style="width: 30%; margin-left: 20px;">Edit</button>


</form>


<script>
    var counter = 2;
    var arr=[];
    @if(!$localServices->isEmpty())
        var counter="{{count($localServices)+1}}";

    @endif

$(document).ready(function(){



        var i;


        @foreach($services as $service)
            arr.push('<option id="s'+i+'" value="{{$service->local_serviceId}}">{{$service->serviceName}}</option>');
        @endforeach


//        var counter = 2;



//        $("#addButton").click(function () {
//
//
//        });

        function serviceSelected(x){
            console.log(x);

        }
    });
    function addmore() {
        if(counter>10){
            alert("Only 10 textboxes allow");
            return false;
        }

        var newTextBoxDiv = $(document.createElement('div'))
            .attr("id", 'TextBoxDiv' + counter).attr("class", 'row');

        newTextBoxDiv.after().html('<div class="form-group col-md-6" > ' +
            '<select class="form-control" id="" name="services[]" required>' +
            '<option value="">Select service</option>'+
            arr+
            '</select> ' +
            '</div>'
        );
        newTextBoxDiv.appendTo("#allServicesl");
        counter++;
    }

    function remove() {
        if(counter==2){
            alert("nothing to remove");
            return false;
        }
        counter--;
        $("#TextBoxDiv" + counter).remove();
    }

</script>