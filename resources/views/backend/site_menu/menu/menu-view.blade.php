@extends('backend.layouts.app')
@section('content')
<style type="text/css">
  .dd { position: relative; display: block; margin: 0; padding: 0; max-width: 600px; list-style: none; font-size: 13px; line-height: 20px; }
  .dd-list { display: block; position: relative; margin: 0; padding: 0; list-style: none; }
  .dd-list .dd-list { padding-left: 30px; }
  .dd-collapsed .dd-list { display: none; }
  .dd-item,
  .dd-empty,
  .dd-placeholder { display: block; position: relative; margin: 0; padding: 0; min-height: 20px; font-size: 13px; line-height: 20px; }
  .dd-handle { display: block; height: 30px; margin: 5px 0; padding: 5px 10px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
    background: #fafafa;
    background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
    background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
    background:         linear-gradient(top, #fafafa 0%, #eee 100%);
    -webkit-border-radius: 3px;
    border-radius: 3px;
    box-sizing: border-box; -moz-box-sizing: border-box;
  }
  .dd-handle:hover { color: #2ea8e5; background: #fff; }
  .dd-item > button { display: block; position: relative; cursor: pointer; float: left; width: 25px; height: 20px; margin: 5px 0; padding: 0; text-indent: 100%; white-space: nowrap; overflow: hidden; border: 0; background: transparent; font-size: 12px; line-height: 1; text-align: center; font-weight: bold; }
  .dd-item > button:before { content: '+'; display: block; position: absolute; width: 100%; text-align: center; text-indent: 0; }
  .dd-item > button[data-action="collapse"]:before { content: '-'; }
  .dd-placeholder,
  .dd-empty { margin: 5px 0; padding: 0; min-height: 30px; background: #f2fbff; border: 1px dashed #b6bcbf; box-sizing: border-box; -moz-box-sizing: border-box; }
  .dd-empty { border: 1px dashed #bbb; min-height: 100px; background-color: #e5e5e5;
    background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
    -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-image:    -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
    -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-image:         linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
    linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-size: 60px 60px;
    background-position: 0 0, 30px 30px;
  }
  .dd-dragel { position: absolute; pointer-events: none; z-index: 9999; }
  .dd-dragel > .dd-item .dd-handle { margin-top: 0; }
  .dd-dragel .dd-handle {
    -webkit-box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
    box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
  }
  .nestable-lists { display: block; clear: both; padding: 30px 0; width: 100%; border: 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; }
  #nestable-menu { padding: 0; margin: 20px 0; }
  #nestable-output{ width: 100%; height: 7em; font-size: 0.75em; line-height: 1.333333em; font-family: Consolas, monospace; padding: 5px; box-sizing: border-box; -moz-box-sizing: border-box; }
  @media only screen and (min-width: 700px) {
    .dd { float: left; width: 48%; }
    .dd + .dd { margin-left: 2%; }
  }
  .dd-hover > .dd-handle { background: #2ea8e5 !important; }
</style>
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Manage Menu</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Menu</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="card"> 
          <div class="card-header">
            {{-- <a href="{{ route('frontend-menu.menu.add') }}" class="btn btn-sm btn-info"><i class="fas fa-plus"></i> Add Menu</a> --}}
            <form action="{{route('frontend-menu.menu.store')}}" method="post">
              @csrf
              <textarea id="nestable-output" name="nestableoutput" style="display:none;"></textarea>
              <button class="btn btn-sm btn-info"><i class="fa fa-save"></i> Save Menu</button>
            </form>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-6">
                <div class="dd" id="nestable" style="width: 100%;">
                  <?php $parents = DB::table('frontend_menus')->where('parent_id','0')->get();?>
                  @if(count($parents) != 0)
                  <ol class="dd-list new_data">
                    @foreach($parents as $parent)
                    <li class="dd-item" data-rand_id="{{$parent->rand_id}}" data-title_en="{{$parent->title_en}}" data-title_bn="{{$parent->title_bn}}" data-url_link="{{$parent->url_link}}" data-url_link_type="{{$parent->url_link_type}}" data-url_link_file="" data-status="{{$parent->status}}">
                      <div class="dd-handle {{($parent->status =='1')?('text-dark'):'text-danger'}}">{{$parent->title_en}}</div>
                      <span class="menu-delete" style="font-size: 20px;z-index:10;position:absolute; right:5px; top:4px; cursor:pointer;"><i class="fa fa-trash text-danger"></i></span>
                      <span class="menu-edit" style="font-size: 20px;z-index:10;position:absolute; right:35px; top:4px; cursor:pointer;"><i class="fa fa-edit text-primary"></i></span>
                      <?php $parents = DB::table('frontend_menus')->where('parent_id',$parent->rand_id)->get();?>
                      @if(count($parents) != 0)
                      <ol class="dd-list">
                        @foreach($parents as $parent)
                        <li class="dd-item" data-rand_id="{{$parent->rand_id}}" data-title_en="{{$parent->title_en}}" data-title_bn="{{$parent->title_bn}}" data-url_link="{{$parent->url_link}}" data-url_link_type="{{$parent->url_link_type}}" data-url_link_file="" data-status="{{$parent->status}}">
                          <div class="dd-handle {{($parent->status =='1')?('text-dark'):'text-danger'}}">{{$parent->title_en}}</div>
                          <span class="menu-delete" style="font-size: 20px;z-index:10;position:absolute; right:5px; top:4px; cursor:pointer;"><i class="fa fa-trash text-danger"></i></span>
                          <span class="menu-edit" style="font-size: 20px;z-index:10;position:absolute; right:35px; top:4px; cursor:pointer;"><i class="fa fa-edit text-primary"></i></span>
                          <?php $parents = DB::table('frontend_menus')->where('parent_id',$parent->rand_id)->get();?>
                          @if(count($parents) != 0)
                          <ol class="dd-list">
                            @foreach($parents as $parent)
                            <li class="dd-item" data-rand_id="{{$parent->rand_id}}" data-title_en="{{$parent->title_en}}" data-title_bn="{{$parent->title_bn}}" data-url_link="{{$parent->url_link}}" data-url_link_type="{{$parent->url_link_type}}" data-url_link_file="" data-status="{{$parent->status}}">
                              <div class="dd-handle {{($parent->status =='1')?('text-dark'):'text-danger'}}">{{$parent->title_en}}</div>
                              <span class="menu-delete" style="font-size: 20px;z-index:10;position:absolute; right:5px; top:4px; cursor:pointer;"><i class="fa fa-trash text-danger"></i></span>
                              <span class="menu-edit" style="font-size: 20px;z-index:10;position:absolute; right:35px; top:4px; cursor:pointer;"><i class="fa fa-edit text-primary"></i></span>
                              <?php $parents = DB::table('frontend_menus')->where('parent_id',$parent->rand_id)->get();?>
                              @if(count($parents) != 0)
                              <ol class="dd-list">
                                @foreach($parents as $parent)
                                <li class="dd-item" data-rand_id="{{$parent->rand_id}}" data-title_en="{{$parent->title_en}}" data-title_bn="{{$parent->title_bn}}" data-url_link="{{$parent->url_link}}" data-url_link_type="{{$parent->url_link_type}}" data-url_link_file="" data-status="{{$parent->status}}">
                                  <div class="dd-handle {{($parent->status =='1')?('text-dark'):'text-danger'}}">{{$parent->title_en}}</div>
                                  <span class="menu-delete" style="font-size: 20px;z-index:10;position:absolute; right:5px; top:4px; cursor:pointer;"><i class="fa fa-trash text-danger"></i></span>
                                  <span class="menu-edit" style="font-size: 20px;z-index:10;position:absolute; right:35px; top:4px; cursor:pointer;"><i class="fa fa-edit text-primary"></i></span>
                                  <?php $parents = DB::table('frontend_menus')->where('parent_id',$parent->rand_id)->get();?>
                                  @if(count($parents) != 0)
                                  <ol class="dd-list">
                                    @foreach($parents as $parent)
                                    <li class="dd-item" data-rand_id="{{$parent->rand_id}}" data-title_en="{{$parent->title_en}}" data-title_bn="{{$parent->title_bn}}" data-url_link="{{$parent->url_link}}" data-url_link_type="{{$parent->url_link_type}}" data-url_link_file="" data-status="{{$parent->status}}">
                                      <div class="dd-handle {{($parent->status =='1')?('text-dark'):'text-danger'}}">{{$parent->title_en}}</div>
                                      <span class="menu-delete" style="font-size: 20px;z-index:10;position:absolute; right:5px; top:4px; cursor:pointer;"><i class="fa fa-trash text-danger"></i></span>
                                      <span class="menu-edit" style="font-size: 20px;z-index:10;position:absolute; right:35px; top:4px; cursor:pointer;"><i class="fa fa-edit text-primary"></i></span>
                                    </li>
                                    @endforeach
                                  </ol>
                                  @endif
                                </li>
                                @endforeach
                              </ol>
                              @endif
                            </li>
                            @endforeach
                          </ol>
                          @endif
                        </li>
                        @endforeach
                      </ol>
                      @endif
                    </li>
                    @endforeach
                  </ol>
                  @endif
                </div>
              </div>
              <div class="col-md-6">
                <div class="card">
                  <form action="{{route('frontend-menu.menu.single.store')}}" method="post">
                    @csrf
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        <label>Title</label>
                        <input type="text" name="title_en" id="title_en" class="form-control form-control-sm" value="">
                        <input type="hidden" name="edit_rand_id" id="edit_rand_id" class="form-control form-control-sm" value="">
                      </div>
                    </div><br/>
                    <div class="row linkpathDiv">
                      <div class="col-md-12">
                        <label>Link Path</label>
                        <input data-toggle="modal" data-target="#myModal" type="text" name="url_link" id="url_link" class="form-control form-control-sm url_link" value="" readonly>
                        <input type="hidden" name="url_link_file" id="url_link_file" class="url_link_file" value="">
                        <input type="hidden" name="url_link_type" id="url_link_type" class="url_link_type" value="">
                      </div>
                    </div><br/>
                    <div class="row">
                      <div class="col-md-12">
                        <label>Publish</label>
                        <select name="status" class="form-control form-control-sm" id="status">
                          <option value="1">Publish</option>
                          <option value="0">Un-publish</option>
                        </select>
                      </div>
                    </div><br/>
                    <div class="row">
                      <div class="col-md-12">
                        {{-- <button type="button" class="btn btn-primary" id="saveform">Submit</button> --}}
                        <button type="submit" class="btn btn-primary" id="saveform">Submit</button>
                        <button type="button" class="btn btn-info" id="newform" style="float: right;">New</button>
                      </div>
                    </div>
                  </div>
                </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
  $(document).ready(function(){
    update_click();
    function update_click(){
      var updateOutput = function(e){
        var list   = e.length ? e : $(e.target),
        output = list.data('output');
        if (window.JSON) {
          output.val(window.JSON.stringify(list.nestable('serialize')));
        } else {
          output.val('JSON browser support required for this demo.');
        }
      };
      $('#nestable').nestable({
        group: 1
      }).on('change', updateOutput);
      updateOutput($('#nestable').data('output', $('#nestable-output')));
    }

    $(document).on("click",'.menu-delete',function(){
      var remove_menu = $(this).parent();
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.value) {
          Swal.fire(
            'Deleted!',
            'Record has been deleted.',
            'success'
            );
          $(remove_menu).remove();
          update_click();
        }     
      });
    });


    function makeid(){
      var text = "";
      var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
      for( var i=0; i < 8; i++ )
        text += possible.charAt(Math.floor(Math.random() * possible.length));
      return text;
    }

    // $(document).on('click','#saveform',function(){
    //   var rand_id = $('#edit_rand_id').val();
    //   var title_en = $('#title_en').val();
    //   var url_link = $('#url_link').val();
    //   var url_link_type = $('#url_link_type').val();
    //   var url_link_file = $('#url_link_file').val();
    //   var status = $('#status').val();
    //   if(status == 1){
    //     var status_msg = 'text-dark';
    //   }else{
    //     var status_msg = 'text-danger';
    //   }

    //   if(rand_id){
    //     $('[data-rand_id="'+rand_id+'"]').attr('data-title_en',title_en);
    //     $('[data-rand_id="'+rand_id+'"]').attr('data-url_link',url_link);
    //     $('[data-rand_id="'+rand_id+'"]').attr('data-url_link_type',url_link_type);
    //     $('[data-rand_id="'+rand_id+'"]').attr('data-url_link_file',url_link_file);
    //     $('[data-rand_id="'+rand_id+'"]').attr('data-status',status);

    //     $('[data-rand_id="'+rand_id+'"]').data('title_en',title_en);
    //     $('[data-rand_id="'+rand_id+'"]').data('url_link',url_link);
    //     $('[data-rand_id="'+rand_id+'"]').data('url_link_type',url_link_type);
    //     $('[data-rand_id="'+rand_id+'"]').data('url_link_file',url_link_file);
    //     $('[data-rand_id="'+rand_id+'"]').data('status',status);

    //     $('[data-rand_id="'+rand_id+'"]').find('.dd-handle:first').html(title_en);
    //     $('[data-rand_id="'+rand_id+'"]').find('.dd-handle:first').removeClass('text-danger').removeClass('text-dark').addClass(status_msg);
        
    //     var title_en = $('#title_en').val('');
    //     var url_link = $('#url_link').val('');
    //     var url_link_type = $('#url_link_type').val('');
    //     var url_link_file = $('#url_link_file').val('');
    //     var edit_rand_id = $('#edit_rand_id').val('');
    //     var status = $('#status').val(1);
    //     $('#saveform').text('Submit');
    //   }else{
    //     var new_nestable = '<li class="dd-item" data-rand_id="'+makeid()+'" data-title_en="'+title_en+'" data-title_bn="'+title_en+'" data-url_link="'+url_link+'" data-url_link_file="'+url_link_file+'" data-url_link_type="'+url_link_type+'" data-status="'+status+'">'+
    //     '<div class="dd-handle '+status_msg+'">'+title_en+'</div>'+
    //     '<span class="menu-delete" style="font-size: 20px;z-index:10;position:absolute; right:5px; top:4px; cursor:pointer;"><i class="fa fa-trash text-danger"></i></span>'+
    //     '<span class="menu-edit" style="font-size: 20px;z-index:10;position:absolute; right:35px; top:4px; cursor:pointer;"><i class="fa fa-edit text-primary"></i></span>'+
    //     '</li>';
    //     $(new_nestable).prependTo('.new_data');
    //   }
    //   update_click();
    // });

    $(document).on('click','.menu-edit',function(){
      var rand_id = $(this).parents('.dd-item').attr('data-rand_id');
      var title_en = $(this).parents('.dd-item').attr('data-title_en');
      var url_link = $(this).parents('.dd-item').attr('data-url_link');
      var url_link_type = $(this).parents('.dd-item').attr('data-url_link_type');
      var url_link_file = $(this).parents('.dd-item').attr('data-url_link_file');
      var status = $(this).parents('.dd-item').attr('data-status');

      var title_en = $('#title_en').val(title_en);
      var url_link = $('#url_link').val(url_link);
      var url_link_type = $('#url_link_type').val(url_link_type);
      var url_link_file = $('#url_link_file').val(url_link_file);
      var edit_rand_id = $('#edit_rand_id').val(rand_id);
      var status = $('#status').val(status);
      $('#saveform').text('Update');
    });

    $(document).on('click','#newform',function(){
      var title_en = $('#title_en').val('');
      var url_link = $('#url_link').val('');
      var url_link_type = $('#url_link_type').val('');
      var url_link_file = $('#url_link_file').val('');
      var edit_rand_id = $('#edit_rand_id').val('');
      var status = $('#status').val(1);
      $('#saveform').text('Submit');
    });











  });
</script>
@endsection

