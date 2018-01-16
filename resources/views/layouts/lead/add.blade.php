@extends('main')



@section('content')

    <div class="card" style="padding-left: 10%;padding-right: 10%;padding-top: 2%;padding-bottom: 2%;">

        <h3>Insert Lead</h3>


        <form class="form-horizontal" action="{{route('storeLead')}}" method="POST">


            {{csrf_field()}}

            <div class="form-group">
                <label class="control-label " ><b>Company Name</b></label>

                {!! $errors->first('companyName', '<p class="help-block">:message</p>') !!}

                    <input type="text" class="form-control" id="" placeholder="Enter Company Name" name="companyName" >

            </div>


            <div class="form-group">
                <label class="control-label" ><b>Website</b></label>
                {!! $errors->first('website', '<p class="help-block">:message</p>') !!}
                    <input type="text" class="form-control" name="website" placeholder="Enter url" >

            </div>


            <div class="form-group">
                <label class="control-label" ><b>Company Email:</b></label>
                {!! $errors->first('email', '<p class="help-block">:message</p>') !!}
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" >

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
                    <input type="text" class="form-control" id="" name="personName" placeholder="name" >

            </div>






            <div class="form-group">
                <label class="control-label" ><b>Contact Person Number</b></label>
                {!! $errors->first('personNumber', '<p class="help-block">:message</p>') !!}
                    <input type="text" class="form-control" id="" name="personNumber" placeholder="Enter Phone Number" >

            </div>





            <div class="form-group" style="width: 40%">
                <label for="sel1"><b>Country:</b></label>
                <select class="form-control select" id="" name="country">
                   @foreach($countries as $country)

                        <option value="{{$country->countryId}}">{{$country->countryName}}</option>

                       @endforeach
                </select>
            </div>





            <div class="form-group">
                <label class="control-label " ><b>Comments</b></label>

                {!! $errors->first('comment', '<p class="help-block">:message</p>') !!}

                    <input type="text" class="form-control" id="" placeholder="Enter Comment" name="comment" >

            </div>

            <button type="submit" class="btn btn-success">Insert</button>

        </form>
    </div>






    @endsection




@section('bottom')

    {{--Using from https://select2.org/getting-started/basic-usage--}}

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <script>

        $(document).ready(function() {
            $('.select').select2();
        });


    </script>
@endsection