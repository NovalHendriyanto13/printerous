@extends('layouts.layout')

@section('css')

@endsection

@section('content')
<div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
  <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
    <x-breadcrumb type="update" />  
  </div>
  
  <div class="row row-xs">
    <div class="col-md-12 col-xs-12">
      <x-form :id="variable_get('base_url')" :action="variable_get('base_url').'/assign/'.$id" class="form" method="post">
        <x-slot name="additionalTabTitle">
            <li class="nav-item">
              <a class="nav-link" id="person-tab" data-toggle="tab" href="#person" role="tab" aria-controls="home" aria-selected="true">Person</a>
            </li>
        </x-slot>
        <x-slot name="additionalTab">
          <div class="tab-pane fade show" id="person" role="tabpanel" aria-labelledby="person">
            <div class="row row-sm mg-b-10">
              <div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
                <x-table :model="$person['model']" :setting="$person['setting']['table']" style="width:100% !important"/>
              </div>
            </div>
          </div>
        </x-slot>
      </x-form>
    </div>
  </div>
</div>
@endsection
