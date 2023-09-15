@extends('admin.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            {{-- <a href="{{ route('admin.department.requisition.add') }}" class="btn btn-sm btn-info"><i class="fas fa-plus mr-1"></i> Add Department Requisition</a> --}}
                        </div>
                        <div class="card-body">
                            <form id="submitForm" action=" " method="post">
                                <div class="row px-3 py-4 border rounded shadow-sm mb-3">
                                    <div class="col-sm-5">
                                        <label class="control-label">Department <span class="text-red">*</span></label>
                                        <select name="department_id" id="department_id" class="form-control select2 @error('department_id') is-invalid @enderror">
                                            <option value="" >Please Select</option>
                                            {{-- @foreach ($product_types as $item)
                                                <option value="{{ $item->id }}" {{ @$editData->product_type_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach --}}
                                        </select>
                                        @error('product_type_id')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-sm-5">
                                        <label class="control-label">Requisition Status <span class="text-red">*</span></label>
                                        <select name="status" id="status" class="form-control select2 @error('status') is-invalid @enderror">
                                            <option value="" disabled >Please Select</option>
                                            <option value="0" >Initiated</option>
                                            <option value="1" >Approved</option>
                                            <option value="2" >Rejected</option>
                                        </select>
                                    </div> 
                                    <div class="col-sm-2">
                                        <label class="control-label" style="visibility: hidden;">Search</label>
                                        <button type="submit" class="btn btn-block btn-success btn-sm">Search</button>
                                    </div>
                                </div>
                            </form>
                            <table id="sb-data-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">SL.</th>
                                        <th>Requisition No</th>
                                        <th>Request Department</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($departmentRequisitions as $list)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ @$list->requisition_no ?? 'N/A' }}</td>
                                            <td>N/A</td>
                                            <td class="text-center">{!! activeRequisition($list->status) !!}</td>
                                            <td class="text-center">
                                                @if(sorpermission('admin.requisition.edit'))
                                                <a class="btn btn-sm btn-success" href="{{route('admin.requisition.edit',$list->id)}}">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                @endif
                                                {{-- @if(sorpermission('admin.requisition.delete'))
                                                <a class="btn btn-sm btn-danger destroy" data-id="{{$list->id}}" data-route="{{route('admin.requisition.delete')}}">
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
    <script></script>
@endsection
