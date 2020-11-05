<div class="col-sm-6">
	<div class="form-group mg-b-20">
		<label class="" for="{{\Str::lower($attr['name'])}}">
	  	{{isset($attr['label']) ? \Str::title($attr['label']) : \Str::title(\Str::of($attr['name'])->replace('_',' '))}}
		@if(isset($attr['required']) &&  $attr['required'] == true) 
		<span class="tx-danger">*</span>
		@endif
	  </label>
	  @foreach($attr['options'] as $opt)
		<div class="custom-control custom-checkbox">
		  <input type="checkbox" 
		  	class="{{isset($attr['class']) ? $attr['class'] : ''}}" 
		  	id="{{\Str::lower($attr['name'])}}"
		  	value="{{$opt}}"
		  	@if($attr['value'] == $opt) ? 'checked' : '' @endif
		  > {{$opt}}
		</div>
		@endforeach
	</div>
</div>