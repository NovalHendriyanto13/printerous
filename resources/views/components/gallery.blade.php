<x-input-hidden :attr="[
    'name'=>'table_id',
    'value'=>$table_id,
]"/>
<x-input-hidden :attr="[
    'name'=>'tablename',
    'value'=>$tablename,
]"/>
<x-input-text :attr="[
    'name'=>'gallery-name',
    'id'=>'gallery-name',
    'label'=>'Gallery Name',
    'class'=>'gallery-name']"/>
    
@if($allow_duplicate == 'true')
<x-input-checkbox :attr="[
    'name'=>'name',
    'label'=>'Same as Code',
    'class'=>'same', 
    'options'=>['true']]"/>
@endif
<x-input-text :attr="[
    'name'=>'gallery_item',
    'type'=>'file']" />

<div class="col-sm-6">
    <div class="form-group mg-b-20">
    <label>&nbsp;</label>

    <x-action-button :setting="[[
    'icon'=>'check-circle',
    'class'=>'btn-success btn-upload',
    'title'=>'Upload',
    'type'=>'button']]"/>
    </div>
</div>
<div class="col-sm-12 col-md-12">
    <div class="row">
        <div class="col-12 mg-t-20">
            <h5>Gallery Items</h5>
            <hr/>
            <div class="row">
                <div class="col-md-3 col-sm-6 text-center div-sample" id="div-sample" style="display:none">
                    <figure class="pos-relative mg-t-10 mg-b-0 bd bd-3 rounded">
                        <img src="" class="img-fluid img-thumb justify-content-center img-sample" id="img-sample"/>
                        <figcaption class="pos-absolute b-0 l-0 pd-20 d-flex justify-content-center">
                            <div class="btn-group">
                                <a href="#" class="btn btn-dark btn-icon gallery-download" data-id="img-sample" download><i data-feather="download"></i></a>
                                <a href="#" class="btn btn-dark btn-icon gallery-maximize" data-toggle="modal" data-id="img-sample"><i data-feather="maximize-2"></i></a>
                                <a href="#" class="btn btn-dark btn-icon gallery-delete" data-id="sample"><i data-feather="trash-2"></i></a>
                            </div>
                        </figcaption>
                    </figure>
                </div>
                @foreach($items as $k=>$image)
                <div class="col-md-3 col-sm-6 text-center" id="div-{{$k}}">
                    <figure class="pos-relative mg-t-10 mg-b-0 bd bd-3 rounded">
                        <img src="{{asset('images/'.$image)}}" class="img-fluid img-thumb justify-content-center" id="img-{{$k}}"/>
                        <figcaption class="pos-absolute b-0 l-0 pd-20 d-flex justify-content-center">
                            <div class="btn-group">
                                <a href="{{asset('images/'.Str::of($image)->replace('thumbnail/', ''))}}" class="btn btn-dark btn-icon gallery-download" data-id="{{$k}}" download><i data-feather="download"></i></a>
                                <a href="#" class="btn btn-dark btn-icon gallery-maximize" data-id="{{$k}}" data-toggle="modal" data-target="#preview"><i data-feather="maximize-2"></i></a>
                                <a href="#" class="btn btn-dark btn-icon gallery-delete" data-id="{{$k}}"><i data-feather="trash-2"></i></a>
                            </div>
                        </figcaption>
                    </figure>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="preview" tabindex="-1" role="dialog" aria-labelledby="previewLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img src="" class="img-fluid justify-content-center" id="preview-img"/>
      </div>
    </div>
  </div>
</div>
@section('js_component')
<script type="text/javascript">
$('.gallery-delete').click(function(e){
    e.preventDefault()
    var id = $(this).data('id')
    var img = $('#img-'+id).attr('src')

    $.ajax({
        url : baseUrl + 'gallery/remove-file',
        method : 'post',
        data : {
            file : img
        },
        dataType : 'JSON',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success : function(res) {
            var status = res.status
            if (status == true) {
                $('#div-'+id).empty()
            }
        }
    })
    return true
})

$('.same').change(function(e){
    let that = $(this)
    let galleryName = $('#gallery-name')
    if (this.checked) {
      let unitCode = $('#unit_code').val()
      galleryName.val(unitCode)
      return true
    }
    galleryName.val('')
    return false
  })

  $('.btn-upload').click(function(e){
    e.preventDefault()
    var that = $(this)
    const alert = $('.alert')
    const alertForm = $('.alert-form')
    const alertMsg = $('.alert-msg')

    alert.html('')
    alert.css('display','none')

    var url = 'gallery/create'
    var method = 'POST'
    var params = new FormData()
    

    params.append('name', $('#gallery-name').val())
    params.append('image',$('#gallery_item')[0].files[0])
    params.append('tablename',$('#tablename').val())
    params.append('table_id',$('#table_id').val())

    if (typeof(method) === 'undefined') {
      alertMsg.html('Error ! Please provide form method')
      alertForm.css('display','block')
      return false;
    }

    $.ajax({
      url: baseUrl + url,
      data: params,
      type: method,
      dataType: 'JSON',
      // cache:false,
      contentType: false,
      processData: false,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      beforeSend: ()=>{
        $('.spinner').css('display','block')
      },
      complete: ()=> {
        $('.spinner').css('display','none')
      },
      success: (res)=> {
        let data = res.data
        if(res.status == true) {
            let randomId = Math.random() * 10

            let reader = new FileReader()
            var imgSrc = {};
            reader.onload = function(e) {
                let preview = $('#div-sample').find('.img-sample') 
                preview.attr('src', e.target.result)
                imgSrc.target = e.target.result
            }
            reader.readAsDataURL($('#gallery_item')[0].files[0])
            
            var clone = $('#div-sample').clone().prop('id', 'div-'+randomId).css('display','block')
            var imgClone = clone.find('.img-sample').prop('id', 'img-'+randomId)
                .attr('src', baseUrl + 'images/'+ data.thumb_path+'/'+data.filename)
                
            $('#div-sample').after(clone) 
            // download
            var imgDownload = clone.find('.gallery-download')
                .attr('href', baseUrl + 'images/'+data.original_path+'/'+data.filename)
            
            // preview
            var imgPreview = clone.find('.gallery-maximize')
            imgPreview.on('click', function(e){
                e.preventDefault()
                $('#preview').find('#preview-img').attr('src', baseUrl + 'images/'+data.original_path+'/'+data.filename)
                $('#preview').modal()
            })
            // delete
            var imgDelete = clone.find('.gallery-delete')
            imgDelete.on('click', function(e){
                e.preventDefault()
                var img = baseUrl + 'images/'+ data.thumb_path+'/'+data.filename
                $.ajax({
                    url : baseUrl + 'gallery/remove-file',
                    method : 'post',
                    data : {
                        file : img
                    },
                    dataType : 'JSON',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success : function(res) {
                        var status = res.status
                        if (status == true) {
                            clone.remove()
                        }
                    }
                })
                return true
            })
        }
        else {
            if(Object.keys(res.errors).length > 0) {
                if (typeof(res.errors.messages) === 'object') {
                    let errId
                    $.each((res.errors.messages), function(i, v) {
                    if (i == 'name')
                        i = 'gallery-name'
                    else if(i == 'image')
                        i = 'gallery_item'

                    errId = $('#'+i+'-errors')
                    var errMessage = ''
                    $.each(v, function(ix, error) {
                        errMessage = errMessage + error + '<br/>'
                    })
                    errId.html(errMessage)
                    errId.css('display','block')
                    })
                    alertForm.html('Error ! Some errors in your input')
                }
                else {
                    alertForm.html('Error ! ' + res.errors.messages)
                }
            }
          alertForm.css('display','block')
        }
      },
      error: (err)=> {
        console.log(err)
        console.log('error-request')
        alertMsg.html('Error ! Something error in your input')
        alertForm.css('display','block')
      }
    });
  })
  $('#preview').on('shown.bs.modal', function(e) {
      var a = e.relatedTarget
      var imgId = '#img-' + $(a).data('id')
      var imgSrc = $(imgId).attr('src')
      if (typeof(imgSrc) != 'undefined') {     
          $('#preview-img').attr('src',imgSrc.replace('thumbnail/',''))
      }
  })
</script>
@endsection