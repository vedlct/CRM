<div style="display:inline-block; margin:15px;">
  @php
    $index = 0;
  @endphp
  @foreach ($items as $item)
          @php
            $stringFormat =  strtolower(str_replace(' ', '', $item));
          @endphp
		  
            <div class="input-group date">
                <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </div>
                <input type="text" value="{{isset($oldVals) ? $oldVals[$index] : ''}}" name="<?=$stringFormat?>" id="<?=$stringFormat?>" placeholder="{{$item}}" required>
            
  @php
    $index++;
  @endphp
  @endforeach
</div>