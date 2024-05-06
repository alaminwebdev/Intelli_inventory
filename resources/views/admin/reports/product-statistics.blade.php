@extends('admin.layouts.app')
@section('content')
    <style>
        .select2-container--default .select2-results__option--highlighted[aria-selected],
        .select2-container--default .select2-results__option--highlighted[aria-selected]:hover {
            background-color: #0072bc;
        }

        .select2-container--default .select2-results__option--selected {
            background-color: #f8f9fa;
        }

        table,
        thead,
        th,
        tr {
            color: #2a527b !important;
        }

        table tr {
            font-size: 14px !important;
        }

        table.table-bordered.dataTable th,
        table.table-bordered.dataTable td {
            border-left-width: 1px !important;
        }
    </style>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-info"><i class="fas fa-tachometer-alt mr-1"></i>Dashboard</a>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.product.statistics') }}" id="filterForm" autocomplete="off">
                                @csrf
                                <div class="gradient-border px-3 pt-4 pb-3 mb-4">
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label class="control-label">Department <span class="text-red">*</span></label>
                                            <select name="department_id" id="department_id" class="form-control @error('department_id') is-invalid @enderror select2 ">
                                                <option value="0">All</option>
                                                @foreach ($departments as $item)
                                                    <option value="{{ $item->id }}" {{ request()->department_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('department_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label class="control-label">Section </label>
                                            <select name="section_id" id="section_id" class="form-control select2 @error('section_id') is-invalid @enderror">
                                                <option value="0">All</option>
                                                {{-- @if (request()->section_id) --}}
                                                @foreach ($sections as $item)
                                                    <option value="{{ $item->id }}" {{ request()->section_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                @endforeach
                                                {{-- @endif --}}
                                            </select>
                                            @error('section_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="date_from" class="text-navy">Start Date :</label>
                                            <input type="text" value="{{ request()->date_from }}" name="date_from" class="form-control form-control-sm text-gray singledatepicker" id="date_from" placeholder="Start Date">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="date_to" class="text-navy">End Date :</label>
                                            <input type="text" value="{{ request()->date_to }}" name="date_to" class="form-control form-control-sm text-gray singledatepicker" id="date_to" placeholder="End Date">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label d-block" style="visibility: hidden;">Search</label>
                                            <button type="submit" name="type" value="search" style="box-shadow:rgba(40, 167, 69, 0.30) 0px 8px 18px 4px" class="btn btn-success btn-sm"><i class="fas fa-search mr-1"></i>Search</button>
                                            @if (isset($productStatistics) && count($productStatistics) > 0)
                                                <button type="submit" class="btn btn-sm btn-primary" name="type" value="pdf" style="box-shadow:rgba(13, 109, 253, 0.25) 0px 8px 18px 4px"><i class="fas fa-file-pdf mr-1"></i> PDF</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <table id="" class="table table-bordered">
                                <thead style="background: #fff4f4 !important;">
                                    <tr>
                                        <th width="5%">Sl.</th>
                                        <th class="text-center">Product</th>
                                        <th class="text-center">Unit</th>
                                        <th class="text-center">Demand Quantity</th>
                                        <th class="text-center">Distribute Quantity</th>
                                        <th class="text-center">Temporary Stock</th>
                                        <th class="text-center">Current Stock</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productStatistics as $list)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ @$list['product'] ?? 'N/A' }}</td>
                                            <td>{{ @$list['unit'] ?? 'N/A' }}</td>
                                            <td class="text-right">{{ @$list['demand_quantity'] ?? 'N/A' }}</td>
                                            <td class="text-right">{{ @$list['distribute_quantity'] ?? 'N/A' }}</td>
                                            <td class="text-right">{{ @$list['temporary_stock'] ?? 'N/A' }}</td>
                                            <td class="text-right">{{ @$list['current_stock'] ?? 'N/A' }}</td>
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
    <script>
        $(function() {

            $(document).on('change', '#department_id', function() {
                let department_id = $(this).val();
                console.log(department_id);
                $.ajax({
                    url: "{{ route('admin.get.sections.by.department') }}",
                    type: "GET",
                    data: {
                        department_id: department_id
                    },
                    success: function(data) {
                        console.log(data);
                        // Handle the data here
                        let section_div = document.getElementById('section_id');
                        section_div.innerHTML = '<option value="0">All</option>';
                        data.forEach(item => {
                            section_div.innerHTML +=
                                `<option value="${item.id}">${item.name}</option>`;
                        });
                    }
                });
            });
        });
    </script>
    <script>
        $(function() {
            $(document).on('click', '[name=type]', function(e) {
                var type = $(this).attr('value');
                if (type == 'pdf') {
                    $('#filterForm').attr('target', '_blank');
                } else {
                    $('#filterForm').removeAttr('target');
                }
            });
        })
    </script>
@endsection
