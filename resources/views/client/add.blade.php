<h3 align="center">{{$lead->companyName}}</h3>
<hr>
<form method="post" action="{{route('clientLeads.insert')}}">

    {{csrf_field()}}
    <input type="hidden" value="{{$lead->leadId}}" name="id">
    <div class="form-group">
        <label>Files</label>
        <input type="number" placeholder="Total Files" name="files123">
    </div>
    <button class="btn btn-success" type="submit">Insert</button>
</form>
