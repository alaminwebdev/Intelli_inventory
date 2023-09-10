@extends('backend.layouts.app')
@section('content')
<style type="text/css">
    h4{
        padding-top:10px;
    }
    .card_body{
        border-radius: 10px; 
        text-align: center;
    }
    .card-clock{
        background: transparent;
        border:none;
    }
</style>
 <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">@lang('Dashboard')</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('dashboard')}}">@lang('Home')</a></li>
              <li class="breadcrumb-item active">@lang('Dashboard')</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
              <div class="card card-clock mb-3">
                  <div class="card-body text-white bg-info p-0 mb-0 card_body" style="">
                      <h4>{{date('l d F, Y')}}</h4>
                  </div>
              </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
              <div class="card card-clock mb-3">
                  <div class="card-body text-white bg-danger p-0 mb-0 card_body">
                      <h4 id="clock" class="clock" onload="showTime()"></h4>
                  </div>
              </div>
          </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-3">
                <div style="background: #1B9D5E; padding: 5px; border-radius: 10px; text-align: center;">
                    <a href="{{route('homepages.ministry.view')}}" style="color: #fff;">
                        <i class="fa fa-file" aria-hidden="true" style="font-size: 50px"></i>
                        <br/> Ministry List
                    </a>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-3">
                <div style="background: #517fa4; padding: 5px; border-radius: 10px; text-align: center;">
                    <a href="{{route('homepages.policy-acts.view')}}" style="color: #fff;"><i class="fa fa-folder bigfonts" aria-hidden="true" style="font-size: 50px"></i><br/> Policy & Acts</a>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-3">
                <div style="background: #82C91E; padding: 5px; border-radius: 10px; text-align: center;">
                    <a href="{{route('homepages.news-event.view')}}" style="color: #fff;">
                        <i class="fa fa-folder-open bigfonts" aria-hidden="true" style="font-size: 50px"></i>
                        <br/> News & Events
                    </a>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-3">
                <div style="background: #339AF0; padding: 5px; border-radius: 10px; text-align: center;">
                    <a href="{{route('contacts.comment.view')}}" style="color: #fff;"><i class="fa fa-file" aria-hidden="true" style="font-size: 50px"></i><br/> Comments</a>
                </div>
            </div>
        </div><br>
        <div class="row">
          <div class="col-md-12">
            <h4 style="padding-top:0px;">Select Criteria</h4>
          </div>
          <div class="col-md-12">
            <form id="searchForm" method="GET" action="{{route('search.policy')}}">
              <div class="form-row">
                <div class="form-group col-md-4">
                  <label class="control-label">Ministry Name</label>
                  <select name="ministry_id" id="ministry_id" class="form-control form-control-sm select2">
                    <option value="">Select Ministy</option>
                    @foreach($ministries as $ministry)
                    <option value="{{$ministry->ministry_id}}" {{(@$ministry_id==$ministry->ministry_id)?'selected':''}}>{{$ministry['ministry']['name_en']}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-4">
                  <label class="control-label">Category Name</label>
                  <select name="category_id" id="category_id" class="form-control form-control-sm select2">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                    <option value="{{$category->id}}" {{(@$category_id==$category->id)?'selected':''}}>{{$category->name_en}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-4">
                  <label class="control-label">Year</label>
                  <select name="year_id" id="year_id" class="form-control form-control-sm select2">
                    <option value="">Select Year</option>
                    @foreach($years as $year)
                    <option value="{{$year->id}}" {{(@$year_id==$year->id)?'selected':''}}>{{$year->name}}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-md-4">
                  <label class="control-label">Approval Status</label>
                  <select name="approval_status" id="approval_status" class="form-control form-control-sm select2">
                    <option value="">Select Status</option>
                    <option value="1" {{(@$approval_status=='1')?'selected':''}}>Approved</option>
                    <option value="0" {{(@$approval_status=='0')?'selected':''}}>Ongoing</option>
                  </select>
                </div>
                <div class="form-group col-md-4">
                  <label class="control-label">Publication Status</label>
                  <select name="status" id="status" class="form-control form-control-sm select2">
                    <option value="">Select Status</option>
                    <option value="1" {{(@$status=='1')?'selected':''}}>Published</option>
                    <option value="0" {{(@$status=='0')?'selected':''}}>Unpublish</option>
                  </select>
                </div>
                <input type="hidden" name="search" value="search">
                <div class="form-group col-md-2" style="padding-top:30px;">
                  <button type="submit" class="btn btn-success btn-sm btn-block"><i class="fa fa-search"></i> Search</button>
                </div>
              </div>
            </form>
          </div>
        </div><br/>
        @if(isset($search))
        <div class="row">
          <div class="col-md-12">
            <table id="dataTable" class="table table-sm table-bordered table-striped">
              <thead>
                <tr>
                  <th width="8%">SL</th>
                  <th>Title</th>
                  <th>Ministry Name</th>
                  @if($category_id==null)
                  <th>Category</th>
                  @endif
                  @if($year_id==null)
                  <th>Year</th>
                  @endif
                  @if($category_id=='2')
                  <th>Act No</th>
                  @endif
                  @if($approval_status==null)
                  <th>Approval Status</th>
                  @endif
                  @if($status==null)
                  <th>Publication Status</th>
                  @endif
                  <th width="7">Action</th>
                </tr>
              </thead>
              <tbody>
              @foreach($allData as $key=>$value)
                <tr class="{{$value->id}}">
                  <td>{{ $key + 1 }}</td>
                  <td>{{ $value->title_en }}</td>
                  <td>{{ @$value['ministry']['name_en'] }}</td>
                  @if($category_id==null)
                  <td>{{ @$value['category']['name_en'] }}</td>
                  @endif
                  @if($year_id==null)
                  <td>{{ @$value['year']['name'] }}</td>
                  @endif
                  @if($category_id=='2')
                  <td>{{ @$value['act_no']['name'] }}</td>
                  @endif
                  @if($approval_status==null)
                  <td>
                    @if($value->approval_status=='1')
                    Approved
                    @elseif($value->approval_status=='0')
                    Ongoing
                    @endif
                  </td>
                  @endif
                  @if($status==null)
                  <td>
                    @if($value->status=='1')
                    Published
                    @elseif($value->status=='0')
                    Unpublish
                    @endif
                  </td>
                  @endif
                  <td>
                    <a target="_blank" class="btn btn-sm btn-success" title="Details" href="{{route('policy.details',$value->id)}}"><i class="fa fa-eye"></i></a>
                  </td>
                </tr> 
              @endforeach               
              </tbody>
            </table>
          </div>
        </div>
        @endif
      </div>
      <!--/. container-fluid -->
    </section>

    <script type="text/javascript">
      $(document).ready(function () {
        $('#searchForm').validate({
          rules: {
            ministry_id: {
              required: true,
            }
          },
          messages: {
            
          },
          errorElement: 'span',
          errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
          },
          highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
          },
          unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
          }
        });
      });
    </script>

    <script type="text/javascript">
        $(function(){
            $(document).on('change','#ministry_id',function(){
                var ministry_id = $(this).val();
                $.ajax({
                    url:"{{route('get-category')}}",
                    type:"GET",
                    data:{ministry_id:ministry_id},
                    success:function(data){
                        var html = '<option value="">Select Category</option>';
                        $.each( data, function( key, v ) {
                            html +='<option value="'+v.category_id+'">'+v.category.name_en+'</option>';
                        });
                        $('#category_id').html(html);
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(function(){
            $(document).on('change','#category_id',function(){
                var category_id = $(this).val();
                $.ajax({
                    url:"{{route('category-wise-year')}}",
                    type:"GET",
                    data:{category_id:category_id},
                    success:function(data){
                        var html = '<option value="">Select Year</option>';
                        $.each( data, function( key, v ) {
                            html +='<option value="'+v.year_id+'">'+v.year.name+'</option>';
                        });
                        $('#year_id').html(html);
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(function(){
            $(document).on('change','#year_id',function(){
                var year_id = $(this).val();
                $.ajax({
                    url:"{{route('get-title')}}",
                    type:"GET",
                    data:{year_id:year_id},
                    success:function(data){
                        var html = '<option value="">Select Title</option>';
                        $.each( data, function( key, v ) {
                            html +='<option value="'+v.id+'">'+v.title_en+'</option>';
                        });
                        $('#title_en').html(html);
                    }
                });
            });
        });
    </script>

    <script type="text/javascript">
        $(function(){
            function showTime(){
                var date = new Date();
                var h = date.getHours();
                var m = date.getMinutes();
                var s = date.getSeconds();
                var session = "AM";            
                if(h == 0){
                    h = 12;
                }            
                if(h > 12){
                    h = h - 12;
                    session = "PM";
                }            
                h = (h < 10) ? "0" + h : h;
                m = (m < 10) ? "0" + m : m;
                s = (s < 10) ? "0" + s : s;

                var time = h + ":" + m + ":" + s + " " + session;
                document.getElementById("clock").innerText = time;            
                setTimeout(showTime, 1000);            
            }

            showTime();
        })
    </script>
@endsection

