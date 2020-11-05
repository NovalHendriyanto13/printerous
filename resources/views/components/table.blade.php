@section('css_component')
<link rel="stylesheet" href="{{ asset('assets/lib/datatables.net-dt/css/jquery.dataTables.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/lib/datatables.net-responsive-dt/css/responsive.dataTables.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/lib/datatables.net/css/buttons.dataTables.min.css')}}">
@endsection
<div data-label="Example" class="df-example demo-table">
	@if(count($setting['bulks']) > 0)
	<div class="row mg-b-5 no-gutters">
		<div class="col-md-2 offset-md-9">
			<select name="action_bulk" class="form-control float-right">
				<option value=""></option>
				@foreach($setting['bulks'] as $k=>$v)
				<option value="{{$k}}">{{$v}}</option>
				@endforeach
			</select>
		</div>
		<div class="col-md-1">
			<button class="btn btn-secondary btn-bulk-actions">Submit</button>
		</div>
	</div>
	@endif
	<table id="table-{{Str::random(10)}}" class="table datatable table-striped table-hover">
	  <thead>
	    <tr>
	    	@if(count($setting['bulks']) > 0)
	    		<th>
	    			<input type="checkbox" name="all" id="table-checkall" class="">
	    		</th>
	    		<!-- <th></th> -->
	    	@endif
	    	@foreach($setting['columns'] as $s)
	    		@if($s['visible'] == true)
	        	<th>{{Str::replaceArray('_',[' '],$s['title'])}}</th>
	        	@endif
	        @endforeach

	        @if(isset($setting['grid_actions']))
	        <th>Actions</th>
	        @endif
	    </tr>
	  </thead>
	  <tbody>
	  	@foreach($data as $d)
	  	<tr>
	  		@if(count($setting['bulks']) > 0)
	    		<td>
	    			<input type="checkbox" name="check[]" id="table-check" value="{{ $d->id }}" class="table-check"/>
	    		</td>
	    		<!-- <td></td> -->
	    	@endif
	  		@foreach($setting['columns'] as $s)
	    		@if($s['visible'] == true)
	    		@php $k = $s['name'] @endphp
	    			@if(\Str::contains($k,'.') && $a = \Str::of($k)->explode('.'))
	    			@php $property = $a[0]; $value = $a[1]; $relation = $d->$property; @endphp
	    			<td>
	    				@if(isset($s['transform']))
	    				{{ $s['transform'][$relation[$value]] }}
	    				@else
	    				{{ $relation[$value] }}
	    				@endif
	    			</td>
	    			@else
		        	<td>
		        		@if(isset($s['transform']))
		        		{{ $s['transform'][$d->$k] }}
		        		@else
		        		{{ $d->$k }}
		        		@endif
		        	</td>
					@endif
	        	@endif
	        @endforeach

	        @if(isset($setting['grid_actions']))
	        <td>
	        	@foreach($setting['grid_actions'] as $action)
	        	<a href="{{$action['url']}}/{{$d->id}}" class="btn {{$action['class']}}">
	        		@if(isset($action['icon']) && $action['icon'] != '')
			  		<i data-feather="{{$action['icon']}}" class="wd-10 mg-r-5"></i>
			  		@endif
	        		{{$action['title']}}
	        	</a> &nbsp;
	        	@endforeach
	        </td>
	        @endif		    
        </tr>
        @endforeach
	  </tbody>
	</table>
	@if(count($data) <= 0)
	<div class="mg-t-10">
		No Data Displayed
	</div>
	@endif
</div><!-- df-example -->

@section('js_component')
<script src="{{asset('assets/lib/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/lib/datatables.net-dt/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{asset('assets/lib/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/lib/datatables.net-responsive-dt/js/responsive.dataTables.min.js')}}"></script>
<script src="{{asset('assets/lib/datatables.net/js/dataTables.select.min.js')}}"></script>
<script src="{{asset('assets/lib/datatables.net/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/lib/datatables.net/js/buttons.colVis.min.js')}}"></script>

@endsection