@extends('admin.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            @if (sorpermission('admin.user-management.user-info.add'))
                                <a href="{{ route('admin.user-management.user-info.add') }}" class="btn btn-sm btn-info"><i class="fas fa-plus"></i> Add User</a>
                            @endif
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.user-management.user-info.list') }}" method="get">
                                <div class="row px-3 py-4 border rounded shadow-sm mb-3">
                                    {{-- <div class="col-sm-3">
                                                <label class="control-label">Designation</label>
                                                <select id="designation_id" name="designation_id" class="form-control form-control-sm designation_id select2">
                                                    <option value="">Select Designation</option>
                                                    @if (@$main_topics)
                                                        @foreach ($main_topics as $list)
                                                            <option {{ request()->designation_id == $list->id ? 'selected' : '' }} value="{{ $list->id }}">{{ $list->name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div> --}}
                                    <div class="col-sm-3">
                                        <label class="control-label">Role</label>
                                        <select name="role_ids[]" id="role_ids" class="form-control form-control-sm role_ids select2" multiple>
                                            @if (@$roles)
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}" {{ request()->role_ids ? (in_array($role->id, request()->role_ids) ? 'selected' : '') : '' }}>{{ $role->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="control-label">Name</label>
                                        <input type="text" id="name" class="form-control form-control-sm name" name="name" value="{{ request()->name }}" placeholder="Name">
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="control-label">Email</label>
                                        <input type="text" id="email" class="form-control form-control-sm email" name="email" value="{{ request()->email }}" placeholder="Email">
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="control-label">Mobile No</label>
                                        <input type="text" id="mobile_no" class="form-control form-control-sm mobile_no" name="mobile_no" value="{{ request()->mobile_no }}" placeholder="Mobile No">
                                    </div>
                                    <div class="col-sm-2">
                                        <label class="control-label">Status</label>
                                        <select name="status" id="status" class="form-control form-control-sm status select2">
                                            <option value="">Select Status</option>
                                            <option value="1" {{ request()->status == '1' ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ request()->status == '0' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-1">
                                        <label class="control-label" style="visibility: hidden;">Search</label>
                                        <button type="submit" class="btn btn-info btn-sm"><i class="fa fa-search"></i> Search</button>
                                    </div>
                                </div>
                            </form>
                            <table id="sb-data-table" class="table table-sm table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">SL.</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile No</th>
                                        <th>Designation</th>
                                        {{-- <th>Working Place</th> --}}
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th width="10%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="sortable" class="sortable">
                                    @foreach ($users as $list)
                                        <tr data-id="{{ $list->id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ @$list->name ?? 'N/A' }}</td>
                                            <td>{{ @$list->email ?? 'N/A' }}</td>
                                            <td>{{ @$list->mobile_no ?? 'N/A' }}</td>
                                            <td>
                                                @if (@$list->designation_id != null)
                                                    {{ @$list->designation->name ?? 'N/A' }}
                                                @elseif(@$list->employee_id != null)
                                                    {{ @$list->employee->employee_designation->name ?? 'N/A' }}
                                                @endif
                                            </td>
                                            {{-- <td>{{ @$list->working_place ?? 'N/A' }}</td> --}}
                                            <td>
                                                {!! '<span class="badge badge-success mr-1">' .
                                                    implode(
                                                        '</span><span class="badge badge-success mr-1">',
                                                        $list->user_roles->pluck('role_details')->pluck('name')->toArray(),
                                                    ) .
                                                    '</span>' !!}
                                            </td>
                                            <td>{!! activeStatus($list->status) !!}</td>
                                            <td class="text-center">
                                                @if (sorpermission('admin.user-management.user-info.edit'))
                                                    <a class="btn btn-sm btn-success" href="{{ route('admin.user-management.user-info.edit', $list->id) }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endif
                                                {{-- @if (sorpermission('admin.user-management.user-info.destroy'))
                                                    <a class="btn btn-sm btn-danger deactivate" data-id="{{ $list->id }}" data-route="{{ route('admin.user-management.user-info.destroy') }}">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                @endif --}}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <script type="text/javascript">
	$(function(){
		$("#sortable").sortable({
			update:function(event, ui){
				var jsonSortable = [];
				jsonSortable.length = 0;
				$("#sortable tr").each(function (index, value){
					let item = {};
					item.id = $(this).data("id");
					jsonSortable.push(item);
				});

				var jsondata = JSON.stringify(jsonSortable);
				$.ajax({
					url: "{{route('admin.user-management.user-info.sorting')}}",
					type: "get",
					data: {jsondata:jsondata},
					dataType: 'json',
					success: function (data) {
						console.log(data);
					}
				});
			}
		}).disableSelection();
	})
</script> --}}

    {{-- <script>
        $(document).on('click', '.deactivate', function() {
            var thisBtn = $(this);
            var url = $(thisBtn).data('route');
            var id = $(thisBtn).data('id');

            Swal.fire({
                icon: 'error',
                iconHtml: '<i class="fa fa-trash"></i>',
                title: 'নিষ্ক্রিয় করুন',
                showCancelButton: true,
                confirmButtonText: 'হ্যাঁ, এটি নিষ্ক্রিয় করুন!',
                cancelButtonText: 'না, বাতিল করুন!',
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return $.ajax({
                            'url': url,
                            'type': 'POST',
                            'data': {
                                _token: $('[name=csrf-token]').attr('content'),
                                id: id
                            },
                        }).then(response => {
                            if (response.status != 'success') {
                                throw new Error(response.message)
                            }
                            return response;
                        })
                        .catch(error => {
                            Swal.showValidationMessage(error.message ? error.message : error.responseJSON.message)
                        })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: "success",
                        title: 'সফলভাবে নিষ্ক্রিয় করা হয়েছে',
                    }).then(() => {
                        // Reload the page
                        location.reload();
                    });
                    // $(thisBtn).parents('tr').hide('');

                }
            });
        });
    </script> --}}
@endsection
