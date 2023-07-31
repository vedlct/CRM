@extends('main')

@section('header')

    <link href="{{url('css/select2.min.css')}}" rel="stylesheet" />
@endsection

@section('content')

    @php($userType = Session::get('userType'))

    <div class="card" style="padding:10px;">
        <div class="card-body">
            <div class="row">
            <form class="form-control" action="{{route('storeLead')}}" method="POST">

                <div class="container-fluid">
                    <div class="row">
                        {{csrf_field()}}

                        <div class="form-group col-md-4">
                            <label class="control-label " ><b>Company Name</b></label>
                            <span id="exceedcompany" style="color:red;display: none"><i>This Company Name already exist</i></span></label>
                            {!! $errors->first('companyName', '<p class="help-block">:message</p>') !!}

                            <input type="text" class="form-control companyNamecheck" id="" placeholder="Enter Company Name" name="companyName" required>

                        </div>

                        <div class="form-group col-md-4">
                            <label class="control-label"><b>Website</b></label>
                            <span id="exceedwebsite" style="color:red;display: none"><i>This Website already exists</i></span>
                            {!! $errors->first('website', '<p class="help-block">:message</p>') !!}
                            <input type="text" class="form-control websitecheck" name="website" placeholder="Enter url" id="fullWebsite">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="form-group col-md-4">
                            <label class="control-label" ><b>Contact Number</b></label>
                            <span id="exceed" style="color:red;display: none"><i>This number already exist</i></span></label>
                            {!! $errors->first('personNumber', '<p class="help-block">:message</p>') !!}
                            <input type="text" class="form-control numbercheck" id="personNumber" name="personNumber" placeholder="Enter Phone Number" required>
                        </div>


                        <div class="form-group col-md-4">
                            <label class="control-label" ><b>Company Email:</b></label>
                            {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                            <input type="email" class="form-control" name="email" id="email" placeholder="Enter email">

                        </div>

                        <div class="form-group col-md-4" style="">
                            <label class="control-label" ><b>Linkedin Profile</b></label>
                            {!! $errors->first('linkedin', '<p class="help-block">:message</p>') !!}
                            <input type="text" class="form-control" id="" name="linkedin" placeholder="Company LinkedIn Profile" >

                        </div>

                        <div class="form-group col-md-4" style="">
                            <label class="control-label" ><b>Founded</b></label>
                            {!! $errors->first('founded', '<p class="help-block">:message</p>') !!}
                            <input type="text" class="form-control" id="" name="founded" placeholder="Founding Year" >
                        </div>



                        <div class="form-group col-md-4">

                            <label for="sel1"><b>Country:</b></label>
                            <select class="select form-control" id="" name="country" style="width: 100%;">
                                @foreach($countries as $c)
                                    <option value="{{$c->countryId}}">{{$c->countryName}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4" style="">
                            <label ><b>Category:</b></label>
                            <select class="form-control" id="" name="category" >
                                @foreach($categories as $cat)
                                    <option value="{{$cat->categoryId}}">{{$cat->categoryName}}</option>

                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-4" style="">
                            <label class="control-label" ><b>Employee Size</b></label>
                            {!! $errors->first('employee', '<p class="help-block">:message</p>') !!}
                            <input type="text" class="form-control" id="" name="employee" placeholder="Only Number of employees" >
                            <br>
                        </div>




                        <div class="form-group col-md-4" style="">
                            <label class="control-label" ><b>Current Process</b></label>
                            {!! $errors->first('process', '<p class="help-block">:message</p>') !!}
                            <input type="text" class="form-control" id="" name="process" placeholder="In house, Outsourcing, Agency" >

                        </div>

                        <div class="form-group col-md-4" style="">
                            <label class="control-label" ><b>File Volume</b></label>
                            {!! $errors->first('volume', '<p class="help-block">:message</p>') !!}
                            <input type="text" class="form-control" id="" name="volume" placeholder="Only number of images per Frequency" >

                        </div>

                        <div class="form-group col-md-4" style="">
                            <label class="control-label" ><b>Frequency</b></label>
                            {!! $errors->first('frequency', '<p class="help-block">:message</p>') !!}
                            <input type="text" class="form-control" id="" name="frequency" placeholder="Weekly, Monthly, Quarterly, Yearly" >
                        <br>
                        </div>


                        <div class="form-group col-md-4" style="">
                            <label ><b>Possibility:</b></label>
                            <select class="form-control" id="" name="possibility">
                                @foreach($possibilities as $possibility)
                                    <!-- <option value="{{$possibility->possibilityId}}">{{$possibility->possibilityName}}</option> -->
                                    <option value="{{$possibility->possibilityId}}" @if($possibility->possibilityId === 2) selected @endif>{{$possibility->possibilityName}}</option>

                                @endforeach
                            </select>

                        </div>


                        <div class="form-group col-md-8">
                            <label class="control-label " ><b>Extra Information</b></label>

                            {!! $errors->first('comment', '<p class="help-block">:message</p>') !!}

                            {{--<input type="text" class="form-control" id="" placeholder="Enter Comment" name="comment" required>--}}

                            <textarea name="comment" rows="4"  class="form-control">


                            </textarea>
                        </div>


                        <button type="submit" class="btn btn-success btn-md" style="width: 30%; margin-left: 20px;">Save New Lead</button>

                    </div></div>


            </form>

            </div>
        </div>
        </div>





@endsection




@section('bottom')




    <script src="{{url('js/select2.min.js')}}"></script>
    <script src="{{url('assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js')}}"></script>
    <script src="{{url('cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />


    <script>

        $(document).ready(function() {
            $('.select').select2();
        });

        function chkValidate() {


            var phone= document.getElementById('personNumber').value;
            var phoneReg = /^[\0-9\-\(\)\s]*$/;

            if (!phone.match(phoneReg)){
                alert(" please validate phone number");
                return false;
            }
            return true;

        }


        $('.numbercheck').bind('input propertychange',function(){
            var number = $('.numbercheck').val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type:'post',
                url:'{{route('numberCheck')}}',
                data:{_token: CSRF_TOKEN,'number':number},
                success : function(data)
                {

                    if(data >0)
                    {
                        document.getElementById('exceed').style.display="inline";
                    }
                    else
                    {
                        document.getElementById('exceed').style.display="none";
                    }
                }
            });
        });

        $('.websitecheck').bind('input propertychange',function(){
            var website = $('.websitecheck').val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type:'post',
                url:'{{route('websiteCheck')}}',
                data:{_token: CSRF_TOKEN,'website':website},
                success : function(data)
                {

                    if(data >0)
                    {
                        document.getElementById('exceedwebsite').style.display="inline";
                    }
                    else
                    {
                        document.getElementById('exceedwebsite').style.display="none";
                    }
                }
            });
        });

        $('.companyNamecheck').bind('input propertychange',function(){
            var companyName = $('.companyNamecheck').val();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type:'post',
                url:'{{route('comapanyNameCheck')}}',
                data:{_token: CSRF_TOKEN,'companyName':companyName},
                success : function(data)
                {

                    if(data >0)
                    {
                        document.getElementById('exceedcompany').style.display="inline";
                    }
                    else
                    {
                        document.getElementById('exceedcompany').style.display="none";
                    }
                }
            });
        });

   
    $(document).ready(function() {
        $('#fullWebsite').on('blur', function() {
            validateWebsiteField();
        });
    });

    function validateWebsiteField() {
        var websiteInput = $('#fullWebsite');
        var websiteValue = websiteInput.val().trim();
        var websiteRegex = /^(https?:\/\/(www\.)?)?([a-zA-Z0-9_-]+\.)*[a-zA-Z0-9_-]+\.[a-zA-Z]{2,}(\/.*)?$/;

        console.log('Website value:', websiteValue); // Add this log to see the website value
        console.log('Matches regex:', websiteRegex.test(websiteValue)); // Add this log to check the regex match

        // Check if the website field doesn't match the regex or starts with "http://" or "https://" or "www."
        if (websiteValue !== '' && (!websiteRegex.test(websiteValue) || !/^(https?:\/\/|www\.)/i.test(websiteValue))) {
            websiteInput.addClass('is-invalid');
            websiteInput.next('.invalid-feedback').text('Please enter a valid website URL with http:// or https:// or www.');
        } else {
            websiteInput.removeClass('is-invalid');
            websiteInput.next('.invalid-feedback').text('');
        }
    }




</script>




@endsection
