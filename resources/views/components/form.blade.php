@php $collections = \Lib\Form::getCollection(); @endphp
<form id="form-{{$id}}" class="needs-validation {{$class}}" action="{{$action}}" method="{{$method}}" enctype="multipart/form-data">
	<x-alert class="alert-form"><div class="alert-msg"></div></x-alert>
	<div class="align-items-center justify-content-between mg-b-5 mg-lg-b-10 mg-xl-b-15" style="text-align:right;">
		<x-action-button :route="variable_get('base_url')"/>
	</div>

	<div class="card">
		<div class="card-header">
			<ul class="nav nav-tabs" id="myTab5" role="tablist">
			@foreach($collections as $k=>$els)
        		<li class="nav-item">
    	  			<a class="nav-link @if(array_key_first($collections) == $k) active @endif" id="{{\Str::snake($k)}}-tab" data-toggle="tab" href="#{{\Str::snake($k)}}" role="tab" aria-controls="home" aria-selected="true">{{\Str::ucfirst($k)}}</a>
        		</li>
        	@endforeach

        	@if(isset($additionalTabTitle)) {{ $additionalTabTitle }} @endif
    		</ul>
    	</div>
    	<div class="card-body">
			<div class="tab-content mg-t-20" id="myTabContent5">
			@foreach($collections as $key=>$elements)
	  			<div class="tab-pane fade show @if(array_key_first($collections) == $key) active @endif" id="{{\Str::snake($key)}}" role="tabpanel" aria-labelledby="{{\Str::snake($key)}}">
	  				<div class="row row-sm mg-b-10">
	  				@foreach($elements as $el)
    				{!! \Lib\Form::render($el) !!}
    				@endforeach
    				</div>
	  			</div>
			@endforeach
				@if(isset($additionalTab)) {{ $additionalTab }} @endif
			</div>
		</div>
  	</div>
</form>