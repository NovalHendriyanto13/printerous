<div class="col-sm-6">
	<div class="form-group mg-b-20">
		<label>
		{{isset($attributes['label']) ? \Str::title($attributes['label']) : \Str::title(\Str::of($attributes['name'])->replace('_',' '))}}
		@if(isset($attributes['required']) &&  $attributes['required'] == true) 
		<span class="tx-danger">*</span>
		@endif
		</label>
		<textarea
			class="form-control" 
			placeholder="{{isset($attributes['label']) ? \Str::title($attributes['label']) : \Str::title(\Str::of($attributes['name'])->replace('_',' '))}}" 
			name="{{$attributes['name']}}"
			id="{{\Str::lower($attributes['name'])}}"
			@if($attributes['readonly'] == true) readonly @endif>{{isset($attributes['value']) ? $attributes['value'] : ''}}</textarea>

		<div class="alert alert-danger mg-t-5" id="{{$attributes['name']}}-errors" style="display: none;"></div>
	</div>
	<!-- <div class="valid-feedback">Looks good!</div> -->
</div>