<div>
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-style1 mg-b-10">
      <li class="breadcrumb-item"><a href="{{URL::to('/')}}">Dashboard</a></li>
      <li class="breadcrumb-item @if($mode == '') active @endif"><a href="{{URL::to(variable_get('base_url'))}}">{{variable_get('title')}}</a></li>
      @if($mode != '')
      <li class="breadcrumb-item active" aria-current="page">{{$mode}}</li>
      @endif
    </ol>
  </nav>
  <h4 class="mg-b-0 tx-spacing--1">{{variable_get('title')}} {{\Str::ucfirst($mode)}}</h4>
</div>  