@extends('backend.layouts.app') @section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ !empty($editData)? 'Update Menu' : 'Add Menu' }}</h1>
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
        <div class="card">
            <div class="card-header">
                <a href="{{route('frontend-menu.menu.view')}}" class="btn btn-info btn-sm"><i class="fas fa-stream"></i> View Menu</a>
            </div>
            <div class="card-body">
                <form method="post" action="{{!empty($editData->id) ? route('frontend-menu.menu.update',$editData->id) : route('frontend-menu.menu.store')}}" id="myForm">
                    {{csrf_field()}}
                    @if(@$editData)
                    <div class="row">
                        <div class="col-md-6">
                            <label>Menu</label>
                            <select name="menu_id" id="menu_id" class="form-control">
                                <option value="">Select Menu</option>
                                <option value="0"{{(@$menu_number['parent_id']=='0')?('selected'):''}}>New Main Menu</option>
                                <optgroup label="Menu">
                                    <?php $allParentmenu = DB::table('frontend_menus')->where('parent_id','0')->get(); ?>
                                    @foreach($allParentmenu as $value)
                                    <option value="{{$value->rand_id}}" {{(@$menu_number['parent_id']==$value->rand_id)?('selected'):''}}>{{$value->title_en}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-md-6 submenuDiv" style="display: {{(@$menu_number['access_id'] ==1)?('none'):'block'}}">
                            <label>Sub Menu</label>
                            <select name="sub_menu_id" id="sub_menu_id" class="form-control">
                                <option value="">Select Sub Menu</option>
                                <option value="0" {{(@$menu_number['sub_parent_id']=='0')?('selected'):''}}>New Sub Menu</option>
                                <optgroup label="Sub Menu">
                                    <?php $allParentsubmenu = DB::table('frontend_menus')->where('parent_id',@$menu_number['parent_id'])->get(); ?>
                                    @foreach($allParentsubmenu as $value)
                                    <option value="{{$value->rand_id}}" {{(@$menu_number['sub_parent_id']==$value->rand_id)?('selected'):''}}>{{$value->title_en}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                    </div><br/>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Title</label>
                            <input type="text" name="title_en" id="title_en" class="form-control" value="{{!empty($editData->title_en) ? ($editData->title_en) : old('title_en')}}">
                        </div>
                    </div><br/>
                    <div class="row linkpathDiv">
                        <div class="col-md-6">
                            <label>Link Path</label>
                            <input data-toggle="modal" data-target="#myModal" type="text" name="url_link" id="url_link" class="form-control url_link" value="{{ !empty($editData->url_link) ? $editData->url_link : old('url_link') }}" readonly>
                            <input type="hidden" name="url_link_file" id="url_link_file" class="url_link_file" value="">
                            <input type="hidden" name="url_link_type" id="url_link_type" class="url_link_type" value="{{ !empty($editData->url_link_type) ? $editData->url_link_type : old('url_link_type') }}">
                        </div>
                    </div><br/>
                    @else
                    <div class="row">
                        <div class="col-md-6">
                            <label>Menu</label>
                            <select name="menu_id" id="menu_id" class="form-control">
                                <option value="">Select Menu</option>
                                <option value="0">New Main Menu</option>
                                <optgroup label="Menu">
                                    <?php $allParentmenu = DB::table('frontend_menus')->where('parent_id','0')->get(); ?>
                                    @foreach($allParentmenu as $value)
                                    <option value="{{$value->rand_id}}">{{$value->title_en}}</option>
                                    @endforeach
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-md-6 submenuDiv">
                            <label>Sub Menu</label>
                            <select name="sub_menu_id" id="sub_menu_id" class="form-control">
                                <option value="">Select Sub Menu</option>
                                <option value="0">New Sub Menu</option>
                            </select>
                        </div>
                    </div><br/>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Title </label>
                            <input type="text" name="title_en" id="title_en" class="form-control" value="{{!empty($editData->title_en) ? ($editData->title_en) : old('title_en')}}">
                        </div>
                    </div><br/>
                    <div class="row linkpathDiv">
                        <div class="col-md-6">
                            <label>Link Path</label>
                            <input data-toggle="modal" data-target="#myModal" type="text" name="url_link" id="url_link" class="form-control url_link" value="" readonly>
                            <input type="hidden" name="url_link_file" id="url_link_file" class="url_link_file" value="">
                            <input type="hidden" name="url_link_type" id="url_link_type" class="url_link_type" value="">
                        </div>
                    </div><br/>
                    @endif
                    <div class="row">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">{{(@$editData) ? 'Update' : 'Submit'}}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function(){
        $('textarea').each(function(){
            $(this).val($(this).val().trim());
        });
        $('#myForm').validate({
            ignore : [],
            debug : false,
            errorClass:'text-danger',
            validClass:'text-success',
            rules : {
                description:{
                    required: function() 
                    {
                        CKEDITOR.instances.description.updateElement();
                    },
                    minlength:10
                },
                title : {
                    required : true
                }
            },
            messages : {
            }
        });
    });
</script>

<script type="text/javascript">

    <?php if(!@$editData){?>
    $(function(){
            $('.submenuDiv').hide();
        });
    <?php }?>

    $(function(){
        $(document).on('change','#menu_id',function(){
            var menu_id =$(this).val();
            if(menu_id =='' || menu_id =='0'){
                $('.submenuDiv').hide();
                $('#sub_menu_id').val('');
                $('#url_link').val('');
            }else{
                $('.submenuDiv').show();
            }
        });
        $(document).on('change','#sub_menu_id',function(){
            var menu_id =$(this).val();
            if(menu_id =='' || menu_id =='0'){
                $('#url_link').val('');
            }else{
                $('.linkpathDiv').show();
            }
        });
    });

    $(function(){
        $(document).on('change','#menu_id',function(){
            var menu_id =$(this).val();
            $.ajax({
                url:"{{route('table.data.submenu')}}",
                type:"GET",
                data:{menu_id:menu_id},
                success:function(data){
                    $('#sub_menu_id').html(data);
                }
            });
        });
    });
</script>

@endsection