@extends('admin.layouts.app')
@section('content')
<link href="{{asset('extra-plugins/jstree/style.css')}}" rel="stylesheet" type="text/css"/>
<script src="{{asset('extra-plugins/jstree/jstree.js')}}"></script>
{{-- <style>
  [data-inline="true"]{
    display:initial;
  }

.jstree-default .jstree-clicked {
  background: #beebff00;
}
</style> --}}
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header text-right">
            <h4 class="card-title">{{@$title}}</h4>
          </div>
          <div class="card-body">
            <form id="permission" class="form-horizontal">
              <input id="jsondata" type="hidden" value=""> 
              <div class="form-group row">
                <div class="col-sm-4">
                  <label class="control-label">User Role<span class="required">*</span></label>
                  <select id="user_role" name="user_role" class="form-control form-control-sm select2">
                    <option value="">Select Role</option>
                    @foreach($roles as $role)
                    <option {{(request()->user_role==$role->id)?'selected':''}} value="{{$role->id}}">{{$role->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="col-sm-4">
                  <label class="control-label">Module List</label>
                  <select name="menu_id[]" class="form-control form-control-sm select2" id="menu_id" multiple="multiple">
                    <option value="">Select Module</option>
                    @foreach($modules as $module)
                    <option value="{{$module->id}}" {{(request()->menu_id)?((in_array($module->id, request()->menu_id))?("selected"):""):''}}>{{$module->name}} ( {{$module['module']['name']}} )</option>                 
                    @endforeach
                  </select>
                </div>           
                <div class="col-sm-3">              
                  <button type="submit" class="btn btn-info btn-sm" style="margin-top:28px"><i class="ion-search"></i>Search</button>             
                </div>
              </div>       
            </form>
          </div>
        </div>

        @if(isset($menus)&& !empty($menus))
        <div id="deleteifchangeselectoption">
          <div class="card">
            <div class="card-body">
              <div class="checkboxesTree">         
                <ul>
                  @foreach($menus as $parent)
                  @if($parent['child'])
                  <li id="111&{{$parent['id']}}&{{$parent['route']}}&{{$parent['menu_from']}}" data-jstree='{"opened":true}'>{{$parent['name']}}
                    @foreach($parent['child'] as $parent_child)
                    @if($parent_child['child'])
                    <ul>
                      <li id="222&{{$parent_child['id']}}&{{$parent_child['route']}}&{{$parent_child['menu_from']}}" data-jstree='{"opened":true}'>{{$parent_child['name']}}
                        <ul>
                          @foreach($parent_child['child'] as $parent_child_child)
                          @if(@$parent_child_child['child'])
                          <li id="333&{{$parent_child_child['id']}}&{{$parent_child_child['route']}}&{{$parent_child_child['menu_from']}}" data-jstree='{"opened":true}'>{{$parent_child_child['name']}}
                            <ul>
                              @foreach($parent_child_child['child'] as $parent_child_child_child)
                              @if(@$parent_child_child_child['child'])
                              @else
                              <li id="444&{{$parent_child_child_child['id']}}&{{$parent_child_child_child['route']}}&{{$parent_child_child_child['menu_from']}}" data-jstree='{"opened":true}'>{{$parent_child_child_child['name']}}
                                <ul>
                                  @foreach($parent_child_child_child['menu_route'] as $parent_child_child_child_menu_route) 
                                  <li data-inline="true" id="555&{{$parent_child_child_child_menu_route['id']}}&{{$parent_child_child_child_menu_route['route']}}&{{$parent_child_child_child_menu_route['menu_from']}}" data-jstree='{"selected":{{($parent_child_child_child_menu_route["permission"])?("true"):"false"}},"icon":"fa fa-user"}'>{{$parent_child_child_child_menu_route['name']}}</li>
                                  @endforeach
                                </ul>
                              </li>
                              @endif
                              @endforeach
                            </ul>
                          </li>
                          @else
                          <li id="666&{{$parent_child_child['id']}}&{{$parent_child_child['route']}}&{{$parent_child_child['menu_from']}}" data-jstree='{"opened":true}'>{{$parent_child_child['name']}}
                            <ul>
                              @foreach($parent_child_child['menu_route'] as $parent_child_child_menu_route) 
                              <li data-inline="true" id="777&{{$parent_child_child_menu_route['id']}}&{{$parent_child_child_menu_route['route']}}&{{$parent_child_child_menu_route['menu_from']}}" data-jstree='{"selected":{{($parent_child_child_menu_route["permission"])?("true"):"false"}},"icon":"fa fa-user"}'>{{$parent_child_child_menu_route['name']}}</li>
                              @endforeach
                            </ul>
                          </li>
                          @endif
                          @endforeach
                        </ul>
                      </li>
                    </ul>
                    @else
                    <ul>
                      <li id="888&{{$parent_child['id']}}&{{$parent_child['route']}}&{{$parent_child['menu_from']}}" data-jstree='{"opened":true}'>{{$parent_child['name']}}
                        <ul>
                          @foreach($parent_child['menu_route'] as $parent_child_menu_route) 
                          <li data-inline="true" id="999&{{$parent_child_menu_route['id']}}&{{$parent_child_menu_route['route']}}&{{$parent_child_menu_route['menu_from']}}" data-jstree='{"selected":{{($parent_child_menu_route["permission"])?("true"):"false"}},"type":"file"}'>{{$parent_child_menu_route['name']}}</li>
                          @endforeach
                        </ul>
                      </li>
                    </ul>
                    @endif
                    @endforeach
                  </li>
                  @else
                  <li id="1010&{{$parent['id']}}&{{$parent['route']}}&{{$parent['menu_from']}}" data-jstree='{"opened":true}'>{{$parent['name']}}
                    <ul>
                      @foreach($parent['menu_route'] as $parent_menu_route) 
                      <li data-inline="true" id="1212&{{$parent_menu_route['id']}}&{{$parent_menu_route['route']}}&{{$parent_menu_route['menu_from']}}" data-jstree='{"selected":{{($parent_menu_route["permission"])?("true"):"false"}},"icon":"fa fa-user"}'>{{$parent_menu_route['name']}}</li>
                      @endforeach
                    </ul>
                  </li>
                  @endif
                  @endforeach
                </ul> 
              </div>
            </div>       
          </div>
          <div class="card">
            <div class="card-body">
              <button id="add" class="btn btn-info btn-sm"><i class="ion-upload"></i> Add Menu Permission</button>
            </div>      
          </div> 
        </div>
        @endif         
      </div>
    </div>
  </div>
</section>
<script type="text/javascript">
  $(function(){
    $('#permission').validate({
      errorPlacement: function(error, element){
        if (element.attr("name") == "user_role" ){ error.insertAfter(element.next()); }
        else{error.insertAfter(element);}
      },
      errorClass:'text-danger',
      validClass:'text-success',
      rules:{
        user_role:{
          required: true
        }        
      }
    });
  });
</script>

<script type="text/javascript">
  $(function() {
    var menu='';
    $('.checkboxesTree').on('changed.jstree', function(e, data) {
      var i, j, r = [];
      nodesOnSelectedPath = [...data.selected.reduce(function (acc, nodeId) {
        var node = data.instance.get_node(nodeId);
        return new Set([...acc, ...node.parents, node.id]);
      }, new Set)];
      menu = nodesOnSelectedPath.join(',');
      $('#jsondata').val(menu); 
      console.log(menu);
    });
  });
</script>
<script type="text/javascript">
  $(function(){
    $('#add').on('click',function(){
      var url="{{route('admin.role-management.role-permission-info.store')}}";
      var role_id="{{request()->user_role}}";
      var menu_id=$('#menu_id').val();
      var jsondata=$('#jsondata').val();
      if(jsondata){
        $.ajax({
          'url':url,
          'type':'POST',
          'data':{_token:"{{csrf_token()}}",jsondata:jsondata,role_id:role_id,menu_id:menu_id},
          beforeSend : function(){
            $('.preload').show();
          },
          success:function(data){
            if(data.status=='success'){
              Swal.fire({
                icon: "success",
                title: data.message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
              });
              setTimeout(function(){
                location.reload();
              }, 2000);
            }else{
              Swal.fire({
                icon: "error",
                title: data.message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
              });
              $('.preload').hide();
            }
          },
          error: function(XMLHttpRequest, textStatus, errorThrown) {
            Swal.fire({
              icon: "error",
              title: "দুঃখিত !!সফটওয়্যার মেইনটেনেন্স সমস্যার কারনে তথ্য সংরক্ষন করা যাচ্ছে না। আপনি রিলোড না নিয়ে সংশিষ্ট সাপোর্ট ইঞ্জিনিয়ারকে জানান",
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000
            });
            $('.preload').hide();
          }
        });
      }else{
        Swal.fire({
          icon: "error",
          title: "Plese select any Menus",
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        });
        $('.preload').hide();   
      }     
    });
  });
</script>
<script type="text/javascript">
  $(document).on('change','#user_role,#menu_id',function(){
    $('#deleteifchangeselectoption').remove();
  });
</script>


<script type="text/javascript">
  $(document).ready(function() {
    $('.checkboxesTree').jstree({
      'core' : {
        'themes' : {
          'responsive': false
        }
      },

      'types' : {
        'default' : {
          'icon' : 'fa fa-file-text-o'
        },
        'file' : {
          'icon' : 'fa fa-file-text'
        }
      },

      'plugins' : ['types', 'checkbox']
    });
  });
</script>
@endsection