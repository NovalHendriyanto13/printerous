<div class="col-sm-6">
	<div class="form-group mg-b-20">
		<label>
		{{isset($attr['label']) ? \Str::title($attr['label']) : \Str::title(\Str::of($attr['name'])->replace('_',' '))}}
		@if(isset($attr['required']) &&  $attr['required'] == true) 
		<span class="tx-danger">*</span>
		@endif
		</label>
		<input type="{{isset($attr['type']) ? $attr['type'] : 'text'}}" 
			class="form-control {{isset($attr['class']) ? $attr['class'] : ''}}" 
			placeholder="{{isset($attr['label']) ? \Str::title($attr['label']) : \Str::title(\Str::of($attr['name'])->replace('_',' '))}}" 
			name="{{$attr['name']}}"
			value="{{isset($attr['value']) ? $attr['value'] : ''}}"
			id="{{\Str::lower($attr['name'])}}"
			@if($attr['readonly'] == true) readonly @endif
			@if($attr['disabled'] == true) disabled @endif>

		<x-alert class="alert-element mg-t-5" id="{{$attr['name']}}-errors"></x-alert>
	</div>
</div>