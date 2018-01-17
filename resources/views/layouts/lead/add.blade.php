@extends('main')

@section('header')

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    @endsection

@section('content')

    <div class="card" style="padding-left: 10%;padding-right: 10%;padding-top: 2%;padding-bottom: 2%;">

        <h3>Insert Lead</h3>


        <form class="form-horizontal" action="{{route('storeLead')}}" method="POST" onsubmit="return chkValidate()">


            {{csrf_field()}}

            <div class="form-group">
                <label class="control-label " ><b>Company Name</b></label>

                {!! $errors->first('companyName', '<p class="help-block">:message</p>') !!}

                    <input type="text" class="form-control" id="" placeholder="Enter Company Name" name="companyName" required>

            </div>


            <div class="form-group">
                <label class="control-label" ><b>Website</b></label>
                {!! $errors->first('website', '<p class="help-block">:message</p>') !!}
                    <input type="text" class="form-control" name="website" placeholder="Enter url" required>

            </div>


            <div class="form-group">
                <label class="control-label" ><b>Company Email:</b></label>
                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" required>

            </div>




            <div class="form-group" style="">

                <div style="width: 50%; float: left; padding-right: 10px;">
                <label ><b>Category:</b></label>
                <select class="form-control" id="" name="category">
                    @foreach($cats as $cat)
                        <option value="{{$cat->categoryId}}">{{$cat->categoryName}}</option>

                    @endforeach


                </select>

                </div>

                <div style="width: 50%; float:right; padding-left: 10px;">
                <label ><b>Possibility:</b></label>
                <select class="form-control" id="" name="possibility">
                   @foreach($pos as $p)
                        <option value="{{$p->possibilityId}}">{{$p->possibilityName}}</option>

                       @endforeach
                </select>
                </div>

            </div>









            <div class="form-group" style="margin-top: 10%;">
                <label class="control-label" ><b>Contact Person</b></label>
                {!! $errors->first('personName', '<p class="help-block">:message</p>') !!}
                    <input type="text" class="form-control" id="" name="personName" placeholder="name" required>

            </div>






            <div class="form-group">
                <label class="control-label" ><b>Contact Person Number</b></label>
                {!! $errors->first('personNumber', '<p class="help-block">:message</p>') !!}
                    <input type="text" class="form-control" id="personNumber" name="personNumber" placeholder="Enter Phone Number" required>
            </div>





            <div class="form-group" style="width: 50%;height: auto;">
                <label for="sel1"><b>Country:</b></label>
                <select class="select form-control" id="" name="country">
                   @foreach($countries as $country)

                        <option value="{{$country->countryId}}">{{$country->countryName}}</option>

                       @endforeach
                </select>
            </div>





            <div class="form-group">
                <label class="control-label " ><b>Comments</b></label>

                {!! $errors->first('comment', '<p class="help-block">:message</p>') !!}

                    {{--<input type="text" class="form-control" id="" placeholder="Enter Comment" name="comment" required>--}}

                <textarea name="comment" rows="5" cols="10" class="form-control">


                </textarea>

            </div>

            <button type="submit" class="btn btn-success">Insert</button>

        </form>
    </div>






    @endsection




@section('bottom')

    {{--Using from https://select2.org/getting-started/basic-usage--}}


    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <script>

        $(document).ready(function() {
            $('.select').select2();
        });

        function chkValidate() {


            var phone= document.getElementById('personNumber').value;
            var phoneReg = /^[\+0-9\-\(\)\s]*$/;

            if (!phone.match(phoneReg)){
                alert(" please validate phone number");
                return false;
            }
            return true;





        }



    </script>


@endsection