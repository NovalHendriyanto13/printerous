@extends('layouts.layout')

@section('content')
<div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
  <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
    <x-breadcrumb type="update" />    
  </div>
  
  <div class="row row-xs">
    <div class="col-md-12 col-xs-12">
      <x-form :id="variable_get('base_url')" :action="variable_get('base_url').'/update/'.$id" class="form" method="post" />
    </div>
  </div>
</div>
@endsection
