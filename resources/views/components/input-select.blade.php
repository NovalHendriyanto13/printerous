<div class="col-sm-6">
	<div class="form-group mg-b-20">
		<label>
		{{isset($attr['label']) ? \Str::title($attr['label']) : \Str::title(\Str::of($attr['name'])->replace('_',' '))}}
		@if(isset($attr['required']) &&  $attr['required'] == true) 
		<span class="tx-danger">*</span>
		@endif
		</label>
	    <select class="form-control select2 @if(isset($attr['class'])) {{$attr['class']}} @endif" 
	    	name="{{$attr['name']}}" 
	    	id="{{\Str::lower($attr['name'])}}" 	    	
	    	@if(isset($attr['ajax-href'])) ajax-href="{{$attr['ajax-href']}}" @endif
	    	@if(isset($attr['ajax-to'])) ajax-to="{{$attr['ajax-to']}}" @endif
			@if($attr['disabled'] == true) disabled @endif>

			@if($attr['allowEmpty'])
			<option value=""> Select One </option>
			@endif
			@foreach($attr['options'] as $k=>$v)

			<option 
				value="{{ $k }}" 
				@if(isset($attr['value']) && $attr['value'] == $k) selected="true" @endif>{{ $v }}</option>
			@endforeach
	      
	    </select>

	    <x-alert class="alert-element mg-t-5" id="{{$attr['name']}}-errors"></x-alert>
	</div>
</div>