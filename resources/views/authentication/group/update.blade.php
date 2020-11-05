@extends('layouts.layout')

@section('css')
<link rel="stylesheet" href="{{asset('assets/lib/jstree/themes/default/style.min.css')}}" />
@endsection

@section('content')
<div class="container pd-x-0 pd-lg-x-10 pd-xl-x-0">
  <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
    <x-breadcrumb type="update" />  
  </div>
  
  <div class="row row-xs">
    <div class="col-md-12 col-xs-12">
      <x-form :id="variable_get('base_url')" :action="variable_get('base_url').'/update/'.$id" class="form" method="post">
        <x-slot name="additionalTabTitle">
            <li class="nav-item">
              <a class="nav-link" id="permission-tab" data-toggle="tab" href="#permission" role="tab" aria-controls="home" aria-selected="true">Permission</a>
            </li>
        </x-slot>
        <x-slot name="additionalTab">
          <div class="tab-pane fade show" id="permission" role="tabpanel" aria-labelledby="permission">
            <div class="row row-sm mg-b-10">
              <x-input-hidden :attr="['name'=>'default', 'value'=>json_encode($defaultPermission)]" />
              <div class="menu-list">
                <ul>
                  @foreach($permissions as $parent=>$permission)
                  <li>{{$parent}}
                    <ul>
                      @foreach($permission as $menu)
                      <li id="{{$menu['id']}}" onclick="clicked(this)" data-jstree='{ "selected" : {{$menu["selected"]}} }' value="{{$menu['id']}}">{{$menu['action']}}</li>
                      @endforeach
                    </ul>
                  </li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
        </x-slot>
      </x-form>
    </div>
  </div>
</div>
@endsection

@section('js')
<script src="{{asset('assets/lib/jstree/jstree.min.js')}}"></script>
<script type="text/javascript">
  
  var jsTree = $('.menu-list').jstree({
    "plugins" : [ "wholerow", "checkbox" ]
  });

  var defaultPermission = JSON.parse($('input[name="default"]').val())

  let selected = defaultPermission
  var additionalParams;
  
  var clicked = function(e){
    let id = e.id
    if((id).substr(0,3) == 'j1_') {
      id = (e.id).substr(3)
    }

    if(e.attributes['aria-selected'].value === 'false') {
      selected.push(id)
      additionalParams = selected
    }
    else {
      var filter = selected.filter((item)=>{
        return item != id 
      })
      selected = filter
      additionalParams = selected
    }
  }

</script>
@endsection
