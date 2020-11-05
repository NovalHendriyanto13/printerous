<div class="col-sm-6">
	<div class="form-group mg-b-20">
		<label>
		{{isset($attr['label']) ? \Str::title($attr['label']) : \Str::title(\Str::of($attr['name'])->replace('_',' '))}}
		@if(isset($attr['required']) &&  $attr['required'] == true) 
		<span class="tx-danger">*</span>
		@endif
		</label>

		<div class="col-md-12 mb-2">
			<div class="container-image" style="position: relative;">
	            <img id="{{\Str::lower($attr['name'])}}-preview"
	                alt="preview image" 
	                class="preview-image @if(isset($attr['value'])) view-image @endif"
	                style="max-height: 150px; @if(!isset($attr['value'])) display: none; @endif" 
	                @if(isset($attr['value'])) src="{{ image_url($attr['value']) }}" @endif>
	            <a class="remove-preview" 
	            	id="{{\Str::lower($attr['name'])}}-preview-remove"
	            	href="#" 
	            	data-target="{{\Str::lower($attr['name'])}}-preview"
	            	data-file="{{\Str::lower($attr['name'])}}"
	            	style="max-height: 150px;color: red; @if(!isset($attr['value'])) display: none; @endif" >Remove</a>
	        </div>
        </div>
		<input type="file" 
			class="form-control input-image {{isset($attr['class']) ? $attr['class'] : ''}}" 
			name="{{$attr['name']}}"
			value="{{isset($attr['value']) ? $attr['value'] : ''}}"
			id="{{\Str::lower($attr['name'])}}"
		/>
		<!-- <input name="{{$attr['name']}}" type="hidden" value="{{isset($attr['value']) ? $attr['value'] : ''}}"> -->

		<x-alert class="alert-element mg-t-5" id="{{$attr['name']}}-errors"></x-alert>
	</div>
	<!-- <div class="valid-feedback">Looks good!</div> -->
</div>